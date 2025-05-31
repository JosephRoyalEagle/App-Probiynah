<?php
require 'session-control.php';
// Récupérer la liste des pays
$sql = "SELECT id_ville, nom_ville FROM ville ORDER BY nom_ville ASC";
$result = $db_host->prepare($sql);
$result->execute();
$pays = $result->fetchAll(PDO::FETCH_ASSOC);

// Créer une chaîne HTML pour les options
$options = "";
foreach ($pays as $row) {
    $options .= '<option value="' . htmlspecialchars($row["id_ville"]) . '">' . htmlspecialchars($row["nom_ville"]) . '</option>';
}

// Si aucun pays n'est trouvé, on affiche un message d'erreur
if (empty($options)) {
    $options = '<option value="">Aucune ville trouvée</option>';
}

// Passer cette chaîne à JavaScript via un objet JSON ou une variable JavaScript
echo "<script>var villeOptions = '$options';</script>";

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
                        <h2 class="section-title m-0"><i class="fas fa-building"></i> Gestion des communes</h2>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addpaysModal">
                            <i class="fas fa-plus-circle"></i> Ajouter
                        </button>
                    </div>

                    <!-- Modal Fullscreen -->
                    <div class="modal fade" id="addpaysModal" tabindex="-1" aria-labelledby="addpaysModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-fullscreen">
                            <div class="modal-content">
                                <div class="modal-header text-white" style="background-color: var(--primary);">
                                    <h5 class="modal-title" id="addpaysModalLabel"><i class="fas fa-plus-circle"></i> Enregistrement d'une nouvelle commune</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <div class="row justify-content-center">
                                            <div class="col-lg-10">
                                                <div class="card shadow">
                                                    <div class="card-body p-4">
                                                        <form id="business-form" class="product-form" enctype="multipart/form-data">
                                                            <div class="form-grid d-flex justify-content-center">
                                                                <!-- Colonne de gauche -->
                                                                <div class="form-column">
                                                                    <div class="justify-content-center mt-4">
                                                                        <div class="row justify-content-center">
                                                                            <div class="form-group col-md-6">
                                                                                <label for="nom_ville">Nom de la ville</label>
                                                                                <?php
                                                                                // Récupérer la liste des pays
                                                                                $sql = "SELECT id_ville, nom_ville FROM ville ORDER BY nom_ville ASC";
                                                                                $result = $db_host->prepare($sql);
                                                                                $result->execute();
                                                                                $pays = $result->fetchAll(PDO::FETCH_ASSOC); // Utilise fetchAll pour récupérer tous les résultats

                                                                                if (count($pays) > 0) {
                                                                                    echo '<select class="form-control" id="nom_ville" name="nom_ville" required>';
                                                                                    echo '<option value="">-- Sélectionnez une ville --</option>';
                                                                                    foreach ($pays as $row) {
                                                                                        echo '<option value="' . htmlspecialchars($row["id_ville"]) . '">' . ucwords(htmlspecialchars($row["nom_ville"])) . '</option>';
                                                                                    }
                                                                                    echo '</select>';
                                                                                } else {
                                                                                    echo '<p>Aucun pays trouvé.</p>';
                                                                                }
                                                                                ?>

                                                                            </div>

                                                                            <div class="form-group col-md-6">
                                                                                <label for="nom_com">Nom de la commune</label>
                                                                                <input type="text" id="nom_com" name="nom_com" class="form-control" placeholder="Cocody" required>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="form-actions justify-content-center mt-4">
                                                                <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">
                                                                    <i class="fas fa-times"></i> Annuler
                                                                </button>
                                                                <button type="button" class="btn btn-primary submit-btn" id="submit-btn">
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

                <section class="product-table-section">
                    <div class="container">

                        <h2>Liste des communes (<span id="totalDataReturn" class="text-danger"></span>)</h2>
                        <div class="row mb-3">
                            <div class="col-6 col-md-3">
                                <label for="customDateDebut" style="font-weight: bold; color: #000;">Date début :</label>
                                <input type="date" id="customDateDebut" class="form-control" style="border: 2px solid #000; outline: none;">
                            </div>
                            <div class="col-6 col-md-3">
                                <label for="customDateFin" style="font-weight: bold; color: #000;">Date fin :</label>
                                <input type="date" id="customDateFin" class="form-control" style="border: 2px solid #000; outline: none;">
                            </div>
                        </div>


                        <div class="card shadow">
                            <div class="card-body">
                                <table class="product-table" id="product-table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">N°</th>
                                            <th class="text-center">Commune</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Heure</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>


                            </div>
                        </div>
                    </div>
                </section>

                <!-- SECTION RESTAURANTS -->

            </div>
        </div>
    </div>
    <?php
    require "script.php";
    ?>
    <script>
        $(document).ready(function() {

            $('#submit-btn').click(function(e) {
                e.preventDefault();
                // Soumission du formulaire
                const formData = new FormData(document.getElementById('business-form'));
                formData.append('action', 'add_commununes');
                //console.log(formData.getAll('nom_ville'));
                $.ajax({
                    url: 'add-commununes.php',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    type: 'json',
                    beforeSend: function() {
                        $('.submit-btn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Enregistrement...');
                    },
                    success: function(response) {
                        // Afficher le message de succès
                        if (response.success) {
                            Toast.fire({
                                icon: 'success',
                                title: 'success',
                                text: response.message,
                            }).then(() => {
                                // Recharger le DataTable après la fermeture du Toast
                                $('#product-table').DataTable().ajax.reload(null, false); // false pour garder la pagination actuelle
                            });
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: response.message,
                            });
                        }

                        // 1. Fermer le modal immédiatement
                        $('#addpaysModal').modal('hide');
                        // 2. Vider le formulaire
                        $('#business-form')[0].reset();

                    },
                    error: function(xhr) {
                        console.log(xhr);
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




            // Initialisation de Toast (SweetAlert2)
            /*const Toast = Swal.mixin({
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

            // Fonction pour afficher un message et recharger après confirmation
            function showAlertAndReload(title, message, icon = 'success') {
                Toast.fire({
                    title: title,
                    text: message,
                    icon: icon
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#paysTable').DataTable().ajax.reload(); // Rechargement plus propre
                    }
                });
            }
            loadPays();

            function loadPays() {
                // Initialisation de DataTables
                const isMobile = window.innerWidth <= 600;

                new DataTable('#product-table', {
                    processing: true,
                    serverSide: true,
                    scrollCollapse: true,
                    scroller: !isMobile,
                    scrollY: isMobile ? null : 800,
                    deferRender: true,
                    layout: {
                        topStart: {
                            buttons: [{
                                extend: 'print',
                                text: '🖨️ Imprimer',
                                title: 'LISTE des communes',
                                className: 'btn-imprimer-custom',
                                messageTop: '',
                                exportOptions: {
                                    columns: [0, 1, 2, 3], // Colonnes à exporter
                                    modifier: {
                                        page: 'all'
                                    }
                                }
                            }]
                        }
                    },
                    columnDefs: [{
                        targets: [4], // Actions
                        orderable: false,
                        searchable: false,
                    }],
                    ajax: {
                        url: 'get-communes.php',
                        type: 'POST',
                        data: function(d) {
                            d.customDateDebut = $('#customDateDebut').val();
                            d.customDateFin = $('#customDateFin').val();
                        },
                        dataSrc: function(json) {
                            $('#totalDataReturn').text(json.totalDataReturn || '0');
                            return json.data;
                        },
                        error: function(xhr, error, thrown) {
                            console.error('Erreur DataTables:', error);
                        }
                    },
                    language: {
                        sProcessing: "Traitement en cours...",
                        sLengthMenu: "Afficher _MENU_ entrées",
                        sZeroRecords: "Aucun résultat trouvé",
                        sInfo: "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
                        sInfoEmpty: "Affichage de 0 à 0 sur 0 entrées",
                        sInfoFiltered: "(filtré de _MAX_ entrées au total)",
                        sSearch: "Rechercher:",
                        oPaginate: {
                            sFirst: "Premier",
                            sPrevious: "Précédent",
                            sNext: "Suivant",
                            sLast: "Dernier"
                        },
                        oAria: {
                            sSortAscending: ": Activer pour trier la colonne par ordre croissant",
                            sSortDescending: ": Activer pour trier la colonne par ordre décroissant"
                        }
                    },
                    columns: [{
                            data: 'numero',
                            className: 'text-center',
                            title: 'N°'
                        },
                        {
                            data: 'nom_commune',
                            title: 'Commune'
                        },
                        {
                            data: 'dateinsertion_commune',
                            className: 'text-center',
                            title: 'Date'
                        },
                        {
                            data: 'heureeinsertion_commune',
                            className: 'text-center',
                            title: 'Heure'
                        },
                        {
                            data: 'actions',
                            className: 'text-center d-print-none',
                            title: 'Actions'
                        }
                    ]
                });

            }

            $('#customDateDebut, #customDateFin').on('change', function() {
                $('#product-table').DataTable().ajax.reload();
            });
            //
            // Modifier un pays
            $(document).on('click', '.editBtn', function() {
                const id_commune = $(this).data('id');
                const nom_commune = $(this).data('libelle');
                const id_ville = $(this).data('ville');

                // ⚠️ villeOptions doit être une chaîne HTML contenant des <option>
                Swal.fire({
                    title: 'Modifier la commune',
                    html: `
            <input type="text" id="swal-nom" class="swal2-input" placeholder="Nom de la commune" value="${nom_commune}">
            <select class="swal2-input" id="swal-ville" required>
                <option value="">-- Sélectionnez une ville --</option>
                ${villeOptions}
            </select>
        `,
                    confirmButtonText: 'Mettre à jour',
                    showCancelButton: true,
                    cancelButtonText: 'Annuler',
                    focusConfirm: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        $('#swal-ville').val(id_ville); // pré-sélection de la ville
                    },
                    preConfirm: () => {
                        const nom = $('#swal-nom').val().trim();
                        const ville = $('#swal-ville').val();

                        if (!nom || !ville) {
                            Swal.showValidationMessage('Tous les champs sont requis.');
                            return false;
                        }

                        return {
                            id_commune: id_commune,
                            nom_commune: nom,
                            id_ville: ville,
                            action: 'update_commune'
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'update-commune.php',
                            method: 'POST',
                            data: result.value,
                            dataType: 'json',
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire('Succès', response.message, 'success');
                                    $('#product-table').DataTable().ajax.reload(null, false);
                                } else {
                                    Swal.fire('Erreur', response.message, 'error');
                                }
                            },
                            error: function() {
                                Swal.fire('Erreur', 'Impossible de mettre à jour la commune.', 'error');
                            }
                        });
                    }
                });
            });


            $(document).on('click', '.deleteBtn', function() {
                const id_commune = $(this).data('id');

                Swal.fire({
                    title: "AVERTISSEMENT",
                    text: "Voulez-vous supprimer cette commune ? Cette action est irréversible !",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Oui",
                    cancelButtonText: "Non",
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "delete-commune.php",
                            method: "POST",
                            dataType: "json",
                            data: {
                                id_commune: id_commune,
                                action: 'delete_commune'
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire('Supprimé !', response.message, 'success').then(() => {
                                        $('#product-table').DataTable().ajax.reload(null, false);
                                    });
                                } else {
                                    Swal.fire('Erreur !', response.message, 'error');
                                }
                            },
                            error: function() {
                                Swal.fire('Erreur !', "Une erreur est survenue lors de la suppression.", 'error');
                            }
                        });
                    }
                });
            });


        });
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