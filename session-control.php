<?php
$requiredSessionKeys = [
    'utilisateur_id_token',
    'utilisateur_phone_token',
    'utilisateur_sms_date_token',
    'utilisateur_sms_count_token',
    'utilisateur_sms_code_token',
    'utilisateur_sms_letter_token'
];

// Vérifie si toutes les clés existent et ne sont pas vides
foreach ($requiredSessionKeys as $key) {
    if (!isset($_SESSION[$key]) || empty($_SESSION[$key])) {
        header('Location: index.php');
        exit;
    }
}

// Vérifie les types attendus
if (!is_int($_SESSION['utilisateur_id_token']) || !is_int($_SESSION['utilisateur_sms_count_token'])) {
    header('Location: index.php');
    exit;
}
?>
