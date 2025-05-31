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

    if (!isset($_POST['setnewpwd']) || empty($_POST['setnewpwd']) || 
        !isset($_POST['confnewpwd']) || empty($_POST['confnewpwd'])) {
        
        send_json_response(['msg' => "Veuillez saisir un mot de passe d'au moins 4 caractères et le confirmer avec le même mot de passe."]);
    }

    if (
        strlen($_POST['setnewpwd']) < 4 || strlen($_POST['setnewpwd']) > 100 || 
        strlen($_POST['confnewpwd']) < 4 || strlen($_POST['confnewpwd']) > 100 || 
        $_POST['setnewpwd'] !== $_POST['confnewpwd']
    ) {
        send_json_response(['msg' => "Veuillez saisir un mot de passe d'au moins 4 caractères et le confirmer avec le même mot de passe."]);
    }


    try {
        $motdepasse_utilis = password_hash($_POST['setnewpwd'], PASSWORD_BCRYPT, ['cost' => 12]);

        $order = $db_host->prepare('UPDATE utilisateurs SET motdepasse_utilis = :motdepasse_utilis WHERE id_utilis = :id_utilis');
        $order->execute(array(
            ':motdepasse_utilis' => $motdepasse_utilis, 
            ':id_utilis' => $_SESSION['utilisateur_id_token']
        ));

        require 'session-empty.php';
        send_json_response(['success' => true]);
    } catch (Exception $ex) {
        send_json_response(['msg' => "Une erreur s’est produite lors de la sauveagarde des données, veuillez réessayer."]);
    }
?>