<?php
    require 'session-control.php';
    header('Content-Type: application/json; charset=utf-8');

    // Vérifie que la requête est bien AJAX et POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
        header('Location: https://www.probiynah.com');
        exit();
    }

    // Validation des données
    if (!isset($_POST['designationUserForm']) || empty($_POST['designationUserForm']) || strlen($_POST['designationUserForm']) < 2 || strlen($_POST['designationUserForm']) > 70) {
        send_json_response(['msg' => "Saisissez au moins une désignation valide."]);
    }

    if (!isset($_POST['typeproduitUserForm']) || empty($_POST['typeproduitUserForm']) || ($_POST['typeproduitUserForm'] !== 'Nourriture' && $_POST['typeproduitUserForm'] !== 'Boisson')) {
        send_json_response(['msg' => "Sélectionnez un type de produit valide."]);
    }

    $designationUserForm = ucwords(htmlspecialchars(trim($_POST['designationUserForm']), ENT_QUOTES, 'UTF-8'));
    $typeproduitUserForm = ucwords(htmlspecialchars(trim($_POST['typeproduitUserForm']), ENT_QUOTES, 'UTF-8'));

    try {
        // Vérifie que le numero de téléphone n'est pas utilisé
        $req = $db_host->prepare('
            SELECT COUNT(*) AS count 
            FROM categorie_produits 
            WHERE designation_cateprod = :designation 
            LIMIT 1
        ');
        $req->execute([':designation' => $designationUserForm]);
        $user = $req->fetch(PDO::FETCH_ASSOC);

        if ($user['count'] > 0) {
            send_json_response(['msg' => "la catégorie de produit existe déjà, veuillez la changer."]);
        }

        // Enregistrement de l'utilisateur
        $order = $db_host->prepare('
            INSERT INTO categorie_produits (designation_cateprod, type_cateprod, dateinsertion_cateprod, heureinsertion_cateprod, createur_cateprod)
            VALUES (:designation, :type, :date, :heure, :createur)
        ');

        $order->execute([
            ':designation' => $designationUserForm,
            ':type' => $typeproduitUserForm,
            ':date' => dateUTC()->format('Y-m-d'),
            ':heure' => dateUTC()->format('H\h i\m\i\n s\s'),
            ':createur' => $_SESSION['appro_connect_active_id_token']
        ]);
        

        if (!$order) {
            send_json_response(['msg' => "Une erreur s’est produite lors de l'enregistrement de la catégorie de produit, veuillez réessayer."]);
        }

        // Réponse JSON
        send_json_response(['success' => true]);

    } catch (Exception $ex) {
        // Erreur serveur
        send_json_response(['msg' => "Une erreur s’est produite. Veuillez réessayer plus tard."]);
    }
?>