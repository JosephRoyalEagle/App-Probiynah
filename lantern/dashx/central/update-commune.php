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
if (isset($_POST['action']) and !empty($_POST['action']) and strtolower($_POST['action']) === 'update_commune') {
    /* Validation de l'email*/
    if (!isset($_POST['id_ville']) || empty($_POST['id_ville']) || !is_numeric($_POST['id_ville']) || !isset($_POST['id_commune']) || empty($_POST['id_commune']) || !is_numeric($_POST['id_commune'])) {
        $response['message'] = "Action invalide";
        echo json_encode($response);
        exit;
    }

    //RECUPERATION DES DONNEES libelle et codezip

    if (isset($_POST['nom_commune']) && !empty($_POST['nom_commune'])) {
        $nom_commune = strip_tags($_POST['nom_commune']);

        $sql = " SELECT COUNT(*) AS cpt FROM commune WHERE  lower(nom_commune) = :nom_com ";
        $stmt = $db_host->prepare($sql);
        $stmt->execute([
            ':nom_com' => strtolower($nom_commune),
        ]);
        $result = $stmt->fetch();

        if ($result['cpt'] > 0) {
            $sql = "UPDATE commune SET id_ville = :id_ville WHERE id_commune = :id_commune";
            $stmt = $db_host->prepare($sql);
            $stmt->execute([
                ':id_commune' => $_POST['id_commune'],
                ':id_ville' => $_POST['id_ville']
            ]);
            $response['success'] = true;
            $response['message'] = "Commune modifiée avec succès";
            echo json_encode($response, JSON_PRETTY_PRINT);
            exit;
        }

        $sql = "UPDATE commune SET nom_commune = :nom_commune, id_ville = :id_ville WHERE id_commune = :id_commune";
        $stmt = $db_host->prepare($sql);
        $stmt->execute([
            ':nom_commune' => ucwords($nom_commune),
            ':id_commune' => $_POST['id_commune'],
            ':id_ville' => $_POST['id_ville']
        ]);
        $response['success'] = true;
        $response['message'] = "Commune modifiée avec succès";
        echo json_encode($response, JSON_PRETTY_PRINT);
        exit;
    } else {
        $response['message'] = "Tous les champs sont obligatoires";
        echo json_encode($response);
        exit;
    }
} else {
    $response['message'] = "Action invalide";
    echo json_encode($response);
    exit;
}
