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

    $phonenumber = '225' . $_POST['phonenumber'];
    if (!preg_match('/^\d+$/', $phonenumber)) {
        send_json_response(['msg' => "Le numéro doit contenir uniquement des chiffres."]);
    }
    $password = $_POST['password'];

    try {
        // Vérifie que l'utilisateur existe et est actif
        $req = $db_host->prepare('
            SELECT id_utilis, motdepasse_utilis, role_utilis 
            FROM utilisateurs 
            WHERE numero_utilis = :tel 
            AND statut_utilis = "Actif"
            LIMIT 1
        ');
        $req->execute([':tel' => $phonenumber]);
        $user = $req->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['motdepasse_utilis'])) {
            send_json_response(['msg' => "Identifiant ou mot de passe incorrect, veuillez réessayer."]);
        }

        // Session
        $_SESSION['appro_connect_active_id_token'] = (int) $user['id_utilis'];
        $_SESSION['appro_connect_active_type_token'] = $user['role_utilis'];

        // Génération d'un token sécurisé
        $token = '';
        $token_expiry = time() + (30 * 24 * 60 * 60);
        $attempts = 0;
        $maxAttempts = 5;
        do {
            if ($attempts++ >= $maxAttempts) {
                send_json_response(['msg' => "Erreur inattendue lors de la connexion, veuillez réessayer."]);
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