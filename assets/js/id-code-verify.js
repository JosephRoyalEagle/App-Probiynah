(function ($) {
    $(document).ready(function () {
        $("#id-verify-send-btn").on("click", function (e) {
            e.preventDefault();

            var phonenumbercode = $("#code-sms-pro-app").val().trim();

            Swal.fire({
                title: 'Vérification en cours...',
                text: 'Veuillez patienter',
                allowOutsideClick: false,
                showConfirmButton: true,
                confirmButtonText: 'Ok',
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            if (phonenumbercode.length === 4) {
                $.ajax({
                    url: "id-code-data-server.php",
                    method: "POST",
                    data: {
                        phonenumbercode: phonenumbercode
                    },
                    success: function (accountVerified) {
                        if (accountVerified.success) {
                            Swal.fire({
                                title: 'Vérification terminée',
                                text: 'Redirection en cours...',
                                icon: 'success',
                                showConfirmButton: true,
                                confirmButtonText: 'Ok',
                                timer: 2000,
                                allowOutsideClick: false
                            });
                            setTimeout(function () {
                                Swal.fire({
                                    title: 'Information',
                                    text: 'Identité confirmée avec succès. Vous serez redirigé vers la page de changement de mot de passe.',
                                    icon: 'info',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok',
                                    timer: 3000,
                                    allowOutsideClick: false
                                });
                            
                                setTimeout(function () {
                                    window.location.href = "pro-app-pass-change.php";
                                }, 3000);
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
                            text: "Une erreur s’est produite lors de la verification du code, veuillez réessayer.",
                            icon: 'error',
                            showConfirmButton: true,
                            confirmButtonText: 'Ok',
                            allowOutsideClick: false
                        });
                    }
                });
            }
            else {
                Swal.fire({
                  title: 'Erreur',
                  text: 'Veuillez saisir le code de 4 caractères contenus dans le SMS envoyé à votre numéro de téléphone.',
                  icon: 'error',
                  showConfirmButton: true,
                  confirmButtonText: 'Ok',
                  allowOutsideClick: false
                })
            }
        });
    });
})(jQuery);