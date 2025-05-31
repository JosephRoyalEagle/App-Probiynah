<?php
require ('session-control.php');
header('Content-Type: application/json');

$response = [
    'success' => false,
    'message' => '',
    'redirect' => ''
];

if (
    isset($_POST['action']) &&
    !empty($_POST['action']) &&
    strtolower($_POST['action']) === 'add_restaurant'
) {
    // verifions si le nombre d'etoile est entre 1 et 5
    if (!isset($_POST['etoile_business']) || empty($_POST['etoile_business']) || $_POST['etoile_business'] < 1 || $_POST['etoile_business'] > 5) {
        $response['message'] = "Le nombre d'etoile doit etre entre 1 et 5.";
        echo json_encode($response);
        exit;
    }
    // Vérifions si l'id du proporietaire est non vide 
    if (!isset($_POST['id_proprio']) || empty($_POST['id_proprio'])) {
        $response['message'] = "Veuillez choisir un proprietaire valide.";
        echo json_encode($response);
        exit;
    }
    // Validation des champs requis
    $requiredFields = ['nom_business', 'description_business', 'adresse_business', 'etoile_business', 'id_pays', 'id_ville'];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $response['message'] = "Le champ " . str_replace('_', ' ', $field) . " est requis.";
            echo json_encode($response);
            exit;
        }
    }


    try {
        //inition la transation $db_host->beginTransaction();
        $db_host->beginTransaction();

        $nom_business = strip_tags($_POST['nom_business']);
        $description_business = strip_tags($_POST['description_business']);
        $adresse_business = strip_tags($_POST['adresse_business']);
        $etoile_business = (int) $_POST['etoile_business'];
        $id_pays = (int) $_POST['id_pays'];
        $id_ville = (int) $_POST['id_ville'];
        $id_commune = isset($_POST['id_commune']) && !empty($_POST['id_commune']) ? (int) $_POST['id_commune'] : null;
        $id_business_assets = null; // Initialisation de l'asset
        $id_proprietaire = (int) $_POST['id_proprio'];

        // Gérer l'image (si elle est envoyée)
        if (isset($_FILES['business_image']) && $_FILES['business_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../../uploads/business/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            //$letters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
           // $randomLetter = substr(str_shuffle($letters), 0, 20) . '-' . date('d-m-y H:i:s');


            $fileTmpPath = $_FILES['business_image']['tmp_name'];
            $fileName = generateCustomFilename('business-image',pathinfo($_FILES['business_image']['name'], PATHINFO_EXTENSION));
            $destPath = $uploadDir . $fileName;

            if (move_uploaded_file($fileTmpPath, $destPath)) {

                // Insertion du restaurant dans la table `business`
                $stmt = $db_host->prepare("
            INSERT INTO business (
                nom_business,
                description_business,
                adresse_business,
                etoile_business,
                datecreation_business,
                createur_business,
                type_business,
                id_pays,
                id_ville,
                id_commune,
                id_utilis
            ) VALUES (
                :nom_business,
                :description_business,
                :adresse_business,
                :etoile_business,
                :datecreation_business,
                :createur_business,
                :type_business,
                :id_pays,
                :id_ville,
                :id_commune,
                :id_utilis
            )
        ");

                $stmt->execute([
                    ':nom_business' => ucwords($nom_business),
                    ':description_business' => ucwords($description_business),
                    ':adresse_business' => $adresse_business,
                    ':etoile_business' => $etoile_business,
                    ':datecreation_business' => date('Y-m-d H:i:s'),
                    ':createur_business' => $_SESSION['appro_connect_active_id_token'], // Vérifie que cette session existe
                    ':type_business' => ucwords('resto'),
                    ':id_pays' => $id_pays,
                    ':id_ville' => $id_ville,
                    ':id_commune' => $id_commune,
                    ':id_utilis' => $id_proprietaire
                ]);

                // Récupérer l'ID du business enregistré
                $id_business = $db_host->lastInsertId();
            }
        }

        // Si l'image est téléchargée, on l'enregistre dans `business_assets`
        $stmt = $db_host->prepare("
                    INSERT INTO business_assets (
                        id_business,
                        nomfichier_business_assets,
                        createur_business_assets,
                        dateinsertion_business_assets
                    ) VALUES (
                        :id_business,
                        :nomfichier_business_assets,
                        :createur_business_assets,
                        :dateinsertion_business_assets
                    )
                ");
        $stmt->execute([
            ':id_business' => $id_business, // Type 'image' pour l'asset
            ':nomfichier_business_assets' => $fileName,
            ':createur_business_assets' => $_SESSION['appro_connect_active_id_token'], // Assurez-vous que cette session existe,
            ':dateinsertion_business_assets' => date('d-m-y H:i:s')
        ]);
        // Modifions le id_business dans utilisateurs
        $stmt = $db_host->prepare("
            UPDATE utilisateurs
            SET id_business = :id_business
            WHERE id_utilis = :id_utilis
        ");
        $stmt->execute([
            ':id_business' => $id_business,
            ':id_utilis' => $id_proprietaire
        ]);

        $response['success'] = true;
        $response['message'] = "Restaurant enregistré avec succès.";
    } catch (Exception $e) {
        $db_host->rollBack();
        $response['message'] = "Erreur lors de l'enregistrement : " . $e->getMessage();
    }
} else {
    $response['message'] = "Requête invalide.";
}

echo json_encode($response);
exit;
