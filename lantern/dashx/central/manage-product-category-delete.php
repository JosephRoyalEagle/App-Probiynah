<?php
require ('session-control.php');
header('Content-Type: application/json');

// Vérifie que la requête est bien AJAX et POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    header('Location: https://www.probiynah.com');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['dataPostContent'])) {
    send_json_response(['msg' => "Vous n'avez pas accès à ce service."]);
}

$dataPostContent = decryptData($_POST['dataPostContent'] ?? 0);

$checkQuery_adh_q1 = $db_host->prepare("SELECT COUNT(*) FROM categorie_produits WHERE id_cateprod = :id_cateprod");
$checkQuery_adh_q1->execute(['id_cateprod' => $dataPostContent]);
$count_adh_1 = $checkQuery_adh_q1->fetchColumn();
if ($count_adh_1 == 0) {
    send_json_response(['msg' => "Désolé, la categorie est introuvable, veuillez réessayer."]);
}

$checkQuery_adh_q2 = $db_host->prepare("SELECT COUNT(*) FROM produits WHERE id_cateprod = :id_cateprod");
$checkQuery_adh_q2->execute(['id_cateprod' => $dataPostContent]);
$count_adh_2 = $checkQuery_adh_q2->fetchColumn();
if ($count_adh_2 > 0) {
    send_json_response(['msg' => "Vous ne pouvez supprimer cette catégorie car elle est liée à d'autres données."]);
}

$deleteQuery = $db_host->prepare("DELETE FROM categorie_produits WHERE id_cateprod = ?");
if ($deleteQuery->execute([$dataPostContent])) {
    send_json_response(['success' => true]);
} else {
    send_json_response(['msg' => "Erreur lors de la suppression de la catégorie. Veuillez réessayer plus tard."]);
}
?>