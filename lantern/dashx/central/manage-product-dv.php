<?php
    require 'session-control.php';
    header('Content-Type: application/json; charset=utf-8');

    // Vérifie que la requête est bien AJAX et POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
        header('Location: https://www.probiynah.com');
        exit();
    }

    // Validation des données
    if (!isset($_POST['designationProd']) || empty($_POST['designationProd']) || strlen($_POST['designationProd']) < 2 || strlen($_POST['designationProd']) > 50) {
        send_json_response(['msg' => "Saisissez au moins une désignation valide."]);
    }

    if (!isset($_POST['descriptionProd']) || empty($_POST['descriptionProd']) || strlen($_POST['descriptionProd']) < 2 || strlen($_POST['descriptionProd']) > 100) {
        send_json_response(['msg' => "Saisissez au moins une déscription valide."]);
    }

    if (!isset($_POST['categorieProd']) || empty($_POST['categorieProd'])) {
        send_json_response(['msg' => "Sélectionnez une caregorie valide."]);
    }

    if (!isset($_FILES['imageProd']) || $_FILES['imageProd']['error'] !== 0) {
        send_json_response(['msg' => "L'image est requise et doit être valide."]);
    }

    // Récupération des données
    $designationProd = ucwords(htmlspecialchars(trim($_POST['designationProd']), ENT_QUOTES, 'UTF-8'));
    $descriptionProd = ucfirst(htmlspecialchars(trim($_POST['descriptionProd']), ENT_QUOTES, 'UTF-8'));
    $categorieProd = (int) htmlspecialchars(trim($_POST['categorieProd']), ENT_QUOTES, 'UTF-8');

    // Vérification de l'existence de la catégorie de produit
    $reqCatProduct = $db_host->prepare('
        SELECT COUNT(*) AS count 
        FROM categorie_produits 
        WHERE id_cateprod = :id_cateprod 
        LIMIT 1
    ');
    $reqCatProduct->execute([':id_cateprod' => $categorieProd]);
    $resCatProduct = $reqCatProduct->fetch(PDO::FETCH_ASSOC);

    if ($resCatProduct['count'] === 0) {
        send_json_response(['msg' => "Categorie de produit introuvable, veuillez réessayer."]);
    }

    $allowedTypes = ['image/png', 'image/jpeg', 'image/jpg'];
    $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($fileInfo, $_FILES['imageProd']['tmp_name']);
    finfo_close($fileInfo);

    if (!in_array($mimeType, $allowedTypes)) {
        send_json_response(['msg' => "Format d'image non autorisé. Formats acceptés : PNG, JPG, JPEG."]);
    }

    // Génération du nom de fichier unique
    $extension = pathinfo($_FILES['imageProd']['name'], PATHINFO_EXTENSION);
    $allowedExts = ['jpg', 'jpeg', 'png'];
    if (!in_array(strtolower($extension), $allowedExts)) {
        send_json_response(['msg' => "Format de fichier non autorisé."]);
    }

    // Générer un nom unique avec ta fonction perso
    $uniqueFilename = generateCustomFilename('img-prod-', strtolower($extension));

    // Définir le dossier d’upload (2 niveaux au-dessus)
    $uploadDir = dirname(__DIR__, 2) . '/uploads/products/';
    $uploadPath = $uploadDir . $uniqueFilename;

    // Création du dossier si nécessaire
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Vérification de l'existence du nom de produit
    $reqProduct = $db_host->prepare('
        SELECT COUNT(*) AS count 
        FROM produits 
        WHERE nom_prod = :nom_prod 
        LIMIT 1
    ');
    $reqProduct->execute([':nom_prod' => $designationProd]);
    $resCatProduct = $reqProduct->fetch(PDO::FETCH_ASSOC);

    if ($resCatProduct['count'] > 0) {
        send_json_response(['msg' => "Le nom du produit existe deja, veuillez le changer."]);
    }

    // Enregistrement du produit
    try {
        // DÉMARRAGE DE TRANSACTION
        $db_host->beginTransaction();

        // Enregistrement du produit
        $order = $db_host->prepare("
            INSERT INTO produits (nom_prod, description_prod, image_prod, dateinsertion_prod, heureinsertion_prod, createur_prod, id_cateprod)
            VALUES (:designation, :description, :image, :date, :heure, :createur, :categorie)
        ");
        $order->execute([
            ':designation' => $designationProd,
            ':description' => $descriptionProd,
            ':image' => $uniqueFilename,
            ':date' => dateUTC()->format('Y-m-d'),
            ':heure' => dateUTC()->format('H\h i\m\i\n s\s'),
            ':createur' => $_SESSION['appro_connect_active_id_token'],
            ':categorie' => $categorieProd
        ]);

        // TRAITEMENT IMAGE
        $tmpFile = $_FILES['imageProd']['tmp_name'];
        if (!resizeImageToHeight($tmpFile, $uploadPath, 250)) {
            // IMAGE ÉCHOUÉE → ROLLBACK ET SORTIE
            $db_host->rollBack();
            send_json_response(['msg' => "L'image est invalide ou ne peut pas être traitée."]);
        }

        // TOUT EST OK → VALIDATION
        $db_host->commit();
        send_json_response(['success' => true]);
    } catch (PDOException $e) {
        // EN CAS D’ERREUR
        $db_host->rollBack();
        send_json_response(['msg' => "Une erreur s’est produite. Veuillez réessayer plus tard."]);
    }
?>