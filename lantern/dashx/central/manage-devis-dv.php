<?php
    require 'session-control.php';
    header('Content-Type: application/json; charset=utf-8');

    // Vérifie que la requête est bien AJAX et POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
        header('Location: https://www.probiynah.com');
        exit();
    }

    // Validation des données
    if (!isset($_POST['nomEmetteurDevis']) || empty($_POST['nomEmetteurDevis']) || strlen($_POST['nomEmetteurDevis']) < 2 || strlen($_POST['nomEmetteurDevis']) > 50) {
        send_json_response(['msg' => "Saisissez au moins un nom valide pour l'emetteur."]);
    }

    if (!isset($_POST['phoneEmetteurDevis']) || empty($_POST['phoneEmetteurDevis']) || strlen($_POST['phoneEmetteurDevis']) < 7 || strlen($_POST['phoneEmetteurDevis']) > 20) {
        send_json_response(['msg' => "Saisissez au moins un numero de telephone valide pour l'emetteur."]);
    }

    if (!isset($_POST['adresseEmetteurDevis']) || empty($_POST['adresseEmetteurDevis']) || strlen($_POST['adresseEmetteurDevis']) < 2 || strlen($_POST['adresseEmetteurDevis']) > 50) {
        send_json_response(['msg' => "Saisissez au moins une adresse valide pour l'emetteur."]);
    }

    if (!isset($_POST['nomDestinataireDevis']) || empty($_POST['nomDestinataireDevis']) || strlen($_POST['nomDestinataireDevis']) < 2 || strlen($_POST['nomDestinataireDevis']) > 50) {
        send_json_response(['msg' => "Saisissez au moins un nom valide pour le destinataire."]);
    }

    if (!isset($_POST['phoneDestinataireDevis']) || empty($_POST['phoneDestinataireDevis']) || strlen($_POST['phoneDestinataireDevis']) < 7 || strlen($_POST['phoneDestinataireDevis']) > 20) {
        send_json_response(['msg' => "Saisissez au moins un numero de telephone valide pour le destinataire."]);
    }

    if (!isset($_POST['adresseDestinataireDevis']) || empty($_POST['adresseDestinataireDevis']) || strlen($_POST['adresseDestinataireDevis']) < 2 || strlen($_POST['adresseDestinataireDevis']) > 50) {
        send_json_response(['msg' => "Saisissez au moins une adresse valide pour le destinataire."]);
    }

    if (!isset($_POST['dateValiditeDevis']) || empty($_POST['dateValiditeDevis'])) {
        send_json_response(['msg' => "Saisissez une date de validité valide."]);
    }

    if (!isset($_POST['termesDevis']) || empty($_POST['termesDevis']) || strlen($_POST['termesDevis']) < 10 || strlen($_POST['termesDevis']) > 200) {
        send_json_response(['msg' => "Donnez les termes et condition du devis (minimum 10 caractères et maximum 200)."]);
    }

    $uniqueFilename = null;
    if (isset($_FILES['imageDevis']) && $_FILES['imageDevis']['error'] === 0) {
        $allowedTypes = ['image/png', 'image/jpeg', 'image/jpg'];
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($fileInfo, $_FILES['imageDevis']['tmp_name']);
        finfo_close($fileInfo);

        if (!in_array($mimeType, $allowedTypes)) {
            send_json_response(['msg' => "Format d'image non autorisé. Formats acceptés : PNG, JPG, JPEG."]);
        }

        $extension = pathinfo($_FILES['imageDevis']['name'], PATHINFO_EXTENSION);
        $allowedExts = ['jpg', 'jpeg', 'png'];
        if (!in_array(strtolower($extension), $allowedExts)) {
            send_json_response(['msg' => "Extension de fichier non autorisée."]);
        }

        $uniqueFilename = generateCustomFilename('img-devis-', strtolower($extension));
        $uploadDir = dirname(__DIR__, 2) . '/uploads/devis/';
        $uploadPath = $uploadDir . $uniqueFilename;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
    }

    // Récupération des données
    $nomEmetteurDevis = ucwords(htmlspecialchars(trim($_POST['nomEmetteurDevis']), ENT_QUOTES, 'UTF-8'));
    $nomDestinataireDevis = ucwords(htmlspecialchars(trim($_POST['nomDestinataireDevis']), ENT_QUOTES, 'UTF-8'));
    $phoneEmetteurDevis = htmlspecialchars(trim($_POST['phoneEmetteurDevis']), ENT_QUOTES, 'UTF-8');
    $phoneDestinataireDevis = htmlspecialchars(trim($_POST['phoneDestinataireDevis']), ENT_QUOTES, 'UTF-8');
    $emailEmetteurDevis = isset($_POST['emailEmetteurDevis']) ? htmlspecialchars(trim($_POST['emailEmetteurDevis']), ENT_QUOTES, 'UTF-8') : '';
    $emailDestinataireDevis = isset($_POST['emailDestinataireDevis']) ? htmlspecialchars(trim($_POST['emailDestinataireDevis']), ENT_QUOTES, 'UTF-8') : '';
    $adresseEmetteurDevis = htmlspecialchars(trim($_POST['adresseEmetteurDevis']), ENT_QUOTES, 'UTF-8');
    $adresseDestinataireDevis = htmlspecialchars(trim($_POST['adresseDestinataireDevis']), ENT_QUOTES, 'UTF-8');
    $termesDevis = htmlspecialchars(trim($_POST['termesDevis']), ENT_QUOTES, 'UTF-8');
    $tvaDevis = (int) htmlspecialchars(trim($_POST['tvaDevis']), ENT_QUOTES, 'UTF-8') ?? 0;

    $dateValiditeStr = trim($_POST['dateValiditeDevis']);
    $dateValiditeObj = DateTime::createFromFormat('Y-m-d', $dateValiditeStr);
    $formatCorrect = $dateValiditeObj && $dateValiditeObj->format('Y-m-d') === $dateValiditeStr;
    $pasDansLePasse = $formatCorrect && $dateValiditeObj >= dateUTC();

    if (!$formatCorrect || !$pasDansLePasse) {
        send_json_response(['msg' => "Saisissez une date valide au format AAAA-MM-JJ, et non antérieure à aujourd’hui."]);
    }

    // Valeur du devis par défaut si la table est vide
    $codeDevis = 525;

    $reqCodeDevis = $db_host->prepare('SELECT MAX(code_devis) AS code_devis FROM devis');
    $reqCodeDevis->execute();
    $resCodeDevis = $reqCodeDevis->fetch(PDO::FETCH_ASSOC);

    if (!is_null($resCodeDevis['code_devis'])) {
        $codeDevis = $resCodeDevis['code_devis'] + 1;
    }

    // Enregistrement du devis
    try {
        // DÉMARRAGE DE TRANSACTION
        $db_host->beginTransaction();

        $order = $db_host->prepare("
            INSERT INTO devis (
                code_devis, 
                termes_conditions_devis, 
                tva_devis, 
                nom_offreur_devis, 
                email_offreur_devis, 
                tel_offreur_devis, 
                adresse_offreur_devis, 
                logo_offreur_devis, 
                nom_client_devis, 
                email_client_devis, 
                tel_client_devis, 
                adresse_client_devis, 
                dateinsertion_devis, 
                echeance_devis, 
                heureinsertion_devis, 
                createur_devis
            )
            VALUES (
                :code_devis, 
                :termes_conditions_devis, 
                :tva_devis, 
                :nom_offreur_devis, 
                :email_offreur_devis, 
                :tel_offreur_devis, 
                :adresse_offreur_devis, 
                :logo_offreur_devis, 
                :nom_client_devis, 
                :email_client_devis, 
                :tel_client_devis, 
                :adresse_client_devis, 
                :dateinsertion_devis, 
                :echeance_devis, 
                :heureinsertion_devis, 
                :createur_devis
            )
        ");
        $order->execute([
            ':code_devis' => $codeDevis,
            ':termes_conditions_devis' => $termesDevis,
            ':tva_devis' => $tvaDevis,
            ':nom_offreur_devis' => $nomEmetteurDevis,
            ':email_offreur_devis' => $emailEmetteurDevis,
            ':tel_offreur_devis' => $phoneEmetteurDevis,
            ':adresse_offreur_devis' => $adresseEmetteurDevis,
            ':logo_offreur_devis' => $uniqueFilename,
            ':nom_client_devis' => $nomDestinataireDevis,
            ':email_client_devis' => $emailDestinataireDevis,
            ':tel_client_devis' => $phoneDestinataireDevis,
            ':adresse_client_devis' => $adresseDestinataireDevis,
            ':dateinsertion_devis' => dateUTC()->format('Y-m-d'),
            ':echeance_devis' => $dateValiditeObj->format('Y-m-d'),
            ':heureinsertion_devis' => dateUTC()->format('H\h i\m\i\n s\s'),
            ':createur_devis' => $_SESSION['appro_connect_active_id_token'],
        ]);

        if ($uniqueFilename) {
            $tmpFile = $_FILES['imageDevis']['tmp_name'];
            if (!resizeImageToHeight($tmpFile, $uploadPath, 30)) {
                $db_host->rollBack();
                send_json_response(['msg' => "L'image est invalide ou ne peut pas être traitée."]);
            }
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