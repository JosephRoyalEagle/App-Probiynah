<?php
    require 'session-control.php';
    header('Content-Type: application/json; charset=utf-8');

    // Vérifie que la requête est bien AJAX et POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
        header('Location: https://www.probiynah.com');
        exit();
    }

    // Validation des données
    if (!isset($_POST['nomUserForm']) || empty($_POST['nomUserForm']) || strlen($_POST['nomUserForm']) < 2 || strlen($_POST['nomUserForm']) > 70) {
        send_json_response(['msg' => "Saisissez au moins un nom de famille valide."]);
    }

    if (!isset($_POST['prenomUserForm']) || empty($_POST['prenomUserForm']) || strlen($_POST['prenomUserForm']) < 2 || strlen($_POST['prenomUserForm']) > 50) {
        send_json_response(['msg' => "Saisissez au moins un prénom valide."]);
    }

    if (!isset($_POST['phoneUserForm']) || !preg_match('/^\d{10}$/', $_POST['phoneUserForm'])) {
        send_json_response(['msg' => "Veuillez saisir un numéro de téléphone valide de 10 chiffres."]);
    }

    $phoneUserForm = '225' . $_POST['phoneUserForm'];
    if (!preg_match('/^\d+$/', $phoneUserForm)) {
        send_json_response(['msg' => "Le numéro doit contenir uniquement des chiffres."]);
    }

    if (!isset($_POST['typecompteUserForm']) || empty($_POST['typecompteUserForm']) || ($_POST['typecompteUserForm'] !== 'SAdmin' && $_POST['typecompteUserForm'] !== 'Gestionnaire')) {
        send_json_response(['msg' => "Sélectionnez un type de compte valide."]);
    }

    if (!isset($_POST['passwordUserForm']) || strlen($_POST['passwordUserForm']) < 4 || strlen($_POST['passwordUserForm']) > 100) {
        send_json_response(['msg' => "Veuillez saisir un mot de passe entre 4 et 100 caractères."]);
    }

    $passwordUserForm = password_hash($_POST['passwordUserForm'], PASSWORD_BCRYPT, ['cost' => 12]);
    $nomUserForm = ucwords(htmlspecialchars(trim($_POST['nomUserForm']), ENT_QUOTES, 'UTF-8'));
    $prenomUserForm = ucwords(htmlspecialchars(trim($_POST['prenomUserForm']), ENT_QUOTES, 'UTF-8'));
    $typecompteUserForm = htmlspecialchars(trim($_POST['typecompteUserForm']), ENT_QUOTES, 'UTF-8');

    try {
        // Vérifie que le numero de téléphone n'est pas utilisé
        $req = $db_host->prepare('
            SELECT COUNT(*) AS count 
            FROM utilisateurs 
            WHERE numero_utilis = :tel 
            LIMIT 1
        ');
        $req->execute([':tel' => $phoneUserForm]);
        $user = $req->fetch(PDO::FETCH_ASSOC);

        if ($user['count'] > 0) {
            send_json_response(['msg' => "Un compte existe déjà avec ce numéro de téléphone, veuillez le changer."]);
        }

        // Enregistrement de l'utilisateur
        $order = $db_host->prepare('
            INSERT INTO utilisateurs (numero_utilis, motdepasse_utilis, nom_utilis, prenom_utilis, dateinscription_utilis, heureinscription_utilis, role_utilis, statut_utilis, createur_utilis)
            VALUES (:tel, :pass, :nom, :prenom, :date, :heure, :role, "Actif", :createur)
        ');

        $order->execute([
            ':tel' => $phoneUserForm,
            ':pass' => $passwordUserForm,
            ':nom' => $nomUserForm,
            ':prenom' => $prenomUserForm,
            ':date' => dateUTC()->format('Y-m-d'),
            ':heure' => dateUTC()->format('H\h i\m\i\n s\s'),
            ':role' => $typecompteUserForm,
            ':createur' => $_SESSION['appro_connect_active_id_token']
        ]);
        

        if (!$order) {
            send_json_response(['msg' => "Une erreur s’est produite lors de la création du compte, veuillez réessayer."]);
        }

        // Réponse JSON
        send_json_response(['success' => true]);

    } catch (Exception $ex) {
        // Erreur serveur
        send_json_response(['msg' => "Une erreur s’est produite. Veuillez réessayer plus tard."]);
    }
?>