<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    require "sinup-head.php";
    ?>
    <title>Formulaire d'inscription</title>
</head>

<body>
    <?php
    require "preloader.php";
    ?>
    <div class="sunrise-gradient-bg"></div>
    <main class="form-container">

        <form class="orange-signup-card" id="registrationForm">
            <div class="form-branding">

                <div class="logo">
                    <img src="assets/img/LOGOPB.png" alt="Logo Probiynah">
                </div>
                <h1>Créez votre compte</h1>
                <p class="form-subheading">Saisissez vos informations.</p>
            </div>
            <div class="form-field-group">
                <label for="name">Nom</label>
                <input type="text" id="name" name="name" placeholder="Votre nom" autocomplete="family-name" required>
                <span class="field-error-msg"></span>
            </div>
            <div class="form-field-group">
                <label for="firstname">Prénoms</label>
                <input type="text" id="firstname" name="firstname" placeholder="Vos prénoms" autocomplete="given-name" required>
                <span class="field-error-msg"></span>
            </div>
            <div class="form-field-group">
                <label for="phone">Numéro de téléphone</label>
                <input type="tel" id="phone" name="phone" placeholder="Ex: 0701020304" autocomplete="tel" required pattern="^0[1-9]\d{8}$">
                <span class="field-error-msg"></span>
            </div>
            <div class="form-field-group">
                <label for="password">Mot de passe</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" placeholder="Votre mot de passe" autocomplete="new-password" required minlength="6">
                    <button type="button" class="password-visibility" tabindex="-1" aria-label="Montrer/Masquer le mot de passe">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
                <span class="field-error-msg"></span>
                <div class="password-meter" id="pwStrengthBar"></div>
            </div>

            <button type="submit" class="citrus-submit-btn" tabindex="0">
                <span>Créer un compte</span>
            </button>
            <div class="form-links">
                <a href="index.php" class="text-link"><i class="fa-solid fa-right-to-bracket"></i> Se connecter</a>
                <a href="https://www.probiynah.com" class="text-link"><i class="fa-solid fa-globe"></i> Accéder au site</a>
            </div>
            <div class="form-success-banner" id="successMsg" style="display:none;">
                ✅ Compte créé avec succès ! Bienvenue !
            </div>
        </form>
    </main>
    <footer class="form-footer">
        <span>&copy; 2024 - Tous droits réservés.</span>
    </footer>
    <script type="module" src="assets/js/form.js"></script>
    <?php
    require("script.php");
    ?>
</body>

</html>