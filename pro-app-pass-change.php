<?php
  require 'session-start.php';
  require 'dbcaller/dbcaller.php';
  require 'fonction.php';
  require 'session-control.php';
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
            <div class="form-group password-group">
                <label for="password-pro-app">Nouveau mot de passe:</label>
                <div class="password-wrapper">
                    <input type="password" id="password-pro-app" name="password-pro-app" placeholder="*********" minlength="4" maxlength="100" required>
                    <button type="button" id="togglePassword" tabindex="-1" aria-label="Afficher le mot de passe" class="eye-toggle" title="Afficher le mot de passe">
                        <svg id="eyeIcon" width="22" height="22" viewBox="0 0 22 22" fill="none">
                            <path class="eye" d="M1.8 11C3.6 6.2 8 3 11 3c3.1 0 7.4 3.2 9.2 8-1.8 4.8-6.1 8-9.2 8-3 0-7.4-3.2-9.2-8z" stroke="#f3951f" stroke-width="2" fill="none"/>
                            <circle class="pupil" cx="11" cy="11" r="3" fill="#f3951f" opacity="0.55"/>
                            <path class="slash" d="M6 16L16 6" stroke="#c37314" stroke-width="2" stroke-linecap="round" style="display:none"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="form-group password-group">
                <label for="pass-confirm-pro-app">Confirmez mot de passe:</label>
                <div class="password-wrapper">
                    <input type="password" id="pass-confirm-pro-app" name="pass-confirm-pro-app" placeholder="*********" minlength="4" maxlength="100" required>
                    <button type="button" id="toggleConfirmPassword" tabindex="-1" aria-label="Afficher le mot de passe" class="eye-toggle" title="Afficher le mot de passe">
                        <svg id="eyeIcon" width="22" height="22" viewBox="0 0 22 22" fill="none">
                            <path class="eye" d="M1.8 11C3.6 6.2 8 3 11 3c3.1 0 7.4 3.2 9.2 8-1.8 4.8-6.1 8-9.2 8-3 0-7.4-3.2-9.2-8z" stroke="#f3951f" stroke-width="2" fill="none"/>
                            <circle class="pupil" cx="11" cy="11" r="3" fill="#f3951f" opacity="0.55"/>
                            <path class="slash" d="M6 16L16 6" stroke="#c37314" stroke-width="2" stroke-linecap="round" style="display:none"/>
                        </svg>
                    </button>
                </div>
            </div>
            <button id="pass-change-send-btn" class="pass-change-send-btn" type="button">Appliquer</button>
        </form>
        <div class="login-links">
            <a href="index.php" class="forgot-pass">Retour à l'accueil</a>
        </div>
    </div>
    <?php
        require("script.php");
    ?>
    <script src="assets/js/pass-change.js"></script>
</body>
</html>