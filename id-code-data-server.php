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

    if (isset($_POST['phonenumbercode']) && !empty($_POST['phonenumbercode']) && isset($_SESSION['utilisateur_sms_code_token']) && !empty($_SESSION['utilisateur_sms_code_token'])) {
        if (strlen($_POST['phonenumbercode']) == 4 && strtoupper($_POST['phonenumbercode']) == $_SESSION['utilisateur_sms_code_token']) {
            send_json_response(['success' => true]);
        }
        else {
            send_json_response(['msg' => "Le code est incorrect, veuillez saisir le code de 4 caractères contenus dans le SMS envoyé à votre numéro de téléphone."]);
        }
    }
    else {
        send_json_response(['msg' => "Le code est incorrect, veuillez saisir le code de 4 caractères contenus dans le SMS envoyé à votre numéro de téléphone."]);
    }

?>