<?php
session_start();
if (!isset($_SESSION['QueenOfVirus'])) {
    header('Location: ../');
}
else {
    header('Location: ../');
}
?>