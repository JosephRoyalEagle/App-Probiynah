<?php
require('session-control.php');
header('Content-Type: application/json');

$response = [
    'success' => false,
    'message' => '',
];

// Sécurité AJAX + POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') !== 'xmlhttprequest') {
    http_response_code(403);
    echo json_encode([
        'status' => 'error',
        'message' => 'Accès non autorisé.'
    ]);
    exit;
}

// Vérification des champs obligatoires
if (
    !isset($_POST['restaurantId']) || !is_numeric($_POST['restaurantId']) ||
    empty($_POST['nom_business']) ||
    empty($_POST['description_business']) ||
    empty($_POST['adresse_business']) ||
    !isset($_POST['etoile_business']) ||
    !isset($_POST['id_pays']) ||
    !isset($_POST['id_ville']) ||
    !isset($_POST['id_commune']) ||
    !isset($_POST['id_proprietaire'])
) {
    $response['message'] = "Tous les champs obligatoires doivent être remplis.";
    echo json_encode($response);
    exit;
}

$id_business = intval($_POST['restaurantId']);
$nom = ucwords(trim($_POST['nom_business']));
$description = ucwords(trim($_POST['description_business']));
$adresse = trim($_POST['adresse_business']);
$etoile = floatval($_POST['etoile_business']);
$id_pays = intval($_POST['id_pays']);
$id_ville = intval($_POST['id_ville']);
$id_commune = intval($_POST['id_commune']);
$id_proprietaire = intval($_POST['id_proprietaire']);
$updateur = $_SESSION['appro_connect_active_id_token'] ?? null;

if (!$updateur) {
    $response['message'] = "Session expirée. Veuillez vous reconnecter.";
    echo json_encode($response);
    exit;
}

// Mise à jour de la table `business`
$stmt = $db_host->prepare("
    UPDATE business SET
        nom_business = :nom,
        description_business = :description,
        adresse_business = :adresse,
        etoile_business = :etoile,
        id_pays = :pays,
        id_ville = :ville,
        id_commune = :commune,
        id_utilis = :utilis
    WHERE id_business = :id
");
$stmt->execute([
    ':nom' => $nom,
    ':description' => $description,
    ':adresse' => $adresse,
    ':etoile' => $etoile,
    ':pays' => $id_pays,
    ':ville' => $id_ville,
    ':commune' => $id_commune,
    ':utilis' => $id_proprietaire,
    ':id' => $id_business
]);

// Mise à jour du champ `id_business` dans la table `utilisateurs`
$stmt = $db_host->prepare("UPDATE utilisateurs SET id_business = :id_business WHERE id_utilis = :id_utilis");
$stmt->execute([
    ':id_business' => $id_business,
    ':id_utilis' => $id_proprietaire
]);

// Gestion de l’image si envoyée
if (!empty($_FILES['business_image']) && $_FILES['business_image']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = __DIR__ . '/../../uploads/business/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    $tmpName = $_FILES['business_image']['tmp_name'];
    $originalName = basename($_FILES['business_image']['name']);
    $extension = pathinfo($originalName, PATHINFO_EXTENSION);
    $fileName = uniqid('restaurant_', true) . '.' . $extension;
    move_uploaded_file($tmpName, $uploadDir . $fileName);

    // Vérifier si une image existe déjà
    $stmt = $db_host->prepare("SELECT COUNT(*) FROM business_assets WHERE id_business = :id");
    $stmt->execute([':id' => $id_business]);

    if ($stmt->fetchColumn() > 0) {
        // Mise à jour
        $stmt = $db_host->prepare("
            UPDATE business_assets SET
                nomfichier_business_assets = :fichier,
                createur_business_assets = :createur,
                dateinsertion_business_assets = :date
            WHERE id_business = :id
        ");
    } else {
        // Insertion
        $stmt = $db_host->prepare("
            INSERT INTO business_assets (
                id_business,
                nomfichier_business_assets,
                createur_business_assets,
                dateinsertion_business_assets
            ) VALUES (
                :id, :fichier, :createur, :date
            )
        ");
    }

    $stmt->execute([
        ':id' => $id_business,
        ':fichier' => $fileName,
        ':createur' => $updateur,
        ':date' => date('Y-m-d H:i:s')
    ]);
}

$response['success'] = true;
$response['message'] = "Restaurant mis à jour avec succès.";
echo json_encode($response, JSON_PRETTY_PRINT);
exit;
