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

if(isset($_POST["id_pays"]) and !empty($_POST["id_pays"]) and is_numeric($_POST["id_pays"]) and isset($_POST["action"]) and !empty($_POST["action"]) and strtolower($_POST["action"]) === "get_villes") {
    $id_pays = intval($_POST["id_pays"]);
    $query = "SELECT id_ville, nom_ville FROM ville WHERE id_pays = ?";
    $result = $db_host->prepare($query);
    $result->execute([$id_pays]);
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