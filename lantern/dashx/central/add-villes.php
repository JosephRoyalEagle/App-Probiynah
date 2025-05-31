<?php
require('session-control.php');
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
        $response['message'] = "Veuillez choisir un pays valide";
        echo json_encode($response);
        exit;
    }

    if (!isset($_POST['nom_ville']) || empty($_POST['nom_ville']) ||is_numeric($_POST['nom_ville'])) {
        $response['message'] = "Veuillez entrer un nom de ville";
        echo json_encode($response);
        exit;
    }
    try {
        $id_pays = (string) strip_tags($_POST['nom_pays']);
        $nom_ville = strip_tags($_POST['nom_ville']);
        // Vérifions si le pays n'existe pas
        $sql = " SELECT COUNT(*) AS cpt FROM ville WHERE  lower(nom_ville) = :nom_ville ";
        $stmt = $db_host->prepare($sql);
        $stmt->execute([
            ':nom_ville' => strtolower($nom_ville),
        ]);
        $result = $stmt->fetch();

        if ($result['cpt'] > 0) {
            $response['message'] = "La ville existe deja";
            echo json_encode($response);
            exit;
        }
$dateUTC = new DateTime('now', new DateTimeZone('Africa/Abidjan'));
        $sql = "INSERT INTO ville (nom_ville,id_pays,dateinsertion_ville,createur_ville,heureinsertion_ville) VALUES (:nom_ville, :id_pays, :dateinsertion_ville, :createur_ville, :heureinsertion_ville)";
        $stmt = $db_host->prepare($sql);
        $stmt->execute([
            ':id_pays' => $id_pays,
            ':nom_ville' => ucwords($nom_ville),
            ':dateinsertion_ville' => $dateUTC->format('Y-m-d'),
            ':createur_ville' => $_SESSION['appro_connect_active_id_token'],
            ':heureinsertion_ville' => $dateUTC->format('H\h i\m\i\n s\s'),
        ]);
        $response['success'] = true;
        $response['message'] = "Ville ajoutée avec succès";
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
