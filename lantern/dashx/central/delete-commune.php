<?php
require('session-control.php');
header('Content-Type: application/json');
$response = [
    'success' => false,
    'message' => '',
];


// 🔐 Bloquer si ce n’est pas une requête POST AJAX
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    http_response_code(403);
    echo json_encode([
        "status" => "error",
        "message" => "Accès non autorisé."
    ]);
    exit;
}



// Requête AJAX
if (isset($_POST['action']) and !empty($_POST['action']) and strtolower($_POST['action']) === 'delete_commune') {
    /* Validation de l'email*/
    if (!isset($_POST['id_commune']) || empty($_POST['id_commune']) || !is_numeric($_POST['id_commune'])) {
        $response['message'] = "Action invalide";
        echo json_encode($response);
        exit;
    }

    // VERIFIONS SI UN BISINESS N'EXISTE PAS DANS CETTE VILLE

    $req_b = "SELECT COUNT(*) AS cpt FROM business WHERE id_commune = :id_commune";
    $stmt = $db_host->prepare($req_b);
    $stmt->execute([
        ':id_commune' => $_POST['id_commune']
    ]);
    $result = $stmt->fetch();
    if ($result['cpt'] > 0) {
        $response['message'] = "Suppression impossible, car des données sont liées a cette commune.";
        echo json_encode($response);
        exit;
    }

    $id_commune = strip_tags($_POST['id_commune']);
    $sql = "DELETE FROM commune WHERE id_commune = :id_commune";
    $stmt = $db_host->prepare($sql);
    $stmt->execute([
        ':id_commune' => $id_commune
    ]);
    $response['success'] = true;
    $response['message'] = "Commune supprimée avec succès";
    echo json_encode($response, JSON_PRETTY_PRINT);
} else {
    $response['message'] = "Action invalide";
    echo json_encode($response);
    exit;
}


