<?php
    require 'session-start.php';
    require 'dbcaller/dbcaller.php';
    require 'fonction.php';
    require 'session-dashboard-noback.php';
?>
<html lang="fr">
<head>
    <?php
        require "head.php";
    ?>
    <title>Réinitialisation d'accès - Probiynah App</title>
</head>
<body>
    <?php
        require "preloader.php";
    ?>
    <canvas id="animated-bg"></canvas>
    <div class="login-container">
        <div class="logo">
            <img src="assets/img/LOGOPB.png" alt="Logo Probiynah">
        </div>
        <h2>Réinitialisation d'accès</h2>
        <form id="loginForm">
            <div class="form-group">
                <label for="phone-pro-app">Numéro:</label>
                <input type="text" id="phone-pro-app" class="phone-pro-app" name="phone-pro-app" placeholder="0748896587" minlength="10" maxlength="10" required>
            </div>
            <button id="pass-forgot-send-btn" class="pass-forgot-send-btn" type="button">Continuer</button>
        </form>
        <div class="login-links">
            <a href="index.php" class="forgot-pass">Retour à l'accueil</a>
        </div>
    </div>
    <?php
        require("script.php");
    ?>
    <script src="assets/js/pass-forgot.js"></script>
</body>
</html>