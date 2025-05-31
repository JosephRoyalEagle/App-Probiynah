<?php
require '../../../session-start.php';
require '../../../dbcaller/dbcaller.php';

// Supprimer les sessions
$_SESSION['appro_connect_active_id_token'] = "";
$_SESSION['appro_connect_active_type_token'] = "";
unset($_SESSION['appro_connect_active_id_token'], $_SESSION['appro_connect_active_type_token']);

// Supprimer le cookie dans le navigateur + la base
if (isset($_COOKIE['ApproAuthToken'])) {
    $token = $_COOKIE['ApproAuthToken'];

    // Supprimer dans la base de données
    $stmt = $db_host->prepare("DELETE FROM utilisateurs_logs WHERE token_utilislogs = ?");
    $stmt->execute([$token]);

    // Supprimer dans le navigateur
    setcookie("ApproAuthToken", "", [
        'expires' => time() - 3600,
        'path' => '/',
        'secure' => true,
        'httponly' => true,
        'samesite' => 'None'
    ]);
}

// Rediriger vers la page de connexion
header('Location: ../../../');
exit;
?>
