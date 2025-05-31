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

        $checkQuery_adh_q1 = $db_host->prepare("SELECT COUNT(*) AS count, image_prod FROM produits WHERE id_prod = :id_prod");
        $checkQuery_adh_q1->execute(['id_prod' => $serverDataIdHidden]);
        $count_account_1 = $checkQuery_adh_q1->fetch(PDO::FETCH_ASSOC);
        if ($count_account_1['count'] == 0) {
            send_json_response(['msg' => "Le produit est introuvable, veuillez réessayer."]);
        }

        // Sauvegarde de l'ancien nom du produit
        $pictureFile = trim($count_account_1['image_prod']);
        $oldFile = "../../uploads/products/".$pictureFile;
    
        // Validation des données
        if (isset($_POST['designationProd']) && !empty($_POST['designationProd']) && strlen($_POST['designationProd']) >= 2 && strlen($_POST['designationProd']) <= 50) {
    
            $designationProd = ucwords(htmlspecialchars(trim($_POST['designationProd']), ENT_QUOTES, 'UTF-8'));

            $req = $db_host->prepare('
                SELECT COUNT(*) AS count 
                FROM produits 
                WHERE nom_prod = :nom_prod 
                LIMIT 1
            ');
            $req->execute([':nom_prod' => $designationProd]);
            $user = $req->fetch(PDO::FETCH_ASSOC);

            if ($user['count'] == 0) {
                $checkQuery_upadh = $db_host->prepare("UPDATE produits SET nom_prod = :nom_prod WHERE id_prod = :id_prod");
                $success = $checkQuery_upadh->execute(array(
                    'nom_prod' => $designationProd,
                    'id_prod' => $serverDataIdHidden
                ));
            }
        }
    
        if (isset($_POST['descriptionProd']) && !empty($_POST['descriptionProd']) && strlen($_POST['descriptionProd']) >= 2 && strlen($_POST['descriptionProd']) <= 100) {
    
            $descriptionProd = ucfirst(htmlspecialchars(trim($_POST['descriptionProd']), ENT_QUOTES, 'UTF-8'));
    
            $checkQuery_upadh = $db_host->prepare("UPDATE produits SET description_prod = :description_prod WHERE id_prod = :id_prod");
            $success = $checkQuery_upadh->execute(array(
                'description_prod' => $descriptionProd,
                'id_prod' => $serverDataIdHidden
            ));
        }

        if (isset($_POST['categorieProd']) && !empty($_POST['categorieProd'])) {
    
            $categorieProd = (int) htmlspecialchars(trim($_POST['categorieProd']), ENT_QUOTES, 'UTF-8') ?? 0;

            $req = $db_host->prepare('
                SELECT COUNT(*) AS count 
                FROM categorie_produits 
                WHERE id_cateprod = :id_cateprod 
                LIMIT 1
            ');
            $req->execute([':id_cateprod' => $categorieProd]);
            $user = $req->fetch(PDO::FETCH_ASSOC);

            if ($user['count'] > 0) {
                $checkQuery_upadh = $db_host->prepare("UPDATE produits SET id_cateprod = :id_cateprod WHERE id_prod = :id_prod");
                $success = $checkQuery_upadh->execute(array(
                    'id_cateprod' => $categorieProd,
                    'id_prod' => $serverDataIdHidden
                ));
            }
        }

        if (isset($_FILES['imageProd']) && $_FILES['imageProd']['error'] === 0) {
            $allowedTypes = ['image/png', 'image/jpeg', 'image/jpg'];
            $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($fileInfo, $_FILES['imageProd']['tmp_name']);
            finfo_close($fileInfo);
        
            if (in_array($mimeType, $allowedTypes)) {
                // Génération du nom de fichier unique
                $extension = pathinfo($_FILES['imageProd']['name'], PATHINFO_EXTENSION);
                $allowedExts = ['jpg', 'jpeg', 'png'];
                if (in_array(strtolower($extension), $allowedExts)) {
                    // Générer un nom unique avec ta fonction perso
                    $uniqueFilename = generateCustomFilename('img-prod-', strtolower($extension));

                    // Définir le dossier d’upload (2 niveaux au-dessus)
                    $uploadDir = dirname(__DIR__, 2) . '/uploads/products/';
                    $uploadPath = $uploadDir . $uniqueFilename;

                    // TRAITEMENT IMAGE
                    $tmpFile = $_FILES['imageProd']['tmp_name'];
                    if (resizeImageToHeight($tmpFile, $uploadPath, 250)) {
                        $checkQuery_upadh = $db_host->prepare("UPDATE produits SET image_prod = :image_prod WHERE id_prod = :id_prod");
                        $success = $checkQuery_upadh->execute(array(
                            'image_prod' => $uniqueFilename,
                            'id_prod' => $serverDataIdHidden
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

        // Réponse JSON
        send_json_response(['success' => true]);
    } catch (Exception $ex) {
        // Erreur serveur
        send_json_response(['msg' => "Une erreur s’est produite. Veuillez réessayer plus tard."]);
    }
?>