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

$checkQuery_adh_q1 = $db_host->prepare("SELECT COUNT(*) AS count, image_prod FROM produits WHERE id_prod = :id_prod");
$checkQuery_adh_q1->execute(['id_prod' => $dataPostContent]);
$count_adh_1 = $checkQuery_adh_q1->fetch(PDO::FETCH_ASSOC);
if ($count_adh_1['count'] == 0) {
    send_json_response(['msg' => "Le produit que vous essayez de supprimer est introuvable, veuillez réessayer."]);
}

$checkQuery_adh_q2 = $db_host->prepare("SELECT COUNT(*) FROM approvisionnement_produits WHERE id_prod = :id_prod");
$checkQuery_adh_q2->execute(['id_prod' => $dataPostContent]);
$count_adh_2 = $checkQuery_adh_q2->fetchColumn();
if ($count_adh_2 > 0) {
    send_json_response(['msg' => "Vous ne pouvez supprimer ce produit car il est lié à des approvisionnements."]);
}

try {
    // DÉMARRAGE DE TRANSACTION
    $db_host->beginTransaction();

    $deleteQuery = $db_host->prepare("DELETE FROM produits WHERE id_prod = ?");
    if (!$deleteQuery->execute([$dataPostContent])) {
        send_json_response(['msg' => "Erreur lors de la suppression du produit. Veuillez réessayer plus tard."]);
    }

    // Suppression de l'image associée au produit
    $imageFile = trim($count_adh_1['image_prod']);
    $tmpFile = "../../uploads/products/" . $imageFile;

    if (!empty($imageFile) && file_exists($tmpFile)) {
        if (!unlink($tmpFile)) {
            $db_host->rollBack();
            send_json_response(['msg' => "Erreur lors de la suppression de l'image associée au produit."]);
        }
    }

    // TOUT EST OK → VALIDATION
    $db_host->commit();
    send_json_response(['success' => true]);
} catch (Exception $e) {
    // EN CAS D’ERREUR
    $db_host->rollBack();
    send_json_response(['msg' => "Une erreur s'est produite lors de la suppression du produit. Veuillez réessayer plus tard."]);
}
?>