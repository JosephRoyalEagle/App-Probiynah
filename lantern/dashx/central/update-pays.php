<?php
require ('session-control.php');
header('Content-Type: application/json');

$response = [
    'success' => false,
    'message' => '',
];

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
if (isset($_POST['action']) and !empty($_POST['action']) and strtolower($_POST['action']) === 'update_pays') {
    /* Validation de l'email*/
    if (!isset($_POST['id_pays']) || empty($_POST['id_pays']) || !is_numeric($_POST['id_pays'])) {
        $response['message'] = "Action invalide";
        echo json_encode($response);
        exit;
    }

    //RECUPERATION DES DONNEES libelle et codezip

    if (isset($_POST['libelle_pays']) && !empty($_POST['libelle_pays']) && isset($_POST['codezip_pays']) && !empty($_POST['codezip_pays']) && is_numeric($_POST['codezip_pays'])) {
        $libelle_pays = strip_tags($_POST['libelle_pays']);
        $codezip_pays = strip_tags($_POST['codezip_pays']);
        $sql = " SELECT COUNT(*) AS cpt FROM pays WHERE  lower(codezip_pays) = :codezip_pays ";
        $stmt = $db_host->prepare($sql);
        $stmt->execute([
            ':codezip_pays' => strtolower($codezip_pays)

        ]);
        $result = $stmt->fetch();

        if ($result['cpt'] > 0) {
            $response['message'] = "Informations déja existantes";
            echo json_encode($response);
            exit;
        }

        $sql = "UPDATE pays SET libelle_pays = :libelle_pays, codezip_pays = :codezip_pays WHERE id_pays = :id_pays";
        $stmt = $db_host->prepare($sql);
        $stmt->execute([
            ':libelle_pays' => ucwords($libelle_pays),
            ':codezip_pays' => $codezip_pays,
            ':id_pays' => $_POST['id_pays']
        ]);
        $response['success'] = true;
        $response['message'] = "Pays modifié avec succès";
        echo json_encode($response, JSON_PRETTY_PRINT);
        exit;
    } else {
        $response['message'] = "Tous les champs sont obligatoires";
        echo json_encode($response);
        exit;
    }
} else {
    $response['message'] = "Action invalide1";
    echo json_encode($response);
    exit;
}
