<?php
    require 'session-start.php';
    require 'dbcaller/dbcaller.php';
    require 'fonction.php';
    require 'session-control.php';
    require 'session-dashboard-noback.php';

    try {
        if ($_SESSION['utilisateur_sms_count_token'] < 4) {
            // SMS
            $text = $_SESSION['utilisateur_sms_letter_token'];
            $to = $_SESSION['utilisateur_phone_token'];
            require ('info.php');

            if ($httpCode >= 200 && $httpCode < 300) {
                // Incrémentation du nombre de sms reçu et enregistrement dans la base de données
                $_SESSION['utilisateur_sms_count_token'] += 1;

                $stmt_insert_sms = $db_host->prepare('
                    INSERT INTO utilisateurs_sms (id_utilis, date_utilsms, heure_utilsms, nombre_utilsms, code_utilsms) 
                    VALUES (?, ?, ?, ?, ?)
                ');
                $stmt_insert_sms->execute([
                    $_SESSION['utilisateur_id_token'],
                    $_SESSION['utilisateur_sms_date_token'],
                    dateUTC()->format('H\h i\m\i\n s\s'),
                    $_SESSION['utilisateur_sms_count_token'],
                    $_SESSION['utilisateur_sms_code_token']
                ]);
                
                header('Location: pro-app-id-code.php');
                exit;
            }
            else {
                header('Location: pro-app-id-code.php');
                exit;
            }
        }
        else {
            header('Location: pro-app-id-code.php');
            exit;
        }
    }
    catch (Exception $e) {
        header('Location: pro-app-id-code.php');
        exit;
    }
?>