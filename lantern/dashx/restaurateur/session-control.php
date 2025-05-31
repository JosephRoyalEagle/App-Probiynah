<?php
require '../../../session-start.php';
require '../../../dbcaller/dbcaller.php';
require '../../../fonction.php';

// Fonction pour réinitialiser la session et rediriger
function logoutAndRedirect() {
    $_SESSION['appro_connect_active_type_token'] = "";
    $_SESSION['appro_connect_active_id_token'] = "";
    unset($_SESSION['appro_connect_active_id_token'], $_SESSION['appro_connect_active_type_token']);

    setcookie("ApproAuthToken", "", [
        'expires' => time() - 3600,
        'path' => '/',
        'secure' => true,
        'httponly' => true,
        'samesite' => 'None'
    ]);

    header('Location: ../../../');
    exit;
}

// Authentification par session
if (isset($_SESSION['appro_connect_active_id_token'], $_SESSION['appro_connect_active_type_token'])) {
    $id_user_connect = $_SESSION['appro_connect_active_id_token'];
    $role_user_connect = $_SESSION['appro_connect_active_type_token'];

    if (empty($id_user_connect) || !is_int($id_user_connect) || empty($role_user_connect) || $role_user_connect !== "SAdmin") {
        logoutAndRedirect();
    }
}
// Authentification par cookie (connexion automatique)
elseif (isset($_COOKIE['ApproAuthToken'])) {
    $user_browser_token = $_COOKIE['ApproAuthToken'];
    $response_token_finder = findUserByToken($user_browser_token);

    if ($response_token_finder && $response_token_finder['role_utilis'] === "SAdmin") {
        $_SESSION['appro_connect_active_id_token'] = (int)$response_token_finder['id_utilis'];
        $_SESSION['appro_connect_active_type_token'] = $response_token_finder['role_utilis'];
    } else {
        logoutAndRedirect(); // Token invalide ou pas SAdmin
    }
} else {
    logoutAndRedirect(); // Aucune session ni cookie
}

// Validation finale dans la base
$stmt_user_checker = $db_host->prepare("SELECT * FROM utilisateurs WHERE id_utilis = ? AND role_utilis = ?");
$stmt_user_checker->execute([
    $_SESSION['appro_connect_active_id_token'],
    $_SESSION['appro_connect_active_type_token']
]);

if (!$stmt_user_checker->fetch()) {
    logoutAndRedirect();
}
?>