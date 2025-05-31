<?php
require 'session-control.php';

$get_pfrlo_encrypt = $_GET['pfrlo'] ?? null;
$get_pfrlon_encrypt = $_GET['pfrlon'] ?? null;
$pfrlo_key_byte = '';

$id_plain_text = $get_pfrlo_encrypt ? decryptData($get_pfrlo_encrypt) : null;
$nom_plain_text = $get_pfrlon_encrypt ? decryptData($get_pfrlon_encrypt) : null;

$roles_key = [
    'SAdmin' => 'Administrateur',
    'Gestionnaire' => 'Gestionnaire',
];

// Si les données décryptées sont valides
if (isset($_GET['pfrlo']) && isset($_GET['pfrlon'])) {
    $stmt_user_check_profile = $db_host->prepare("SELECT * FROM utilisateurs WHERE id_utilis = ?");
    $stmt_user_check_profile->execute([$id_plain_text]);
    $stmt_user_response_profile = $stmt_user_check_profile->fetch(PDO::FETCH_ASSOC);
    $pfrlo_key_byte = $_GET['pfrlo'];
} else {
    // fallback : utilisateur connecté
    $stmt_user_check_profile = $db_host->prepare("SELECT * FROM utilisateurs WHERE id_utilis = ?");
    $stmt_user_check_profile->execute([$_SESSION['appro_connect_active_id_token']]);
    $stmt_user_response_profile = $stmt_user_check_profile->fetch(PDO::FETCH_ASSOC);
    $pfrlo_key_byte = encryptData($_SESSION['appro_connect_active_id_token']);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
        require "head.php";
    ?>
    <title>Administration - Probiynah App</title>
</head>

<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <?php
            require "sidebar.php";
        ?>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <?php
                require "navbar.php";
            ?>

            <!-- Content Body -->
            <div class="content-body">
                <section class="dashboard-section">
                    <h2 class="section-title"><i class="fas fa-user-circle"></i> Mon Profil</h2>
                    <div class="card-container">
                        <div class="card">
                            <div class="profile-header">
                                <div class="profile-avatar">
                                    <i id="profile-picture" class="fas fa-user-circle"></i>
                                </div>
                                <div class="profile-info">
                                    <h3><?= $roles_key[$stmt_user_response_profile['role_utilis']] ?? 'Inconnu' ?></h3>
                                </div>
                            </div>

                            <div class="profile-details">
                                <ul class="info-list">
                                    <li>
                                        <strong><i class="fas fa-user"></i> Nom & prénoms:</strong>
                                        <span><?= $stmt_user_response_profile['nom_utilis'] ?> <?=$stmt_user_response_profile['prenom_utilis']?></span>
                                    </li>
                                    <li>
                                        <strong><i class="fas fa-phone"></i> Téléphone:</strong>
                                        <span><?= $stmt_user_response_profile['numero_utilis'] ?></span>
                                    </li>
                                    <li>
                                        <strong><i class="fas fa-graduation-cap"></i> Role:</strong>
                                        <span><?= $roles_key[$stmt_user_response_profile['role_utilis']] ?? 'Inconnu' ?></span>
                                    </li>
                                    <li>
                                        <strong><i class="fas fa-check"></i> Statut:</strong>
                                        <span><?= $stmt_user_response_profile['statut_utilis'] ?></span>
                                    </li>
                                    <li>
                                        <strong><i class="fas fa-calendar-check"></i> Inscrit(e) depuis:</strong>
                                        <span><?= date('d-m-Y', strtotime($stmt_user_response_profile['dateinscription_utilis'])) ?></span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="card">
                            <h3 class="card-title"><i class="fas fa-edit"></i> Modifier le profil</h3>
                            <form class="pfrlo-profile-form" id="pfrlo-profile-form" enctype="multipart/form-data">
                                <div class="form-group mb-3">
                                    <label for="pfrlo_lastname">Nom</label>
                                    <input type="text" id="pfrlo_lastname" placeholder="Kouassi">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="pfrlo_firstname">Prénoms</label>
                                    <input type="text" id="pfrlo_firstname" placeholder="Jean Pierre">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="pfrlo_phone">Téléphone</label>
                                    <input type="tel" id="pfrlo_phone" placeholder="0748820304">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="pfrlo_typecompte">Type de compte</label>
                                    <select id="pfrlo_typecompte">
                                        <option value="">Sélectionnez</option>
                                        <option value="SAdmin">Super administrateur</option>
                                        <option value="Gestionnaire">Responsable restaurant / Hotel</option>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="pfrlo_typecompte">Statut</label>
                                    <select id="pfrlo_statut">
                                        <option value="">Sélectionnez</option>
                                        <option value="Actif">Actif</option>
                                        <option value="Verrouiller">Verrouiller</option>
                                    </select>
                                </div>

                                <input type="hidden" id="pfrlo_key_byte" value="<?= $pfrlo_key_byte ?>" required readonly>

                                <div class="form-actions justify-content-center">
                                    <button type="button" class="save-btn btn-primary" id="btn-sub-profile">
                                        <i class="fas fa-save"></i> Appliquer
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <?php
        require "script.php";
    ?>
    <script>
        (function ($) {
            $('#btn-sub-profile').on('click', function() {
                // Récupérer les données du formulaire                
                const formDataSubmit = {
                    nomUserForm: $('#pfrlo_lastname').val(),
                    prenomUserForm: $('#pfrlo_firstname').val(),
                    phoneUserForm: $('#pfrlo_phone').val(),
                    typecompteUserForm: $('#pfrlo_typecompte').val(),
                    statutUserForm: $('#pfrlo_statut').val(),
                    keyUserForm: $('#pfrlo_key_byte').val(),
                    
                };

                // Appel Ajax pour envoyer les données
                $.ajax({
                    url: 'manage-profile-dv.php',
                    type: 'POST',
                    data: formDataSubmit,
                    success: function (ajaxResponseJson) {
                        if (ajaxResponseJson.success) {
                            Swal.fire({
                                title: 'Enregistré !',
                                text: "Le profil a bien été mis à jour.",
                                icon: 'success',
                                showConfirmButton: true,
                                confirmButtonText: 'Ok',
                                allowOutsideClick: false
                            }).then(() => {
                                $('#pfrlo-profile-form')[0].reset();
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Erreur !',
                                text: ajaxResponseJson.msg,
                                icon: 'error',
                                showConfirmButton: true,
                                confirmButtonText: 'Ok',
                                allowOutsideClick: false
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            title: 'Erreur !',
                            text: "Une erreur est survenue. Veuillez réessayer.",
                            icon: 'error',
                            showConfirmButton: true,
                            confirmButtonText: 'Ok',
                            allowOutsideClick: false
                        });
                    }
                });
            });
        })(jQuery);
    </script>
</body>

</html>