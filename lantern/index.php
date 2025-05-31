<?php
require '../session-start.php';
require '../dbcaller/dbcaller.php';
require '../fonction.php';

function redirectToRoleDashboard($role_user_connect) {
    $roleRoutes = [
        "Client"       => "dashx/client/",
        "SAdmin"       => "dashx/central/",
        "Gestionnaire" => "dashx/gestionnaire/",
        "Agent"        => "dashx/agent/",
        "Barman"       => "dashx/barman/",
        "Restaurateur" => "dashx/restaurateur/"
    ];

    if (isset($roleRoutes[$role_user_connect])) {
        header('Location: ' . $roleRoutes[$role_user_connect]);
    } else {
        redirectToDefault();
    }
    exit;
}

function redirectToDefault() {
    clearSessionAndToken();
    header('Location: ../');
    exit;
}

function clearSessionAndToken() {
    $_SESSION['appro_connect_active_id_token'] = "";
    $_SESSION['appro_connect_active_type_token'] = "";
    unset($_SESSION['appro_connect_active_id_token'], $_SESSION['appro_connect_active_type_token']);

    if (isset($_COOKIE['ApproAuthToken'])) {
        global $db_host;
        $stmt = $db_host->prepare("DELETE FROM utilisateurs_logs WHERE token_utilislogs = ?");
        $stmt->execute([$_COOKIE['ApproAuthToken']]);

        setcookie("ApproAuthToken", "", [
            'expires' => time() - 3600,
            'path' => '/',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'None'
        ]);
    }
}

// --- SESSION EXISTANTE ---
if (isset($_SESSION['appro_connect_active_id_token'], $_SESSION['appro_connect_active_type_token'])) {
    $id_user_connect   = $_SESSION['appro_connect_active_id_token'];
    $role_user_connect = $_SESSION['appro_connect_active_type_token'];

    if (!empty($id_user_connect) && is_int($id_user_connect) && !empty($role_user_connect)) {
        redirectToRoleDashboard($role_user_connect);
    } else {
        redirectToDefault();
    }
}

// --- COOKIE (connexion automatique) ---
elseif (isset($_COOKIE['ApproAuthToken'])) {
    $token = $_COOKIE['ApproAuthToken'];
    $user = findUserByToken($token);

    if ($user) {
        $_SESSION['appro_connect_active_id_token'] = (int) $user['id_utilis'];
        $_SESSION['appro_connect_active_type_token'] = $user['role_utilis'];

        redirectToRoleDashboard($user['role_utilis']);
    } else {
        redirectToDefault();
    }
}
?>