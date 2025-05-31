<?php
require 'session-control.php';
// Récupérer la liste des pays
$sql = "SELECT id_pays, libelle_pays FROM pays ORDER BY libelle_pays ASC";
$result = $db_host->prepare($sql);
$result->execute();
$pays = $result->fetchAll(PDO::FETCH_ASSOC);

// Créer une chaîne HTML pour les options
$options = "";
foreach ($pays as $row) {
    $options .= '<option value="' . htmlspecialchars($row["id_pays"]) . '">' . htmlspecialchars($row["libelle_pays"]) . '</option>';
}

// Si aucun pays n'est trouvé, on affiche un message d'erreur
if (empty($options)) {
    $options = '<option value="">Aucun pays trouvé</option>';
}

// Passer cette chaîne à JavaScript via un objet JSON ou une variable JavaScript
echo "<script>var paysOptions = '$options';</script>";

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
                        <h2 class="section-title m-0"><i class="fas fa-building"></i> Gestion des villes</h2>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addpaysModal">
                            <i class="fas fa-plus-circle"></i> Ajouter
                        </button>
                    </div>

                    <!-- Modal Fullscreen -->
                    <div class="modal fade" id="addpaysModal" tabindex="-1" aria-labelledby="addpaysModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-fullscreen">
                            <div class="modal-content">
                                <div class="modal-header text-white" style="background-color: var(--primary);">
                                    <h5 class="modal-title" id="addpaysModalLabel"><i class="fas fa-plus-circle"></i> Enregistrement d'un nouvelle ville</h5>
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
                                                                                <label for="nom_pays">Nom du pays</label>
                                                                                <?php
                                                                                // Récupérer la liste des pays
                                                                                $sql = "SELECT id_pays, libelle_pays FROM pays ORDER BY libelle_pays ASC";
                                                                                $result = $db_host->prepare($sql);
                                                                                $result->execute();
                                                                                $pays = $result->fetchAll(PDO::FETCH_ASSOC); // Utilise fetchAll pour récupérer tous les résultats

                                                                                if (count($pays) > 0) {
                                                                                    echo '<select class="form-control" id="nom_pays" name="nom_pays" required>';
                                                                                    echo '<option value="">-- Sélectionnez un pays --</option>';
                                                                                    foreach ($pays as $row) {
                                                                                        echo '<option value="' . htmlspecialchars($row["id_pays"]) . '">' . ucwords(htmlspecialchars($row["libelle_pays"])) . '</option>';
                                                                                    }
                                                                                    echo '</select>';
                                                                                } else {

                                                                                    echo '<select class="form-control" id="nom_pays" name="nom_pays" required>';
                                                                                    echo '<option value="">-- Aucun pays trouvé --</option>';
                                                                                }
                                                                                ?>

                                                                            </div>

                                                                            <div class="form-group col-md-6">
                                                                                <label for="nom_ville">Nom de la ville</label>
                                                                                <input type="text" id="nom_ville" name="nom_ville" class="form-control" palceholder="Dimbokro" required>
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
                        <h2>Liste des villes (<span id="totalDataReturn" class="text-danger"></span>) </h2>
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
                                            <th class="text-center">Ville</th>
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
                formData.append('action', 'add_pays');
                //console.log(formData.getAll('nom_pays'));
                $.ajax({
                    url: 'add-villes.php',
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
                                title: "Success",
                                text: response.message
                            }).then(() => {
                                // Recharger le DataTable après la fermeture du Toast
                                $('#product-table').DataTable().ajax.reload(null, false); // false pour garder la pagination actuelle
                            });
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: response.message
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
                            title: 'Erreur',
                            text: errorMsg
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
                        $('#product-table').DataTable().ajax.reload(); // Rechargement plus propre
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
                                title: 'LISTE des villes',
                                className: 'btn-imprimer-custom',
                                messageTop: '',
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4], // Colonnes à exporter (0-indexed)
                                    modifier: {
                                        page: 'all'
                                    }
                                }
                            }]
                        }
                    },
                    columnDefs: [{
                        targets: [4], // Dernière colonne (actions)
                        orderable: false,
                        searchable: false,
                    }],
                    ajax: {
                        url: 'get-villes.php',
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
                            data: 'nom_ville',
                            className: 'text-center',
                            title: 'Ville'
                        },
                        {
                            data: 'dateinsertion_ville',
                            className: 'text-center',
                            title: 'Date'
                        },
                        {
                            data: 'heureinsertion_ville',
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


            //
            // Modifier un pays
            $(document).on('click', '.editBtn', function() {
                // 🔄 Récupération des données depuis les attributs data-*
                const id_ville = $(this).data('id');
                const libelle_ville = $(this).data('libelle');

                // 🧾 Affichage d’un formulaire dans une popup
                Swal.fire({
                    title: 'Modifier la ville',
                    html: `
            <input type="text" id="swal-libelle" class="swal2-input" placeholder="Nom du pays" value="${libelle_ville}">
            <select class="swal2-input" id="swal-pays" required>
                <option value="">-- Sélectionnez un pays --</option>
                ${paysOptions} <!-- Ici, tu injectes dynamiquement les pays depuis PHP -->
            </select>
        `,
                    confirmButtonText: 'Appliquer',
                    showCancelButton: true,
                    cancelButtonText: 'Annuler',
                    focusConfirm: false,
                    allowOutsideClick: false,
                    preConfirm: () => {
                        const libelle = $('#swal-libelle').val().trim();
                        const pays = $('#swal-pays').val(); // Récupérer l'ID du pays sélectionné

                        // Validation des champs
                        if (!libelle || !pays) {
                            Swal.showValidationMessage('Tous les champs sont obligatoires.');
                            return false;
                        }

                        return {
                            id_ville: id_ville,
                            libelle_ville: libelle,
                            pays: pays,
                            action: 'update_villes'
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // 📤 Envoi AJAX pour la mise à jour
                        $.ajax({
                            url: 'update-villes.php',
                            type: 'POST',
                            data: result.value,
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire('Succès', response.message, 'success');
                                    $('#product-table').DataTable().ajax.reload(null, false); // 🔄 Rafraîchir la table sans changer de page
                                } else {
                                    Swal.fire('Erreur', response.message, 'error');
                                }
                            },
                            error: function() {
                                Swal.fire('Erreur', 'Erreur lors de la mise à jour.', 'error');
                            }
                        });
                    }
                });
            });


            //Supprimer adhérent
            $(document).on('click', '.deleteBtn', function() {
                let id_pays = $(this).data('id');
                Swal.fire({
                    title: "AVERTISSEMENT",
                    text: "Voulez-vous supprimer cette ville? Cette action est irréversible !",
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
                            url: "delete-ville.php",
                            type: "POST",
                            dataType: "json",
                            data: {
                                id_pays: id_pays,
                                action: 'delete_pays'
                            },
                            success: function(adherentDeleteResponse) {
                                console.log(adherentDeleteResponse.success);

                                if (adherentDeleteResponse.success) {
                                    Swal.fire({
                                        title: 'Supprimé !',
                                        text: adherentDeleteResponse.message,
                                        icon: 'success',
                                        confirmButtonColor: '#3085d6',
                                        allowOutsideClick: false
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Erreur !',
                                        text: adherentDeleteResponse.message,
                                        icon: 'error',
                                        confirmButtonColor: '#3085d6',
                                        allowOutsideClick: false
                                    });
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    title: 'Erreur !',
                                    text: "Une erreur est survenue lors de la suppression.",
                                    icon: 'error',
                                    confirmButtonColor: '#3085d6',
                                    allowOutsideClick: false
                                });
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