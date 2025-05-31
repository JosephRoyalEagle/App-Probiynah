(function ($) {
    $(document).ready(function () {
        $("#pass-change-send-btn").on("click", function (e) {
            e.preventDefault();

            var setnewpwd = $("#password-pro-app").val();
            var confnewpwd = $("#pass-confirm-pro-app").val();

            Swal.fire({
                title: 'Validation en cours...',
                text: 'Veuillez patienter',
                allowOutsideClick: false,
                showConfirmButton: true,
                confirmButtonText: 'Ok',
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            if (setnewpwd.length >= 4 && setnewpwd.length <= 100 && confnewpwd.length >= 4 && confnewpwd.length <= 100 && setnewpwd === confnewpwd) {
                $.ajax({
                    url: "pass-change-data-server.php",
                    method: "POST",
                    data: {
                        setnewpwd: setnewpwd,
                        confnewpwd: confnewpwd
                    },
                    success: function (accountVerified) {
                        if (accountVerified.success) {
                            Swal.fire({
                                title: 'Information',
                                text: 'Parfait. Votre mot de passe a été modifié avec succès. Vous pouvez à présent vous connecter.',
                                icon: 'info',
                                showConfirmButton: true,
                                confirmButtonText: 'Ok',
                                timer: 10000,
                                allowOutsideClick: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "index.php";
                                }
                            });
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
                            text: "Une erreur s’est produite lors de la sauveagarde des données, veuillez réessayer.",
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
                  text: "Veuillez saisir un mot de passe d'au moins 4 caractères et le confirmer avec le même mot de passe.",
                  icon: 'error',
                  showConfirmButton: true,
                  confirmButtonText: 'Ok',
                  allowOutsideClick: false
                })
            }
        });
    });
})(jQuery);