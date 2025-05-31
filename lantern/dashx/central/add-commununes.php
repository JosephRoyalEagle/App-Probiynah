<?php
require('session-control.php');
header('Content-Type: application/json');
$response = [
    'success' => false,
    'message' => '',
    'redirect' => ''
];

// Si l'utilisateur est déjà connecté, on le redirige


if (isset($_POST['action']) and !empty($_POST['action']) and strtolower($_POST['action']) === 'add_commununes') {
    /* Validation de l'email*/
    if (!isset($_POST['nom_ville']) || empty($_POST['nom_ville'])) {
        $response['message'] = "Veuillez choisir une ville valide";
        echo json_encode($response);
        exit;
    }

    if (!isset($_POST['nom_com']) || empty($_POST['nom_com']) ||is_numeric($_POST['nom_com'])) {
        $response['message'] = "Veuillez entrer un nom de commune valide";
        echo json_encode($response);
        exit;
    }
    try {
        $id_pays = (string) strip_tags($_POST['nom_ville']);
        $nom_com = strip_tags($_POST['nom_com']);
        // Vérifions si le pays n'existe pas
        $sql = " SELECT COUNT(*) AS cpt FROM commune WHERE  lower(nom_commune) = :nom_com ";
        $stmt = $db_host->prepare($sql);
        $stmt->execute([
            ':nom_com' => strtolower($nom_com),
        ]);
        $result = $stmt->fetch();

        if ($result['cpt'] > 0) {
            $response['message'] = "La commune existe deja";
            echo json_encode($response);
            exit;
        }

        $sql = "INSERT INTO commune (nom_commune,id_ville,dateinsertion_commune,createur_commune) VALUES (:nom_commune, :id_pays, :dateinsertion_commune, :createur_commune)";
        $stmt = $db_host->prepare($sql);
        $stmt->execute([
            ':id_pays' => $id_pays,
            ':nom_commune' =>ucwords($nom_com),
            ':dateinsertion_commune' => date('Y-m-d H:i:s'),
            ':createur_commune' => $_SESSION['appro_connect_active_id_token'],
        ]);
        $response['success'] = true;
        $response['message'] = "Commune ajoutée avec succès";
        echo json_encode($response);
        exit;
    } catch (Exception $th) {
        //die('Erreur : ' . $th->getMessage());
    }
} else {
    $response['message'] = "Requête invalide";
}

echo json_encode($response);
exit;
