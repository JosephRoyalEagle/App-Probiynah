<?php
    // Vider les sessions
    $_SESSION['utilisateur_phone_token'] = "";
    $_SESSION['utilisateur_id_token'] = "";
    $_SESSION['utilisateur_sms_date_token'] = "";
    $_SESSION['utilisateur_sms_count_token'] = "";
    $_SESSION['utilisateur_sms_code_token'] = "";
    $_SESSION['utilisateur_sms_letter_token'] = "";
    // Suppression les sessions
    unset($_SESSION['utilisateur_phone_token']);
    unset($_SESSION['utilisateur_id_token']);
    unset($_SESSION['utilisateur_sms_date_token']);
    unset($_SESSION['utilisateur_sms_count_token']);
    unset($_SESSION['utilisateur_sms_code_token']);
    unset($_SESSION['utilisateur_sms_letter_token']);
?>