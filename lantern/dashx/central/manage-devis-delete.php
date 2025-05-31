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

$checkQuery_adh_q1 = $db_host->prepare("SELECT COUNT(*) AS count, logo_offreur_devis FROM devis WHERE id_devis = :id_devis");
$checkQuery_adh_q1->execute(['id_devis' => $dataPostContent]);
$count_adh_1 = $checkQuery_adh_q1->fetch(PDO::FETCH_ASSOC);
if ($count_adh_1['count'] == 0) {
    send_json_response(['msg' => "Le devis que vous essayez de supprimer est introuvable, veuillez réessayer."]);
}

try {
    // DÉMARRAGE DE TRANSACTION
    $db_host->beginTransaction();

    $deleteQuery_devis_details = $db_host->prepare("DELETE FROM devis_details WHERE id_devis = ?");
    if (!$deleteQuery_devis_details->execute([$dataPostContent])) {
        send_json_response(['msg' => "Erreur lors de la suppression du devis. Veuillez réessayer plus tard."]);
    }

    $deleteQuery_devis = $db_host->prepare("DELETE FROM devis WHERE id_devis = ?");
    if (!$deleteQuery_devis->execute([$dataPostContent])) {
        // EN CAS D’ERREUR
        $db_host->rollBack();
        send_json_response(['msg' => "Erreur lors de la suppression du devis. Veuillez réessayer plus tard."]);
    }

    // Suppression de l'image associée au devis
    $logoFile = trim($count_adh_1['logo_offreur_devis']);
    $tmpFile = "../../uploads/devis/" . $logoFile;

    // Vérifier que c'est bien un fichier à supprimer
    if (!empty($logoFile) && file_exists($tmpFile)) {
        if (!unlink($tmpFile)) {
            $db_host->rollBack();
            send_json_response(['msg' => "Erreur lors de la suppression de l'image associée au devis."]);
        }
    }

    // TOUT EST OK → VALIDATION
    $db_host->commit();
    send_json_response(['success' => true]);
} catch (Exception $e) {
    // EN CAS D’ERREUR
    $db_host->rollBack();
    send_json_response(['msg' => "Une erreur s'est produite lors de la suppression du devis. Veuillez réessayer plus tard."]);
}
?>