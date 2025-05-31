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

        $checkQuery_adh_q1 = $db_host->prepare("SELECT COUNT(*) AS count, logo_offreur_devis FROM devis WHERE id_devis = :id_devis");
        $checkQuery_adh_q1->execute(['id_devis' => $serverDataIdHidden]);
        $count_account_1 = $checkQuery_adh_q1->fetch(PDO::FETCH_ASSOC);
        if ($count_account_1['count'] == 0) {
            send_json_response(['msg' => "Le devis est introuvable, veuillez réessayer."]);
        }

        // Sauvegarde de l'ancien nom du devis
        $pictureFile = trim($count_account_1['logo_offreur_devis']);
        $oldFile = "../../uploads/devis/".$pictureFile;
    
        // Validation des données    
        if (isset($_POST['nomEmetteurDevis']) && !empty($_POST['nomEmetteurDevis']) && strlen($_POST['nomEmetteurDevis']) >= 2 && strlen($_POST['nomEmetteurDevis']) <= 50) {
    
            $nomEmetteurDevis = ucwords(htmlspecialchars(trim($_POST['nomEmetteurDevis']), ENT_QUOTES, 'UTF-8'));
    
            $checkQuery_upadh = $db_host->prepare("UPDATE devis SET nom_offreur_devis = :nom_offreur_devis WHERE id_devis = :id_devis");
            $success = $checkQuery_upadh->execute(array(
                'nom_offreur_devis' => $nomEmetteurDevis,
                'id_devis' => $serverDataIdHidden
            ));
        }

        if (isset($_POST['phoneEmetteurDevis']) && !empty($_POST['phoneEmetteurDevis']) && strlen($_POST['phoneEmetteurDevis']) >= 7 && strlen($_POST['phoneEmetteurDevis']) <= 20) {
    
            $phoneEmetteurDevis = htmlspecialchars(trim($_POST['phoneEmetteurDevis']), ENT_QUOTES, 'UTF-8');
    
            $checkQuery_upadh = $db_host->prepare("UPDATE devis SET tel_offreur_devis = :tel_offreur_devis WHERE id_devis = :id_devis");
            $success = $checkQuery_upadh->execute(array(
                'tel_offreur_devis' => $phoneEmetteurDevis,
                'id_devis' => $serverDataIdHidden
            ));
        }

        if (isset($_POST['emailEmetteurDevis']) && !empty($_POST['emailEmetteurDevis']) && filter_var($_POST['emailEmetteurDevis'], FILTER_VALIDATE_EMAIL) && strlen($_POST['emailEmetteurDevis']) <= 100) {
    
            $emailEmetteurDevis = htmlspecialchars(trim($_POST['emailEmetteurDevis']), ENT_QUOTES, 'UTF-8');
    
            $checkQuery_upadh = $db_host->prepare("UPDATE devis SET email_offreur_devis = :email_offreur_devis WHERE id_devis = :id_devis");
            $success = $checkQuery_upadh->execute(array(
                'email_offreur_devis' => $emailEmetteurDevis,
                'id_devis' => $serverDataIdHidden
            ));
        }

        if (isset($_POST['adresseEmetteurDevis']) && !empty($_POST['adresseEmetteurDevis']) && strlen($_POST['adresseEmetteurDevis']) >= 2 && strlen($_POST['adresseEmetteurDevis']) <= 50) {
    
            $adresseEmetteurDevis = htmlspecialchars(trim($_POST['adresseEmetteurDevis']), ENT_QUOTES, 'UTF-8');
    
            $checkQuery_upadh = $db_host->prepare("UPDATE devis SET adresse_offreur_devis = :adresse_offreur_devis WHERE id_devis = :id_devis");
            $success = $checkQuery_upadh->execute(array(
                'adresse_offreur_devis' => $adresseEmetteurDevis,
                'id_devis' => $serverDataIdHidden
            ));
        }

        if (isset($_FILES['imageDevis']) && $_FILES['imageDevis']['error'] === 0) {
            $allowedTypes = ['image/png', 'image/jpeg', 'image/jpg'];
            $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($fileInfo, $_FILES['imageDevis']['tmp_name']);
            finfo_close($fileInfo);
        
            if (in_array($mimeType, $allowedTypes)) {
                // Génération du nom de fichier unique
                $extension = pathinfo($_FILES['imageDevis']['name'], PATHINFO_EXTENSION);
                $allowedExts = ['jpg', 'jpeg', 'png'];
                if (in_array(strtolower($extension), $allowedExts)) {
                    // Générer un nom unique avec ta fonction perso
                    $uniqueFilename = generateCustomFilename('img-devis-', strtolower($extension));

                    // Définir le dossier d’upload (2 niveaux au-dessus)
                    $uploadDir = dirname(__DIR__, 2) . '/uploads/devis/';
                    $uploadPath = $uploadDir . $uniqueFilename;

                    // TRAITEMENT IMAGE
                    $tmpFile = $_FILES['imageDevis']['tmp_name'];
                    if (resizeImageToHeight($tmpFile, $uploadPath, 250)) {
                        $checkQuery_upadh = $db_host->prepare("UPDATE devis SET logo_offreur_devis = :logo_offreur_devis WHERE id_devis = :id_devis");
                        $success = $checkQuery_upadh->execute(array(
                            'logo_offreur_devis' => $uniqueFilename,
                            'id_devis' => $serverDataIdHidden
                        ));

                        if ($success) {
                            // Suppression de l'ancienne image du produit du dossier
                            if (!empty($pictureFile) && unlink($oldFile)) {
                                // TOUT EST OK
                            }
                        }
                    }
                }
            }
        }

        if (isset($_POST['nomDestinataireDevis']) && !empty($_POST['nomDestinataireDevis']) && strlen($_POST['nomDestinataireDevis']) >= 2 && strlen($_POST['nomDestinataireDevis']) <= 50) {
    
            $nomDestinataireDevis = ucwords(htmlspecialchars(trim($_POST['nomDestinataireDevis']), ENT_QUOTES, 'UTF-8'));
    
            $checkQuery_upadh = $db_host->prepare("UPDATE devis SET nom_client_devis = :nom_client_devis WHERE id_devis = :id_devis");
            $success = $checkQuery_upadh->execute(array(
                'nom_client_devis' => $nomDestinataireDevis,
                'id_devis' => $serverDataIdHidden
            ));
        }

        if (isset($_POST['phoneDestinataireDevis']) && !empty($_POST['phoneDestinataireDevis']) && strlen($_POST['phoneDestinataireDevis']) >= 7 && strlen($_POST['phoneDestinataireDevis']) <= 20) {
    
            $phoneDestinataireDevis = htmlspecialchars(trim($_POST['phoneDestinataireDevis']), ENT_QUOTES, 'UTF-8');
    
            $checkQuery_upadh = $db_host->prepare("UPDATE devis SET tel_client_devis = :tel_client_devis WHERE id_devis = :id_devis");
            $success = $checkQuery_upadh->execute(array(
                'tel_client_devis' => $phoneDestinataireDevis,
                'id_devis' => $serverDataIdHidden
            ));
        }

        if (isset($_POST['emailDestinataireDevis']) && !empty($_POST['emailDestinataireDevis']) && filter_var($_POST['emailDestinataireDevis'], FILTER_VALIDATE_EMAIL) && strlen($_POST['emailDestinataireDevis']) <= 100) {
    
            $emailDestinataireDevis = htmlspecialchars(trim($_POST['emailDestinataireDevis']), ENT_QUOTES, 'UTF-8');
    
            $checkQuery_upadh = $db_host->prepare("UPDATE devis SET email_client_devis = :email_client_devis WHERE id_devis = :id_devis");
            $success = $checkQuery_upadh->execute(array(
                'email_client_devis' => $emailDestinataireDevis,
                'id_devis' => $serverDataIdHidden
            ));
        }

        if (isset($_POST['adresseDestinataireDevis']) && !empty($_POST['adresseDestinataireDevis']) && strlen($_POST['adresseDestinataireDevis']) >= 2 && strlen($_POST['adresseDestinataireDevis']) <= 50) {
    
            $adresseDestinataireDevis = htmlspecialchars(trim($_POST['adresseDestinataireDevis']), ENT_QUOTES, 'UTF-8');
    
            $checkQuery_upadh = $db_host->prepare("UPDATE devis SET adresse_client_devis = :adresse_client_devis WHERE id_devis = :id_devis");
            $success = $checkQuery_upadh->execute(array(
                'adresse_client_devis' => $adresseDestinataireDevis,
                'id_devis' => $serverDataIdHidden
            ));
        }

        // Réponse JSON
        send_json_response(['success' => true]);
    } catch (Exception $ex) {
        // Erreur serveur
        send_json_response(['msg' => "Une erreur s’est produite. Veuillez réessayer plus tard."]);
    }
?>