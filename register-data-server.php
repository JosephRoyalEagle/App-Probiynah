<?php
    require 'session-start.php';
    require 'dbcaller/dbcaller.php';
    require 'fonction.php';

    header('Content-Type: application/json; charset=utf-8');

    // Vérifie que la requête est bien AJAX et POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
        header('Location: https://www.probiynah.com');
        exit();
    }

    // Validation des données
    if (!isset($_POST['phonenumber']) || !preg_match('/^\d{10}$/', $_POST['phonenumber'])) {
        send_json_response(['msg' => "Veuillez saisir un numéro de téléphone valide de 10 chiffres."]);
    }

    if (!isset($_POST['password']) || strlen($_POST['password']) < 4 || strlen($_POST['password']) > 100) {
        send_json_response(['msg' => "Veuillez saisir un mot de passe entre 4 et 100 caractères."]);
    }

    if (!isset($_POST['lastname']) || empty($_POST['lastname']) || strlen($_POST['lastname']) < 2 || strlen($_POST['lastname']) > 70) {
        send_json_response(['msg' => "Saisissez au moins un nom de famille valide."]);
    }

    if (!isset($_POST['firstname']) || empty($_POST['firstname']) || strlen($_POST['firstname']) < 2 || strlen($_POST['firstname']) > 50) {
        send_json_response(['msg' => "Saisissez au moins un prénom valide."]);
    }

    $phonenumber = '225' . $_POST['phonenumber'];
    if (!preg_match('/^\d+$/', $phonenumber)) {
        send_json_response(['msg' => "Le numéro doit contenir uniquement des chiffres."]);
    }

    $password = password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost' => 12]);
    $lastname = ucwords(htmlspecialchars(trim($_POST['lastname']), ENT_QUOTES, 'UTF-8'));
    $firstname = ucwords(htmlspecialchars(trim($_POST['firstname']), ENT_QUOTES, 'UTF-8'));

    try {
        // Vérifie que le numero de téléphone n'est pas utilisé
        $req = $db_host->prepare('
            SELECT COUNT(*) AS count 
            FROM utilisateurs 
            WHERE numero_utilis = :tel 
            LIMIT 1
        ');
        $req->execute([':tel' => $phonenumber]);
        $user = $req->fetch(PDO::FETCH_ASSOC);

        if ($user['count'] > 0) {
            send_json_response(['msg' => "Un compte existe déjà avec ce numéro de téléphone, pensez à vous connecter."]);
        }

        // Enregistrement de l'utilisateur
        $order = $db_host->prepare('
            INSERT INTO utilisateurs (numero_utilis, motdepasse_utilis, nom_utilis, prenom_utilis, dateinscription_utilis, heureinscription_utilis, role_utilis, statut_utilis)
            VALUES (:tel, :pass, :nom, :prenom, :date, :heure, "Client", "Actif")
        ');
        $order->execute([
            ':tel' => $phonenumber,
            ':pass' => $password,
            ':nom' => $lastname,
            ':prenom' => $firstname,
            ':date' => dateUTC()->format('Y-m-d'),
            ':heure' => dateUTC()->format('H\h i\m\i\n s\s')
        ]);

        if (!$order) {
            send_json_response(['msg' => "Une erreur s’est produite lors de la création du compte, veuillez réessayer."]);
        }

        // Vérifie que l'utilisateur existe
        $req_search_user = $db_host->prepare('
            SELECT id_utilis, motdepasse_utilis, role_utilis 
            FROM utilisateurs 
            WHERE numero_utilis = :tel 
            AND statut_utilis = "Actif"
            LIMIT 1
        ');
        $req_search_user->execute([':tel' => $phonenumber]);
        $rponse_search_user = $req_search_user->fetch(PDO::FETCH_ASSOC);

        if (!$rponse_search_user) {
            send_json_response(['msg' => "Erreur inattendue lors de la création du compte, veuillez réessayer."]);
        }
        
        // Session
        $_SESSION['appro_connect_active_id_token'] = (int) $rponse_search_user['id_utilis'];
        $_SESSION['appro_connect_active_type_token'] = $rponse_search_user['role_utilis'];

        // Génération d'un token sécurisé
        $token = '';
        $token_expiry = time() + (30 * 24 * 60 * 60);
        $attempts = 0;
        $maxAttempts = 5;
        do {
            if ($attempts++ >= $maxAttempts) {
                send_json_response(['msg' => "Erreur inattendue lors de la création du compte, veuillez réessayer."]);
            }
            $token = bin2hex(random_bytes(64));
            $check = $db_host->prepare("SELECT COUNT(*) FROM utilisateurs_logs WHERE token_utilislogs = ?");
            $check->execute([$token]);
            $exists = $check->fetchColumn();
        } while ($exists);

        // Définir le cookie avec les options sécurisées
        setcookie(
            "ApproAuthToken",
            $token,
            [
                'expires' => $token_expiry,
                'path' => '/',
                'secure' => true,
                'httponly' => true,
                'samesite' => 'None',
            ]
        );

        // Log de connexion
        $log = $db_host->prepare('INSERT INTO utilisateurs_logs (
            id_utilis, ip_utilislogs, os_utilislogs, navigateur_utilislogs,
            date_utilislogs, heure_utilislogs, token_utilislogs, expire_le_utilislogs
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');

        $log->execute([
            $_SESSION['appro_connect_active_id_token'],
            get_user_ip(),
            get_user_os(),
            get_user_browser(),
            dateUTC()->format('Y-m-d'),
            dateUTC()->format('H\h i\m\i\n s\s'),
            $token,
            $token_expiry
        ]);

        // Réponse JSON
        send_json_response(['success' => true]);

    } catch (Exception $ex) {
        // Erreur serveur
        send_json_response(['msg' => "Une erreur s’est produite. Veuillez réessayer plus tard."]);
    }
?>