<?php
require 'session-control.php';

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
                    <!-- Section titre avec bouton Ajouter -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="section-title m-0"><i class="fas fa-utensils"></i> Gestion des restaurants</h2>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRestaurantModal">
                            <i class="fas fa-plus-circle"></i> Ajouter
                        </button>
                    </div>

                    <!-- Modal Fullscreen -->
                    <div class="modal fade" id="addRestaurantModal" tabindex="-1" aria-labelledby="addRestaurantModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-fullscreen">
                            <div class="modal-content">
                                <div class="modal-header text-white" style="background-color: var(--primary);">
                                    <h5 class="modal-title" id="addRestaurantModalLabel"><i class="fas fa-plus-circle"></i> Enregistrement d'un nouveau restaurant</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <div class="row justify-content-center">
                                            <div class="col-lg-10">
                                                <div class="card shadow">
                                                    <div class="card-body p-4">
                                                        <form id="business-form" class="product-form" enctype="multipart/form-data">
                                                            <div class="form-grid">
                                                                <!-- Colonne de gauche -->
                                                                <div class="form-column">
                                                                    <div class="form-group">
                                                                        <label for="nom_business">Nom du restaurant</label>
                                                                        <input type="text" id="nom_business" name="nom_business" placeholder="Le Gourmet" class="form-control" required>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="description_business">Description</label>
                                                                        <textarea id="description_business" name="description_business" rows="4" class="form-control" placeholder="Restaurant de cuisine francaise" required></textarea>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="adresse_business">Adresse</label>
                                                                        <input type="text" id="adresse_business" name="adresse_business" placeholder="Coco 123, 2eme etage" class="form-control" required>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="id_proprio">Administrateur Restaurant</label>
                                                                        <select id="id_proprio" name="id_proprio" class="form-select" required>
                                                                            <option value="">Sélectionnez un utilisateur</option>
                                                                            <?php
                                                                            $result = $db_host->query("SELECT *,id_utilis, nom_utilis FROM utilisateurs WHERE lower(role_utilis) = 'gestionnaire'");
                                                                            while ($row = $result->fetch()) {
                                                                                echo '<option value="' . $row['id_utilis'] . '">' . ucwords($row['nom_utilis'] . ' ' . $row['prenom_utilis']) . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <!-- Colonne de droite -->
                                                                <div class="form-column">
                                                                    <div class="form-group">
                                                                        <label for="etoile_business">Évaluation (étoiles)</label>
                                                                        <input type="number" id="etoile_business" name="etoile_business" class="form-control" min="1" max="5" value="3">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="id_pays">Pays</label>
                                                                        <select id="id_pays" name="id_pays" class="form-select" required>
                                                                            <option value="">Sélectionnez un pays</option>
                                                                            <?php
                                                                            $result = $db_host->query("SELECT id_pays, libelle_pays FROM pays");
                                                                            while ($row = $result->fetch()) {
                                                                                echo '<option value="' . $row['id_pays'] . '">' . $row['libelle_pays'] . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="id_ville">Ville</label>
                                                                        <select id="id_ville" name="id_ville" class="form-select" required>
                                                                            <option value="">Sélectionnez une ville</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="id_commune">Commune/Quartier</label>
                                                                        <select id="id_commune" name="id_commune" class="form-select">
                                                                            <option value="">Sélectionnez une commune</option>
                                                                        </select>
                                                                    </div>


                                                                    <div class="form-group">
                                                                        <label for="business_image">Image du restaurant</label>
                                                                        <div class="image-upload">
                                                                            <input type="file" id="business_image" name="business_image" class="d-none" accept="image/*">
                                                                            <label for="business_image" class="upload-btn btn btn-outline-secondary w-100">
                                                                                <i class="fas fa-cloud-upload-alt"></i> Choisir une image
                                                                            </label>
                                                                            <span class="file-name text-muted mt-2 d-block">Aucun fichier sélectionné</span>
                                                                        </div>
                                                                        <div class="image-preview mt-3" id="image-preview"></div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-actions justify-content-center mt-4">
                                                                <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">
                                                                    <i class="fas fa-times"></i> Annuler
                                                                </button>
                                                                <button type="submit" class="btn btn-primary submit-btn">
                                                                    <i class="fas fa-save"></i> Enregistrer
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="restaurant-section">
                    <div class="container">
                        <h2>Nos Restaurants</h2>
                        <div class="restaurant-search-bar">
                            <input type="text" id="restaurant-search-input" placeholder="Rechercher un restaurant, une spécialité, une ville..." autocomplete="off">
                            <button id="restaurant-search-btn"><i class="fas fa-search"></i></button>
                        </div>
                        <div class="restaurant-list mt-2" id="restaurant-list">

                        </div>
                    </div>
                </section>

                <section class="no-results-section">
                    <div class="no-results-container">
                        <div class="no-results-icon">
                            <i class="fas fa-search-location"></i>
                        </div>
                        <h2>Aucun résultat trouvé</h2>
                        <p>
                            Désolé, aucun restaurant correspondant n'a été trouvé.<br>
                            Essayez de modifier vos critères de recherche ou de revenir plus tard.
                        </p>
                    </div>
                </section>


                <!-- SECTION RESTAURANTS -->

            </div>
        </div>
    </div>
    <?php
    require_once "script.php";
    ?>
    <script>
        $(document).ready(function() {
            loadRestaurants();
            // Gestion de l'affichage du nom du fichier et prévisualisation
            $('#business_image').change(function() {
                const fileName = $(this).val().split('\\').pop();
                const fileDisplay = $(this).siblings('.file-name');

                if (fileName) {
                    fileDisplay.text(fileName);

                    // Prévisualisation de l'image
                    const preview = $('#image-preview');
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            preview.html('<img src="' + e.target.result + '" class="img-thumbnail mt-2" style="max-height: 200px;">');
                        }
                        reader.readAsDataURL(this.files[0]);
                    }
                } else {
                    fileDisplay.text('Aucun fichier sélectionné');
                    $('#image-preview').empty();
                }
            });

            // Gestion des dépendances pays/ville/commune
            $('#id_pays').change(function() {
                const paysId = $(this).val();
                const villeSelect = $('#id_ville');
                const communeSelect = $('#id_commune');

                villeSelect.html('<option value="">Sélectionnez une ville</option>');
                communeSelect.html('<option value="">Sélectionnez une commune</option>');

                if (paysId) {
                    // Chargement AJAX des villes
                    $.ajax({
                        url: 'get_villes_filter.php',
                        method: 'POST',
                        data: {
                            id_pays: paysId,
                            action: 'get_villes'
                        },
                        dataType: 'json',
                        success: function(data) {
                            //console.log(data);
                            $.each(data, function(index, ville) {
                                villeSelect.append($('<option>', {
                                    value: ville.id_ville,
                                    text: ville.nom_ville
                                }));

                            });
                        },
                        error: function() {
                            console.error('Erreur lors du chargement des villes');
                        }
                    });
                }
            });

            $('#id_ville').change(function() {
                const villeId = $(this).val();
                const communeSelect = $('#id_commune');

                communeSelect.html('<option value="">Sélectionnez une commune</option>');

                if (villeId) {
                    // Chargement AJAX des communes
                    $.ajax({
                        url: 'get_communes_filter.php',
                        method: 'POST',
                        data: {
                            id_ville: villeId,
                            action: 'get_communes'
                        },
                        dataType: 'json',
                        success: function(data) {
                            console.log(data);
                            $.each(data, function(index, commune) {
                                communeSelect.append($('<option>', {
                                    value: commune.id_commune,
                                    text: commune.nom_commune
                                }));
                            });
                        },
                        error: function() {
                            console.error('Erreur lors du chargement des communes');
                        }
                    });
                }
            });

            // Soumission du formulaire
            $('#business-form').submit(function(e) {

                e.preventDefault();

                const formData = new FormData(this);
                formData.append('action', 'add_restaurant');

                $.ajax({
                    url: 'add-restaurants.php',
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('.submit-btn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Enregistrement...');
                    },
                    success: function(response) {
                        console.log(response);
                        // Fermer le modal et recharger la liste
                        $('#addRestaurantModal').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Restaurant enregistré avec succès'
                        });
                        // Recharger la liste ou mettre à jour l'interface
                        loadRestaurants();
                    },
                    error: function(xhr) {
                        let errorMsg = 'Erreur lors de l\'enregistrement';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        Toast.fire({
                            icon: 'error',
                            title: errorMsg
                        });
                    },
                    complete: function() {
                        $('.submit-btn').prop('disabled', false).html('<i class="fas fa-save"></i> Enregistrer');
                    }
                });
            });

            /* Initialisation de Toast (SweetAlert2)
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });*/

            // Configuration de base du Toast
            const Toast = Swal.mixin({
                toast: false, // Désactive le style toast (pour une popup classique)
                position: 'center',
                showConfirmButton: true,
                confirmButtonText: 'Ok',
                timerProgressBar: false, // Inutile sans timer
                allowOutsideClick: false, // Empêche la fermeture en cliquant à l'extérieur
                allowEscapeKey: false // Empêche la fermeture avec la touche ESC
            });

            // Réinitialiser le formulaire quand le modal est fermé
            $('#addRestaurantModal').on('hidden.bs.modal', function() {
                $('#business-form')[0].reset();
                $('.file-name').text('Aucun fichier sélectionné');
                $('#image-preview').empty();
            });
        });

        function loadRestaurants() {
            $.ajax({
                url: 'get_restaurants.php',
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    const container = $('#restaurant-list');
                    const noResultsSection = $('.no-results-section');

                    if (response.status === 'success') {
                        container.empty();

                        if (response.data.length === 0) {
                            container.hide();
                            noResultsSection.show();
                        } else {
                            noResultsSection.hide();

                            response.data.forEach(r => {
                                const imageUrl = r.nomfichier_business_assets ?
                                    `../../uploads/business/${r.nomfichier_business_assets}` :
                                    'https://via.placeholder.com/400x250?text=Aucune+image';

                                const cardHTML = `
                            <div class="restaurant-card" data-id="${r.id_business}">
                                <div class="restaurant-photo">
                                    <div class="restaurant-stars">${r.stars_html}</div>
                                    <img src="${imageUrl}" alt="${r.nom_business}">
                                </div>
                                <div class="restaurant-info">
                                    <h3 class="restaurant-name">${r.nom_business}</h3>
                                    <p class="restaurant-address">
                                        <i class="fas fa-map-marker-alt" style="color:var(--primary);"></i> ${r.adresse_business}
                                    </p>
                                    <p class="restaurant-desc">${r.description_business}</p>
                                    <div class="d-flex flex-column gap-2 mt-2">
                                        <div class="d-flex gap-2">
                                            <button class="restaurant-choose-btn compact-btn flex-grow-1">
                                                <i class="fas fa-arrow-right"></i> Entrer
                                            </button>
                                            <button class="btn btn-primary btn-sm editBtn compact-btn flex-grow-1" data-id="${r.id_business}">
                                                <i class="fas fa-edit"></i> Modifier
                                            </button>
                                        </div>
                                        <button class="btn btn-danger btn-sm deleteBtn compact-btn w-100" data-id="${r.id_business}" data-confirm='${r.delete_confirmation}'>
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    </div>
                                </div>
                            </div>
                            ${r.modal_html}
                        `;
                                container.append(cardHTML);
                            });

                            // Gestion des événements
                            $('.editBtn').on('click', function() {
                                const id = $(this).data('id');
                                $(`#modalUpdateRestaurant${id}`).modal('show');
                            });

                            $('.deleteBtn').on('click', function() {
                                const id = $(this).data('id');
                                const confirmData = JSON.parse($(this).attr('data-confirm'));

                                Swal.fire({
                                    ...confirmData,
                                    showCancelButton: true,
                                    confirmButtonColor: '#d33',
                                    cancelButtonColor: '#3085d6'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $.ajax({
                                            url: 'delete-restaurant.php',
                                            method: 'POST',
                                            data: {
                                                id_business: id,
                                                action: 'delete_restaurant'
                                            },
                                            success: function(res) {
                                                if (res.success) {
                                                    Swal.fire('Supprimé !', res.message, 'success');
                                                    loadRestaurants();
                                                } else {
                                                    Swal.fire('Erreur', res.message, 'error');
                                                }
                                            }
                                        });
                                    }
                                });
                            });

                            // Gestion de la soumission des modals
                            $('[id^="restaurant-form-"]').on('submit', function(e) {
                                e.preventDefault();
                                const form = $(this);
                                const formData = new FormData(form[0]);
                                const id = form.find('input[name="restaurantId"]').val();

                                $.ajax({
                                    url: 'update-restaurant.php',
                                    method: 'POST',
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(res) {
                                        if (res.status === 'success') {
                                            Swal.fire('Succès !', res.message, 'success');
                                            $(`#modalUpdateRestaurant${id}`).modal('hide');
                                            loadRestaurants();
                                        } else {
                                            Swal.fire('Erreur', res.message, 'error');
                                        }
                                    }
                                });
                            });
                        }
                    } else {
                        container.hide();
                        noResultsSection.show();
                    }
                },
                error: function() {
                    $('#restaurant-list').hide();
                    $('.no-results-section').show();
                }
            });
        }
    </script>

    <script type="text/javascript">
        function applyDataLabelsAfterDT() {
            const table = document.querySelector('#product-table');
            if (!table) return;
            const ths = Array.from(table.querySelectorAll('thead th'));
            table.querySelectorAll('tbody tr').forEach(row => {
                Array.from(row.children).forEach((td, idx) => {
                    td.setAttribute('data-label', ths[idx] ? ths[idx].textContent.trim() : '');
                });
            });
        }
        // Quand DataTables a fini de dessiner une page
        $('#product-table').on('draw.dt', function() {
            applyDataLabelsAfterDT();

            // Remet les modals dans le body (ton code existant)
            $('.modal').each(function() {
                if (!$(this).parent().is('body')) {
                    $(this).appendTo('body');
                }
            });
        });
    </script>

</body>

</html>