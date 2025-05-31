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
if (isset($_POST['action']) and !empty($_POST['action']) and strtolower($_POST['action']) === 'update_villes') {
    /* Validation de l'email*/
    if (!isset($_POST['id_ville']) || empty($_POST['id_ville']) || !is_numeric($_POST['id_ville']) || !isset($_POST['pays']) || empty($_POST['pays']) || !is_numeric($_POST['pays'])) {
        $response['message'] = "Action invalide";
        echo json_encode($response);
        exit;
    }

    //RECUPERATION DES DONNEES libelle et codezip

    if (isset($_POST['libelle_ville']) && !empty($_POST['libelle_ville'])) {
        $libelle_ville = strip_tags($_POST['libelle_ville']);

        $sql = " SELECT COUNT(*) AS cpt FROM ville WHERE  lower(nom_ville) = :nom_ville ";
        $stmt = $db_host->prepare($sql);
        $stmt->execute([
            ':nom_ville' => strtolower($libelle_ville),
        ]);
        $result = $stmt->fetch();

        if ($result['cpt'] > 0) {
            $sql = "UPDATE ville SET id_pays = :id_pays WHERE id_ville = :id_ville";
            $stmt = $db_host->prepare($sql);
            $stmt->execute([
                ':id_pays' => $_POST['pays'],
                ':id_ville' => $_POST['id_ville']
            ]);
            $response['success'] = true;
            $response['message'] = "Ville modifiée avec succès";
            echo json_encode($response, JSON_PRETTY_PRINT);
            exit;
        }

        $sql = "UPDATE ville SET nom_ville = :libelle_ville, id_pays = :id_pays WHERE id_ville = :id_ville";
        $stmt = $db_host->prepare($sql);
        $stmt->execute([
            ':libelle_ville' => ($libelle_ville),
            ':id_pays' => $_POST['pays'],
            ':id_ville' => $_POST['id_ville']
        ]);
        $response['success'] = true;
        $response['message'] = "ville modifiée avec succès";
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
