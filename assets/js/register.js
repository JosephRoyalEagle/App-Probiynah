(function ($) {
    $(document).ready(function () {
        $("#signup-send-btn").on("click", function (e) {
            e.preventDefault();

            var phonenumber = $("#phone-pro-app").val().trim();
            var password = $("#password-pro-app").val();
            var lastname = $("#lastname-pro-app").val();
            var firstname = $("#firstname-pro-app").val();

            Swal.fire({
                title: 'Inscription en cours...',
                text: 'Veuillez patienter',
                allowOutsideClick: false,
                showConfirmButton: true,
                confirmButtonText: 'Ok',
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: "register-data-server.php",
                method: "POST",
                data: {
                    phonenumber: phonenumber,
                    password: password,
                    lastname: lastname,
                    firstname: firstname
                },
                success: function (accountVerified) {
                    if (accountVerified.success) {
                        Swal.fire({
                            title: 'Inscription réussie',
                            text: 'Connexion en cours...',
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