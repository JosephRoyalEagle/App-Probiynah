<?php
require ('session-control.php');
header('Content-Type: application/json');

// Vérifie que la requête est bien AJAX et POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    header('Location: https://www.probiynah.com');
    exit();
}

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
if (isset($_POST['action']) and !empty($_POST['action']) and strtolower($_POST['action']) === 'delete_pays') {
    /* Validation de l'email*/
    if (!isset($_POST['id_pays']) || empty($_POST['id_pays']) || !is_numeric($_POST['id_pays'])) {
        $response['message'] = "Action invalide";
        echo json_encode($response);
        exit;
    }

     $req_b = "SELECT COUNT(*) AS cpt FROM business WHERE id_pays = :id_pays";
    $stmt = $db_host->prepare($req_b);
    $stmt->execute([
        ':id_pays' => $_POST['id_pays']
    ]);
    $result = $stmt->fetch();
    if ($result['cpt'] > 0) {
        $response['message'] = "Suppression impossible, car ce pays est lié a d'autres données.";
        echo json_encode($response);
        exit;
    }
    $sql = " SELECT COUNT(*) AS cpt FROM ville WHERE  id_ville = :id_ville ";
    $stmt = $db_host->prepare($sql);
    $stmt->execute([
        ':id_ville' => strtolower($_POST['id_pays']),
    ]);
    $result = $stmt->fetch();

    if ($result['cpt'] > 0) {
        $response['message'] = "Suppression impossible, car des données sont liées a ce pays.";
        echo json_encode($response);
        exit;
    }

    $id_pays = strip_tags($_POST['id_pays']);
    $sql = "DELETE FROM pays WHERE id_pays = :id_pays";
    $stmt = $db_host->prepare($sql);
    $stmt->execute([
        ':id_pays' => $id_pays
    ]);
    $response['success'] = true;
    $response['message'] = "Pays supprimé avec succès";
    echo json_encode($response, JSON_PRETTY_PRINT);
} else {
    $response['message'] = "Action invalide";
    echo json_encode($response);
    exit;
}


