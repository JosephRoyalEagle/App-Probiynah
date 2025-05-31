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

$checkQuery_adh_q1 = $db_host->prepare("SELECT COUNT(*) FROM utilisateurs WHERE id_utilis = :id_utilis");
$checkQuery_adh_q1->execute(['id_utilis' => $dataPostContent]);
$count_adh_1 = $checkQuery_adh_q1->fetchColumn();
if ($count_adh_1 == 0) {
    send_json_response(['msg' => "Désolé, le compte est introuvable, veuillez réessayer."]);
}

$checkQuery_adh_q2 = $db_host->prepare("SELECT COUNT(*) FROM utilisateurs_logs WHERE id_utilis = :id_utilis");
$checkQuery_adh_q2->execute(['id_utilis' => $dataPostContent]);
$count_adh_2 = $checkQuery_adh_q2->fetchColumn();
if ($count_adh_2 > 0) {
    send_json_response(['msg' => "Vous ne pouvez supprimer ce compte car il est lié à d'autres données."]);
}

$checkQuery_adh_q3 = $db_host->prepare("SELECT COUNT(*) FROM utilisateurs_sms WHERE id_utilis = :id_utilis");
$checkQuery_adh_q3->execute(['id_utilis' => $dataPostContent]);
$count_adh_3 = $checkQuery_adh_q3->fetchColumn();
if ($count_adh_3 > 0) {
    send_json_response(['msg' => "Vous ne pouvez supprimer ce compte car il est lié à d'autres données."]);
}

$checkQuery_adh_q4 = $db_host->prepare("SELECT COUNT(*) FROM business WHERE id_utilis = :id_utilis");
$checkQuery_adh_q4->execute(['id_utilis' => $dataPostContent]);
$count_adh_4 = $checkQuery_adh_q4->fetchColumn();
if ($count_adh_4 > 0) {
    send_json_response(['msg' => "Vous ne pouvez supprimer ce compte car il est lié à un restaurant ou hotel."]);
}

if ($_SESSION['appro_connect_active_id_token'] == $dataPostContent) {
    send_json_response(['msg' => "Vous ne pouvez supprimer votre compte en étant connecté à celui-ci."]);
}

$deleteQuery = $db_host->prepare("DELETE FROM utilisateurs WHERE id_utilis = ?");
if ($deleteQuery->execute([$dataPostContent])) {
    send_json_response(['success' => true]);
} else {
    send_json_response(['msg' => "Erreur lors de la suppression du compte. Veuillez réessayer plus tard."]);
}
?>