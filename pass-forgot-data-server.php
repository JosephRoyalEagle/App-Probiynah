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

    $phonenumber = '225' . $_POST['phonenumber'];
    if (!preg_match('/^\d+$/', $phonenumber)) {
        send_json_response(['msg' => "Le numéro doit contenir uniquement des chiffres."]);
    }

    try {
        // Vérifie que l'utilisateur existe et est actif
        $stmt = $db_host->prepare('
            SELECT id_utilis, numero_utilis, motdepasse_utilis, role_utilis 
            FROM utilisateurs 
            WHERE numero_utilis = :tel AND statut_utilis = "Actif"
            LIMIT 1
        ');
        $stmt->execute([':tel' => $phonenumber]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        if (!$user) {
            send_json_response(['msg' => "Aucun compte actif n'est associé à ce numéro de téléphone."]);
        }

        // Session
        $_SESSION['utilisateur_phone_token'] = '+' . $user['numero_utilis'];
        $_SESSION['utilisateur_id_token'] = (int) $user['id_utilis'];
        $_SESSION['utilisateur_sms_date_token'] = date('Y-m-d');
        $_SESSION['utilisateur_sms_code_token'] = substr(str_shuffle("123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4);
        $_SESSION['utilisateur_sms_letter_token'] = "Code de confirmation d'identité : " . $_SESSION['utilisateur_sms_code_token'];

        // Vérifie le nombre de SMS déjà envoyés ce jour-là
        $stmt_sms = $db_host->prepare('
            SELECT COUNT(*) AS cpt 
            FROM utilisateurs_sms 
            WHERE id_utilis = :id AND date_utilsms = :date
        ');
        $stmt_sms->execute([
            ':id' => $_SESSION['utilisateur_id_token'],
            ':date' => $_SESSION['utilisateur_sms_date_token']
        ]);
        $sms_count_result = $stmt_sms->fetch(PDO::FETCH_ASSOC);

        $_SESSION['utilisateur_sms_count_token'] = (int) $sms_count_result['cpt'];

        if ($_SESSION['utilisateur_sms_count_token'] > 4) {
            send_json_response(['msg' => "Le compte associé à ce numéro a atteint le nombre maximum de SMS autorisé aujourd’hui. Réessayez plus tard."]);
        }

        // Envoi SMS (via Infobip)
        $text = $_SESSION['utilisateur_sms_letter_token'];
        $to = $_SESSION['utilisateur_phone_token'];
        require('info.php');

        if (!isset($httpCode) || $httpCode < 200 || $httpCode >= 300) {
            send_json_response(['msg' => "Erreur lors de l’envoi du SMS. Veuillez réessayer plus tard."]);
        }

        $_SESSION['utilisateur_sms_count_token'] += 1;

        $stmt_insert_sms = $db_host->prepare('
            INSERT INTO utilisateurs_sms (id_utilis, date_utilsms, heure_utilsms, nombre_utilsms, code_utilsms) 
            VALUES (?, ?, ?, ?, ?)
        ');
        $stmt_insert_sms->execute([
            $_SESSION['utilisateur_id_token'],
            $_SESSION['utilisateur_sms_date_token'],
            dateUTC()->format('H\h i\m\i\n s\s'),
            $_SESSION['utilisateur_sms_count_token'],
            $_SESSION['utilisateur_sms_code_token']
        ]);
        $stmt_insert_sms->closeCursor();

        send_json_response(['success' => true]);

    } catch (Exception $ex) {
        send_json_response(['msg' => "Une erreur est survenue lors de l’authentification. Veuillez réessayer plus tard."]);
    }
?>