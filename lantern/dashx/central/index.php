<?php
require 'session-control.php';
// Nombre total d'utilisateurs
$stmt = $db_host->prepare("SELECT COUNT(*) FROM utilisateurs");
$stmt->execute();
$totalUtilisateurs = $stmt->fetchColumn();

// Nombre d'utilisateurs de type "gestionnaire"
$stmt = $db_host->prepare("SELECT COUNT(*) FROM utilisateurs WHERE role_utilis = :type");
$stmt->execute(['type' => 'gestionnaire']);
$totalGestionnaires = $stmt->fetchColumn();

// Nombre de restaurants (business)
$stmt = $db_host->prepare("SELECT COUNT(*) FROM business");
$stmt->execute();
$totalRestaurants = $stmt->fetchColumn();

// Nombre de produits
$stmt = $db_host->prepare("SELECT COUNT(*) FROM produits");
$stmt->execute();
$totalProduits = $stmt->fetchColumn();

// Nombre de pays
$stmt = $db_host->prepare("SELECT COUNT(*) FROM pays");
$stmt->execute();
$totalPays = $stmt->fetchColumn();

// Nombre de villes
$stmt = $db_host->prepare("SELECT COUNT(*) FROM ville");
$stmt->execute();
$totalVilles = $stmt->fetchColumn();

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
                <div class="card-container">
                    <div class="">
                        <div class="card card-primary">
                            <div class="card-title">Utilisateurs</div>
                            <div class="card-value"><?= $totalUtilisateurs ?></div>
                            <div class="card-progress"><span class="text-muted">Tous types confondus</span></div>
                        </div>
                    </div>

                    <div class="">
                        <div class="card card-success">
                            <div class="card-title">Gestionnaires</div>
                            <div class="card-value"><?= $totalGestionnaires ?></div>
                            <div class="card-progress"><span class="text-muted">Utilisateurs de type "gestionnaire"</span></div>
                        </div>
                    </div>

                    <div class="">
                        <div class="card card-warning">
                            <div class="card-title">Restaurants</div>
                            <div class="card-value"><?= $totalRestaurants ?></div>
                            <div class="card-progress"><span class="text-muted">Restaurants enregistrés</span></div>
                        </div>
                    </div>

                    <div class="">
                        <div class="card card-danger">
                            <div class="card-title">Produits</div>
                            <div class="card-value"><?= $totalProduits ?></div>
                            <div class="card-progress"><span class="text-muted">Produits gérés</span></div>
                        </div>
                    </div>

                    <div class="">
                        <div class="card card-info">
                            <div class="card-title">Pays</div>
                            <div class="card-value"><?= $totalPays ?></div>
                            <div class="card-progress"><span class="text-muted">Pays couverts</span></div>
                        </div>
                    </div>

                    <div class="">
                        <div class="card card-secondary">
                            <div class="card-title">Villes</div>
                            <div class="card-value"><?= $totalVilles ?></div>
                            <div class="card-progress"><span class="text-muted">Villes enregistrées</span></div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <?php
    require "script.php";
    ?>
</body>

</html>