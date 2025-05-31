<?php
require ('session-control.php');
header('Content-Type: application/json');

// 🔐 Bloquer si ce n’est pas une requête POST AJAX
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    http_response_code(403);
    echo json_encode([
        "status" => "error",
        "message" => "Accès non autorisé."
    ]);
    exit;
}

if(isset($_POST["id_ville"]) and !empty($_POST["id_ville"]) and is_numeric($_POST["id_ville"]) and isset($_POST["action"]) and !empty($_POST["action"]) and strtolower($_POST["action"]) === "get_communes") {
    $id_ville = intval($_POST["id_ville"]);
    $query = "SELECT id_commune, nom_commune FROM commune WHERE id_ville = ?";
    $result = $db_host->prepare($query);
    $result->execute([$id_ville]);
    $villes = $result->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($villes);
    exit;
}

echo json_encode([
        "status" => "error",
        "message" => "Accès non autorisé."
    ]);
    exit;
?>