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
if (isset($_POST['action']) and !empty($_POST['action']) and strtolower($_POST['action']) === 'delete_restaurant') {
    /* Validation de l'email*/
    if (!isset($_POST['id_business']) || empty($_POST['id_business']) || !is_numeric($_POST['id_business'])) {
        $response['message'] = "Action invalide";
        echo json_encode($response);
        exit;
    }

     $req_b = "SELECT COUNT(*) AS cpt FROM approvisionnement_produits WHERE id_business = :id_business";
    $stmt = $db_host->prepare($req_b);
    $stmt->execute([
        ':id_business' => $_POST['id_business']
    ]);
    $result = $stmt->fetch();
    if ($result['cpt'] > 0) {
        $response['message'] = "Suppression impossible, car ce restaurant est lié a d'autres données.";
        echo json_encode($response);
        exit;
    }
    $sql = " SELECT COUNT(*) AS cpt FROM commandes WHERE  id_business = :id_business ";
    $stmt = $db_host->prepare($sql);
    $stmt->execute([
        ':id_business' => strtolower($_POST['id_business']),
    ]);
    $result = $stmt->fetch();

    if ($result['cpt'] > 0) {
        $response['message'] = "Suppression impossible, car ce restaurant est lié a d'autres données.";
        echo json_encode($response);
        exit;
    }

       $sql = " SELECT COUNT(*) AS cpt FROM stock_produit WHERE  id_business = :id_business ";
    $stmt = $db_host->prepare($sql);
    $stmt->execute([
        ':id_business' => strtolower($_POST['id_business']),
    ]);
    $result = $stmt->fetch();

    if ($result['cpt'] > 0) {
        $response['message'] = "Suppression impossible, car ce restaurant est lié a d'autres données.";
        echo json_encode($response);
        exit;
    }

    $id_business = strip_tags($_POST['id_business']);
    $sql = "DELETE FROM business WHERE id_business = :id_business";
    $stmt = $db_host->prepare($sql);
    $stmt->execute([
        ':id_business' => $id_business
    ]);
    $response['success'] = true;
    $response['message'] = "Restaurant supprimé avec succès";
    echo json_encode($response, JSON_PRETTY_PRINT);
} else {
    $response['message'] = "Action invalide";
    echo json_encode($response);
    exit;
}


