<?php
  require 'session-start.php';
  require 'dbcaller/dbcaller.php';
  require 'fonction.php';
?>
<html lang="fr">
<head>
    <?php
        require "head.php";
    ?>
    <title>Vérification d'identité - Probiynah App</title>
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
        <h2>Vérification d'identité</h2>
        <form id="loginForm">
            <div class="form-group">
                <label for="code-sms-pro-app">Code:</label>
                <input type="text" id="code-sms-pro-app" class="code-sms-pro-app" name="code-sms-pro-app" placeholder="65877" minlength="6" maxlength="6" required>
            </div>
            <button id="id-verify-send-btn" class="id-verify-send-btn" type="button">Continuer</button>
        </form>
        <div class="login-links">
            <a href="index.php" class="forgot-pass">Retour à l'accueil</a>
        </div>
    </div>
    <?php
        require("script.php");
    ?>
</body>
</html>