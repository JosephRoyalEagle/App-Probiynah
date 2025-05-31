<?php
if (isset($_SESSION['appro_connect_active_id_token']) && isset($_SESSION['appro_connect_active_type_token'])) {
    if (!empty($_SESSION['appro_connect_active_id_token']) && is_int($_SESSION['appro_connect_active_id_token']) && !empty($_SESSION['appro_connect_active_type_token'])) {
        header('Location: lantern/');
        exit;
    }
    else {
        header('Location: index.php');
        exit;
    }
}
elseif (isset($_COOKIE['ApproAuthToken'])) {
    $user_browser_token = $_COOKIE['ApproAuthToken'];
    $response_token_finder = findUserByToken($user_browser_token);

    if ($response_token_finder) {
        // Session
        $_SESSION['appro_connect_active_id_token'] = (int) $response_token_finder['id_utilis'];
        $_SESSION['appro_connect_active_type_token'] = $response_token_finder['role_utilis'];

        header('Location: lantern/');
        exit;
    } else {
        // Supprimer le log expiré
        $stmt_delete_token_line = $db_host->prepare("DELETE FROM utilisateurs_logs WHERE token_utilislogs = ?");
        $stmt_delete_token_line->execute([$user_browser_token]);

        setcookie("ApproAuthToken", "", [
            'expires' => time() - 3600,
            'path' => '/',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'None'
        ]);  
        
        header('Location: index.php');
        exit;
    }
}
?>