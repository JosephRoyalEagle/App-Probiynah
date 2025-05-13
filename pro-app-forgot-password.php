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
                <label for="numero">Numéro:</label>
                <input type="text" id="numero-pro-app" class="numero-pro-app" name="numero-pro-app" placeholder="0748896587" minlength="10" maxlength="10" required>
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
</body>
</html>