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
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="section-title m-0"><i class="fas fa-boxes"></i> Gestion des produits</h2>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAccountModal">
                            <i class="fas fa-plus-circle"></i> Ajouter
                        </button>
                    </div>
                    <div class="modal fade" id="addAccountModal" tabindex="-1" aria-labelledby="addAccountModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-fullscreen">
                            <div class="modal-content">
                                <div class="modal-header text-white" style="background-color: var(--primary);">
                                    <h5 class="modal-title" id="addAccountModalLabel"><i class="fas fa-plus-circle"></i> Enregistrement d'un nouveau produit</h5>
                                    <button type="button" class="btn-close btn-close-white btn-close-modal-reloaded" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <div class="row justify-content-center">
                                            <div class="col-lg-10">
                                                <div class="card shadow">
                                                    <div class="card-body p-4">
                                                        <form id="product-form" class="product-form" enctype="multipart/form-data">
                                                            <div class="form-row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group mb-3">
                                                                        <label for="designationProd">Désignation</label>
                                                                        <input type="text" id="designationProd" name="designationProd" placeholder="Dopel Energy" class="form-control" minlength="2" maxlength="50" required>
                                                                    </div>

                                                                    <div class="form-group mb-3">
                                                                        <label for="descriptionProd">Description</label>
                                                                        <input type="text" id="descriptionProd" name="descriptionProd" placeholder="Boisson non alcolisée et très riche en vitamines Z et C" class="form-control" minlength="2" maxlength="100" required>
                                                                    </div>

                                                                    <div class="form-group mb-3">
                                                                        <label for="categorieProd">Catégorie</label>
                                                                        <select id="categorieProd" name="categorieProd" class="form-control" required>
                                                                            <option value="">Sélectionnez</option>
                                                                            <?php
                                                                                $reqCatProduct = $db_host->prepare('
                                                                                    SELECT * 
                                                                                    FROM categorie_produits 
                                                                                    ORDER BY designation_cateprod ASC
                                                                                ');
                                                                                $reqCatProduct->execute();
                                                                                while ($resCatProduct = $reqCatProduct->fetch(PDO::FETCH_ASSOC)) {
                                                                                    echo '<option value="' . $resCatProduct['id_cateprod'] . '">' . $resCatProduct['designation_cateprod'] . '</option>';
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group mb-3">
                                                                        <label for="imageProd">Image (*.png, *.jpg, *.jpeg)</label>
                                                                        <input type="file" id="imageProd" name="imageProd" class="form-control" required accept=".png, .jpg, .jpeg, image/png, image/jpeg">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-actions justify-content-center mt-4">
                                                                <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">
                                                                    <i class="fas fa-times"></i> Annuler
                                                                </button>
                                                                <button type="button" id="btn-sub-product" class="submit-btn">
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
                        <h2>Liste des produits (<span id="totalDataReturn" class="text-danger"></span>)</h2>
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
                        <table class="product-table" id="product-table">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Produit</th>
                                    <th>Description</th>
                                    <th>Categorie</th>
                                    <th>Image</th>
                                    <th>Date</th>
                                    <th>Heure</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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
            $(document).ready(function () {
                //Gestion de l'ajout
                $('#btn-sub-product').on('click', function() {
                    // Récupérer les données du formulaire                
                    const allFormData = $('#product-form')[0];
                    const formDataSubmit = new FormData(allFormData);
                    
                    // Appel Ajax pour envoyer les données
                    $.ajax({
                        url: 'manage-product-dv.php',
                        type: 'POST',
                        data: formDataSubmit,
                        processData: false,
                        contentType: false,
                        success: function (ajaxResponseJson) {
                            if (ajaxResponseJson.success) {
                                Swal.fire({
                                    title: 'Enregistré !',
                                    text: "Le produit a bien été ajouté avec succes.",
                                    icon: 'success',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok',
                                    allowOutsideClick: false
                                }).then(() => {
                                    $('#product-form')[0].reset();
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

                // Obtenir la largeur de l'ecran
                const isMobile = window.innerWidth <= 600;

                // Initialisation de DataTables
                new DataTable('#product-table', {
                    processing: true,
                    serverSide: true,
                    scrollCollapse: true,
                    scroller: !isMobile,
                    scrollY: isMobile ? null : 800,
                    deferRender: true,
                    layout: {
                        topStart: {
                            buttons: [
                                {
                                    extend: 'print',
                                    text: '🖨️ Imprimer',
                                    title: 'LISTE DES PRODUITS',
                                    className: 'btn-imprimer-custom',
                                    messageTop: '',
                                    exportOptions: {
                                        columns: [0, 1, 3, 5, 6],
                                        modifier: {
                                            page: 'all'
                                        }
                                    }
                                }
                            ]
                        }
                    },
                    columnDefs: [
                        {
                            targets: [-1, 2, 4],
                            orderable: false,
                            searchable: false,
                        }
                    ],
                    ajax: {
                        url: 'manage-product-getter.php',
                        type: 'POST',
                        data: function(d) {
                            d.customDateDebut = $('#customDateDebut').val();
                            d.customDateFin = $('#customDateFin').val();
                        },
                        dataSrc: function(json) {
                            $('#totalDataReturn').text(json.totalDataReturn || '0');
                            return json.data;
                        },
                        error: function(xhr, error, thrown) {}
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
                    columns: [
                        { data: 'numero_product', className: 'text-center' },
                        { data: 'designation_product', className: 'text-center'},
                        { data: 'description_product', className: 'text-center'},
                        { data: 'categorie_product', className: 'text-center' },
                        { data: 'image_product', className: 'text-center' },
                        { data: 'date_product', className: 'text-center' },
                        { data: 'heure_product', className: 'text-center' },
                        { data: 'actions_product', className: 'text-center d-print-none' }
                    ]
                });

                $('#customDateDebut, #customDateFin').on('change', function() {
                    $('#product-table').DataTable().ajax.reload();
                });

                //Supprimer
                $(document).on('click', '.deleteBtn', function() {
                    let dataPostContent = $(this).data('id');
                    Swal.fire({
                        title: "AVERTISSEMENT",
                        text: "Voulez-vous supprimer ce produit? Cette action est irréversible !",
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
                                url: "manage-product-delete.php",
                                type: "POST",
                                data: { dataPostContent: dataPostContent },
                                success: function (deleteResponse) {
                                    if (deleteResponse.success) {
                                        Swal.fire({
                                            title: 'Supprimé !',
                                            text: "Le produit a bien été supprimé.",
                                            icon: 'success',
                                            showConfirmButton: true,
                                            confirmButtonText: 'Ok',
                                            allowOutsideClick: false
                                        }).then(() => {
                                            window.location.reload();
                                        });
                                    } else {
                                        Swal.fire({
                                            title: 'Erreur !',
                                            text: deleteResponse.msg,
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
                                        text: "Une erreur est survenue lors de la suppression.",
                                        icon: 'error',
                                        showConfirmButton: true,
                                        confirmButtonText: 'Ok',
                                        allowOutsideClick: false
                                    });
                                }
                            });
                        }
                    });
                });

                // Modifier
                $(document).on("click", "#btn-sub-updateprod", function() {
                    // Récupérer les données du formulaire 
                    let serverTrustDataId = $(this).data("id");
                    let modalCible = $("#modalUpdateNewData" + serverTrustDataId);
                                   
                    const allFormData = modalCible.find("#product-form")[0];
                    const formDataSubmit = new FormData(allFormData);

                    // Appel Ajax pour envoyer les données
                    $.ajax({
                        url: 'manage-product-update-dv.php',
                        type: 'POST',
                        data: formDataSubmit,
                        processData: false,
                        contentType: false,
                        success: function (updateFormSubmitResponse) {
                            if (updateFormSubmitResponse.success) {
                                Swal.fire({
                                    title: 'Enregistré !',
                                    text: "La mise à jour a bien été effectuée avec succès.",
                                    icon: 'success',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok',
                                    allowOutsideClick: false
                                }).then(() => {
                                    modalCible.find(".product-form")[0].reset();
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Erreur !',
                                    text: updateFormSubmitResponse.msg,
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

                // Actualiser la page d'enregistrement
                $(document).on('click', '.btn-close-modal-reloaded', function () {
                    window.location.reload();
                });
            });
        })(jQuery);
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
        $('#product-table').on('draw.dt', function () {
            applyDataLabelsAfterDT();

            // Remet les modals dans le body (ton code existant)
            $('.modal').each(function () {
                if (!$(this).parent().is('body')) {
                    $(this).appendTo('body');
                }
            });
        });
    </script>
</body>

</html>