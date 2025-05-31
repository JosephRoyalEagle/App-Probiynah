<?php
$current = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <img src="assets/img/LOGOPB.png" class="sidebar-logo" alt="Logo Probiynah">
    </div>
    <ul class="sidebar-menu">
        <li class="<?php echo ($current == 'index.php') ? 'active' : ''; ?>">
            <a href="index.php"><i class="fas fa-tachometer-alt"></i> Tableau de bord</a>
        </li>
        <li class="<?php echo ($current == 'manage-users.php') ? 'active' : ''; ?>">
            <a href="manage-users.php"><i class="fas fa-fw fa-users"></i><span>Utilisateurs</span></a>
        </li>
        <li class="<?php echo ($current == 'manage-countries.php') ? 'active' : ''; ?>">
            <a href="manage-countries.php"><i class="fas fa-fw fa-globe"></i><span>Pays</span></a>
        </li>
        <li class="<?php echo ($current == 'manage-city.php') ? 'active' : ''; ?>">
            <a href="manage-city.php"><i class="fas fa-fw fa-city"></i><span>Villes</span></a>
        </li>
        <li class="<?php echo ($current == 'manage-comune.php') ? 'active' : ''; ?>">
            <a href="manage-comune.php"><i class="fas fa-fw fa-street-view"></i><span>Communes</span></a>
        </li>
        <li class="<?php echo ($current == 'manage-resto.php') ? 'active' : ''; ?>">
            <a href="manage-resto.php"><i class="fas fa-fw fa-utensils"></i><span>Restaurants</span></a>
        </li>
        <li class="<?php echo ($current == 'manage-hotels.php') ? 'active' : ''; ?>">
            <a href="manage-hotels.php"><i class="fas fa-fw fa-hotel"></i><span>Hotels</span></a>
        </li>
        <li class="<?php echo ($current == 'manage-product.php') ? 'active' : ''; ?>">
            <a href="manage-product.php"><i class="fas fa-fw fa-boxes"></i><span>Produits</span></a>
        </li>
        <li class="<?php echo ($current == 'manage-product-category.php') ? 'active' : ''; ?>">
            <a href="manage-product-category.php"><i class="fas fa-fw fa-tags"></i><span>Catégories produits</span></a>
        </li>
        <li class="<?php echo ($current == 'manage-devis.php') ? 'active' : ''; ?>">
            <a href="manage-devis.php"><i class="fas fa-fw fa-file-invoice"></i><span>Devis</span></a>
        </li>
        <li class="<?php echo ($current == 'logout.php') ? 'active' : ''; ?>">
            <a href="logout.php"><i class="fas fa-fw fa-sign-out-alt"></i><span>Se déconnecter</span></a>
        </li>
    </ul>
</div>
