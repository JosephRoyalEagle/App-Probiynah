document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registrationForm');
    const passwordInput = form.querySelector('#password');
    const passwordWrapper = form.querySelector('.password-wrapper');
    const passwordToggle = passwordWrapper.querySelector('.password-visibility');
    const passwordMeter = document.getElementById('pwStrengthBar');
    
    // Initialiser la barre de force
    passwordMeter.innerHTML = '<div class="password-meter-bar"></div>';
    const strengthBar = passwordMeter.querySelector('.password-meter-bar');

    // Fonction pour mettre à jour la force du mot de passe
    function updatePasswordStrength(password) {
        let strength = 0;
        
        // Calcul simple de la force
        if (password.length >= 6) strength = 1; // Faible (orange)
        if (password.length >= 8) strength = 2; // Moyen (jaune)
        if (password.length >= 10) strength = 3; // Bon (vert clair)
        if (password.length >= 12) strength = 4; // Fort (vert)
        
        // Mettre à jour la barre
        strengthBar.style.width = (strength * 25) + '%';
        strengthBar.className = 'password-meter-bar'; // Réinitialiser les classes
        
        // Ajouter la classe de force appropriée
        switch(strength) {
            case 1: strengthBar.classList.add('pw-weak'); break;
            case 2: strengthBar.classList.add('pw-fair'); break;
            case 3: strengthBar.classList.add('pw-good'); break;
            case 4: strengthBar.classList.add('pw-strong'); break;
        }
    }

    // Toggle visibilité mot de passe
    passwordToggle.addEventListener('click', function() {
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            this.querySelector('i').classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            passwordInput.type = "password";
            this.querySelector('i').classList.replace('fa-eye-slash', 'fa-eye');
        }
    });

    // Validation en temps réel
    passwordInput.addEventListener('input', function() {
        const errorEl = this.closest('.form-field-group').querySelector('.field-error-msg');
        
        // Vérification longueur
        if (this.value.length < 6 && this.value.length > 0) {
            errorEl.textContent = "Au moins 6 caractères";
        } else {
            errorEl.textContent = "";
        }
        
        // Mettre à jour la barre de force
        updatePasswordStrength(this.value);
    });

    // Validation lors de la perte de focus
    passwordInput.addEventListener('blur', function() {
        const errorEl = this.closest('.form-field-group').querySelector('.field-error-msg');
        if (this.value.length < 6) {
            errorEl.textContent = "Au moins 6 caractères";
        }
    });
});