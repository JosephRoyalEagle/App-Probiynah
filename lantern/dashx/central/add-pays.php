<?php
require 'session-control.php';
header('Content-Type: application/json');
$response = [
    'success' => false,
    'message' => '',
    'redirect' => ''
];

// Si l'utilisateur est déjà connecté, on le redirige


if (isset($_POST['action']) and !empty($_POST['action']) and strtolower($_POST['action']) === 'add_pays') {
    /* Validation de l'email*/
    if (!isset($_POST['nom_pays']) || empty($_POST['nom_pays'])) {
        $response['message'] = "Veuillez entrer un nom de pays valide";
        echo json_encode($response);
        exit;
    }

    if (!isset($_POST['code_postal']) || empty($_POST['code_postal']) || !preg_match('/^\d+$/', $_POST['code_postal']) || !is_numeric($_POST['code_postal'])) {
        $response['message'] = "Veuillez entrer un code de pays valide";
        echo json_encode($response);
        exit;
    }
    // Connexion à la base de données

    try {
        $nom_pays = (string) strip_tags($_POST['nom_pays']);
        $code_postal = strip_tags($_POST['code_postal']);
        // Vérifions si le pays n'existe pas
        $sql = " SELECT COUNT(*) AS cpt FROM pays WHERE  lower(libelle_pays) = :nom_pays OR lower(codezip_pays) = :codezip_pays ";
        $stmt = $db_host->prepare($sql);
        $stmt->execute([
            ':nom_pays' => strtolower($nom_pays),
            ':codezip_pays' => strtolower($code_postal)

        ]);
        $result = $stmt->fetch();

        if ($result['cpt'] > 0) {
            $response['message'] = "Le pays existe deja";
            echo json_encode($response);
            exit;
        }

        $sql = "INSERT INTO pays (libelle_pays, codezip_pays,dateinsertion_pays,createur_pays,heureinsertion_pays) VALUES (:nom_pays, :codezip_pays, :dateinsertion_pays, :createur_pays, :heureinsertion_pays)";
        $stmt = $db_host->prepare($sql);
        $stmt->execute([
            ':nom_pays' => ucwords($nom_pays),
            ':codezip_pays' => $code_postal,
            ':dateinsertion_pays' => dateUTC()->format('Y-m-d'),
            ':createur_pays' => $_SESSION['appro_connect_active_id_token'],
            ':heureinsertion_pays' => dateUTC()->format('H\h i\m\i\n s\s'),
        ]);
        $response['success'] = true;
        $response['message'] = "Pays ajouté avec succès";
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
