<?php
    require 'session-control.php';
    header('Content-Type: application/json; charset=utf-8');

    // Vérifie que la requête est bien AJAX et POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
        header('Location: https://www.probiynah.com');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['keyUserForm'])) {
        send_json_response(['msg' => "Vous n'avez pas accès à ce service."]);
    }

    try {
        $keyUserForm = decryptData($_POST['keyUserForm'] ?? 0);

        $checkQuery_adh_q1 = $db_host->prepare("SELECT COUNT(*) FROM utilisateurs WHERE id_utilis = :id_utilis");
        $checkQuery_adh_q1->execute(['id_utilis' => $keyUserForm]);
        $count_account_1 = $checkQuery_adh_q1->fetchColumn();
        if ($count_account_1 == 0) {
            send_json_response(['msg' => "Compte introuvable, veuillez réessayer."]);
        }
    
        // Validation des données
        if (isset($_POST['phoneUserForm']) AND preg_match('/^\d{10}$/', $_POST['phoneUserForm'])) {
            $phoneUserForm = '225' . $_POST['phoneUserForm'];
            if (preg_match('/^\d+$/', $phoneUserForm)) {
    
                $req = $db_host->prepare('
                    SELECT COUNT(*) AS count 
                    FROM utilisateurs 
                    WHERE numero_utilis = :tel 
                    LIMIT 1
                ');
                $req->execute([':tel' => $phoneUserForm]);
                $user = $req->fetch(PDO::FETCH_ASSOC);
    
                if ($user['count'] == 0) {
                    $checkQuery_upadh = $db_host->prepare("UPDATE utilisateurs SET numero_utilis = :numero_utilis WHERE id_utilis = :id_utilis");
                    $success = $checkQuery_upadh->execute(array(
                        'numero_utilis' => $phoneUserForm,
                        'id_utilis' => $keyUserForm
                    ));
                }
            }
        }
    
        if (isset($_POST['nomUserForm']) && !empty($_POST['nomUserForm']) && strlen($_POST['nomUserForm']) >= 2 && strlen($_POST['nomUserForm']) <= 50) {
    
            $nomUserForm = ucwords(htmlspecialchars(trim($_POST['nomUserForm']), ENT_QUOTES, 'UTF-8'));
    
            $checkQuery_upadh = $db_host->prepare("UPDATE utilisateurs SET nom_utilis = :nom_utilis WHERE id_utilis = :id_utilis");
            $success = $checkQuery_upadh->execute(array(
                'nom_utilis' => $nomUserForm,
                'id_utilis' => $keyUserForm
            ));
        }
    
        if (isset($_POST['prenomUserForm']) && !empty($_POST['prenomUserForm']) && strlen($_POST['prenomUserForm']) >= 2 && strlen($_POST['prenomUserForm']) <= 50) {
    
            $prenomUserForm = ucwords(htmlspecialchars(trim($_POST['prenomUserForm']), ENT_QUOTES, 'UTF-8'));
    
            $checkQuery_upadh = $db_host->prepare("UPDATE utilisateurs SET prenom_utilis = :prenom_utilis WHERE id_utilis = :id_utilis");
            $success = $checkQuery_upadh->execute(array(
                'prenom_utilis' => $prenomUserForm,
                'id_utilis' => $keyUserForm
            ));
        }

        if (isset($_POST['typecompteUserForm']) && !empty($_POST['typecompteUserForm']) && ($_POST['typecompteUserForm'] == "SAdmin" || $_POST['typecompteUserForm'] == "Gestionnaire")) {
    
            $typecompteUserForm = htmlspecialchars(trim($_POST['typecompteUserForm']), ENT_QUOTES, 'UTF-8');
    
            $checkQuery_upadh = $db_host->prepare("UPDATE utilisateurs SET role_utilis = :role_utilis WHERE id_utilis = :id_utilis");
            $success = $checkQuery_upadh->execute(array(
                'role_utilis' => $typecompteUserForm,
                'id_utilis' => $keyUserForm
            ));
        }
    
        if (isset($_POST['statutUserForm']) && !empty($_POST['statutUserForm']) && ($_POST['statutUserForm'] == "Actif" || $_POST['statutUserForm'] == "Verrouiller")) {
    
            $statutUserForm = ucwords(htmlspecialchars(trim($_POST['statutUserForm']), ENT_QUOTES, 'UTF-8'));
    
            $checkQuery_upadh = $db_host->prepare("UPDATE utilisateurs SET statut_utilis = :statut_utilis WHERE id_utilis = :id_utilis");
            $success = $checkQuery_upadh->execute(array(
                'statut_utilis' => $statutUserForm,
                'id_utilis' => $keyUserForm
            ));
        }

        // Réponse JSON
        send_json_response(['success' => true]);
    } catch (Exception $ex) {
        // Erreur serveur
        send_json_response(['msg' => "Une erreur s’est produite. Veuillez réessayer plus tard."]);
    }
?>