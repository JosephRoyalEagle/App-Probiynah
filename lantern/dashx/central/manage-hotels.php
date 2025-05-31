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
                        <h2 class="section-title m-0"><i class="fas fa-hotel"></i> Gestion des hotels</h2>
                        <button type="button" class="btn btn-primary">
                            <i class="fas fa-plus-circle"></i> Ajouter
                        </button>
                    </div>
                </section>

                <section class="service-unavailable-section">
                    <div class="service-unavailable-container">
                        <div class="service-unavailable-icon">
                        <i class="fas fa-tools"></i>
                        </div>
                        <h2>Service Indisponible</h2>
                        <p>Cette section du site n'est pas disponible pour le moment.<br>
                        Merci de revenir plus tard ou de contacter le support pour plus d'informations.</p>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <?php
        require "script.php";
    ?>
</body>

</html>