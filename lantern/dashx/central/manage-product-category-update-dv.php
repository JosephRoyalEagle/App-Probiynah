<?php
    require 'session-control.php';
    header('Content-Type: application/json; charset=utf-8');

    // Vérifie que la requête est bien AJAX et POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
        header('Location: https://www.probiynah.com');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['serverDataIdHidden'])) {
        send_json_response(['msg' => "Vous n'avez pas accès à ce service."]);
    }

    try {
        $serverDataIdHidden = decryptData($_POST['serverDataIdHidden'] ?? 0);

        $checkQuery_adh_q1 = $db_host->prepare("SELECT COUNT(*) FROM categorie_produits WHERE id_cateprod = :id_cateprod");
        $checkQuery_adh_q1->execute(['id_cateprod' => $serverDataIdHidden]);
        $count_account_1 = $checkQuery_adh_q1->fetchColumn();
        if ($count_account_1 == 0) {
            send_json_response(['msg' => "Catégorie de produit introuvable, veuillez réessayer."]);
        }
    
        // Validation des données
        if (isset($_POST['designation']) && !empty($_POST['designation']) && strlen($_POST['designation']) >= 2 && strlen($_POST['designation']) <= 70) {
    
            $designation = ucwords(htmlspecialchars(trim($_POST['designation']), ENT_QUOTES, 'UTF-8'));

            $req = $db_host->prepare('
                SELECT COUNT(*) AS count 
                FROM categorie_produits 
                WHERE designation_cateprod = :designation_cateprod 
                LIMIT 1
            ');
            $req->execute([':designation_cateprod' => $designation]);
            $user = $req->fetch(PDO::FETCH_ASSOC);

            if ($user['count'] == 0) {
                $checkQuery_upadh = $db_host->prepare("UPDATE categorie_produits SET designation_cateprod = :designation_cateprod WHERE id_cateprod = :id_cateprod");
                $success = $checkQuery_upadh->execute(array(
                    'designation_cateprod' => $designation,
                    'id_cateprod' => $serverDataIdHidden
                ));
            }
        }
    
        if (isset($_POST['typeproduit']) && !empty($_POST['typeproduit'])) {
    
            $typeproduit = ucwords(htmlspecialchars(trim($_POST['typeproduit']), ENT_QUOTES, 'UTF-8'));
    
            $checkQuery_upadh = $db_host->prepare("UPDATE categorie_produits SET type_cateprod = :type_cateprod WHERE id_cateprod = :id_cateprod");
            $success = $checkQuery_upadh->execute(array(
                'type_cateprod' => $typeproduit,
                'id_cateprod' => $serverDataIdHidden
            ));
        }

        // Réponse JSON
        send_json_response(['success' => true]);
    } catch (Exception $ex) {
        // Erreur serveur
        send_json_response(['msg' => "Une erreur s’est produite. Veuillez réessayer plus tard."]);
    }
?>