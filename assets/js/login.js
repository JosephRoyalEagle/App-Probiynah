(function ($) {
    $(document).ready(function () {
        $("#connect-send-btn").on("click", function (e) {
            e.preventDefault();

            var phonenumber = $("#phone-pro-app").val().trim();
            var password = $("#password-pro-app").val();

            if (!/^\d{10}$/.test(phonenumber) || password.length < 4 || password.length > 100) {
                Swal.fire({
                    title: 'Erreur',
                    text: "Veuillez saisir un numéro de téléphone valide (10 chiffres) et un mot de passe entre 4 et 100 caractères.",
                    icon: 'error',
                    showConfirmButton: true,
                    confirmButtonText: 'Ok',
                    allowOutsideClick: false
                });
                return;
            }

            Swal.fire({
                title: 'Connexion en cours...',
                text: 'Veuillez patienter',
                allowOutsideClick: false,
                showConfirmButton: true,
                confirmButtonText: 'Ok',
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: "login-data-server.php",
                method: "POST",
                data: {
                    phonenumber: phonenumber,
                    password: password
                },
                success: function (accountVerified) {
                    if (accountVerified.success) {
                        Swal.fire({
                            title: 'Connexion réussie',
                            text: 'Redirection en cours...',
                            icon: 'success',
                            showConfirmButton: true,
                            confirmButtonText: 'Ok',
                            timer: 2000,
                            allowOutsideClick: false
                        });
                    
                        setTimeout(function () {
                            window.location.href = "lantern/";
                        }, 2000);
                    } else {
                        Swal.fire({
                            title: 'Erreur',
                            text: accountVerified.msg,
                            icon: 'error',
                            showConfirmButton: true,
                            confirmButtonText: 'Ok',
                            allowOutsideClick: false
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        title: 'Erreur serveur',
                        text: "Une erreur s'est produite. Veuillez réessayer plus tard.",
                        icon: 'error',
                        showConfirmButton: true,
                        confirmButtonText: 'Ok',
                        allowOutsideClick: false
                    });
                }
            });
        });
    });
})(jQuery);