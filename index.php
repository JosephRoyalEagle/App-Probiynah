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
    <title>Connexion - Probiynah App</title>
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
        <h2>Connexion</h2>
        <form id="loginForm">
            <div class="form-group">
                <label for="numero">Numéro:</label>
                <input type="text" id="numero" name="numero" required>
            </div>
            <div class="form-group password-group">
                <label for="password">Mot de passe:</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" required>
                    <button type="button" id="togglePassword" tabindex="-1" aria-label="Afficher le mot de passe" class="eye-toggle" title="Afficher le mot de passe">
                        <svg id="eyeIcon" width="22" height="22" viewBox="0 0 22 22" fill="none">
                            <path class="eye" d="M1.8 11C3.6 6.2 8 3 11 3c3.1 0 7.4 3.2 9.2 8-1.8 4.8-6.1 8-9.2 8-3 0-7.4-3.2-9.2-8z" stroke="#f3951f" stroke-width="2" fill="none"/>
                            <circle class="pupil" cx="11" cy="11" r="3" fill="#f3951f" opacity="0.55"/>
                            <path class="slash" d="M6 16L16 6" stroke="#c37314" stroke-width="2" stroke-linecap="round" style="display:none"/>
                        </svg>
                    </button>
                </div>
            </div>
            <button type="submit">Se connecter</button>
        </form>
        <div class="login-links">
            <a href="#" class="forgot-pass">Mot de passe oublié?</a>
            <span class="links-separator">|</span>
            <a href="#" class="go-to-site">Pas de compte, inscrivez vous!</a>
        </div>
    </div>
    <?php
        require("script.php");
    ?>
</body>
</html>