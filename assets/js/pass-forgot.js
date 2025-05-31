(function ($) {
    $(document).ready(function () {
        $("#pass-forgot-send-btn").on("click", function (e) {
            e.preventDefault();

            var phonenumber = $("#phone-pro-app").val().trim();

            if (!/^\d{10}$/.test(phonenumber)) {
                Swal.fire({
                    title: 'Erreur',
                    text: "Veuillez saisir un numéro de téléphone valide (10 chiffres).",
                    icon: 'error',
                    showConfirmButton: true,
                    confirmButtonText: 'Ok',
                    allowOutsideClick: false
                });
                return;
            }

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

            $.ajax({
                url: "pass-forgot-data-server.php",
                method: "POST",
                data: {
                    phonenumber: phonenumber
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
                                text: 'Un SMS contenant un code de 4 caractères vous a été envoyé. Veuillez le saisir dans la section suivante pour confirmer votre identité.',
                                icon: 'info',
                                showConfirmButton: true,
                                confirmButtonText: 'Ok',
                                timer: 3000,
                                allowOutsideClick: false
                            });
                        
                            setTimeout(function () {
                                window.location.href = "pro-app-id-code.php";
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