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
                <div class="card-container">
                    <div class="card card-primary">
                        <div class="card-title">Clients</div>
                        <div class="card-value">2,390</div>
                        <div class="card-progress">
                            <span class="text-success">12%</span> vs mois dernier
                        </div>
                    </div>
                    <div class="card card-success">
                        <div class="card-title">Revenus</div>
                        <div class="card-value">€45,678</div>
                        <div class="card-progress">
                            <span class="text-success">8%</span> vs mois dernier
                        </div>
                    </div>
                    <div class="card card-warning">
                        <div class="card-title">Commandes</div>
                        <div class="card-value">1,245</div>
                        <div class="card-progress">
                            <span class="text-danger">-3%</span> vs mois dernier
                        </div>
                    </div>
                    <div class="card card-danger">
                        <div class="card-title">En attente</div>
                        <div class="card-value">42</div>
                        <div class="card-progress">
                            <span class="text-success">24%</span> vs mois dernier
                        </div>
                    </div>
                </div>

                <div class="divider"></div>

                <section class="dashboard-section">
                    <h2 class="section-title"><i class="fas fa-boxes"></i> Nos Produits</h2>
                    <div class="card-container">
                        <!-- Product Card 1 -->
                        <div class="card product-card">
                            <div class="product-image">
                                <img src="assets/img/1.jpg" alt="Produit 1">
                            </div>
                            <div class="product-details">
                                <h3 class="product-name">Smartphone Premium</h3>
                                <p class="product-description">Smartphone haut de gamme avec écran AMOLED 6.5"</p>
                                <div class="product-price">€799.99</div>

                                <!-- Quantity Selector -->
                                <div class="quantity-selector">
                                    <button class="qty-btn" onclick="decreaseQty()">−</button>
                                    <input type="number" id="quantity" value="1" min="1" readonly>
                                    <button class="qty-btn" onclick="increaseQty()">+</button>
                                </div>

                                <button class="add-to-cart-btn">
                                    <i class="fas fa-cart-plus"></i> Ajouter
                                </button>
                            </div>
                        </div>


                        <!-- Product Card 2 -->
                        <div class="card product-card">
                            <div class="product-image">
                                <img src="assets/img/1.jpg" alt="Produit 1">
                            </div>
                            <div class="product-details">
                                <h3 class="product-name">Smartphone Premium</h3>
                                <p class="product-description">Smartphone haut de gamme avec écran AMOLED 6.5"</p>
                                <div class="product-price">€799.99</div>

                                <!-- Quantity Selector -->
                                <div class="quantity-selector">
                                    <button class="qty-btn" onclick="decreaseQty()">−</button>
                                    <input type="number" id="quantity" value="1" min="1" readonly>
                                    <button class="qty-btn" onclick="increaseQty()">+</button>
                                </div>

                                <button class="add-to-cart-btn">
                                    <i class="fas fa-cart-plus"></i> Ajouter
                                </button>
                            </div>
                        </div>

                        <!-- Product Card 3 -->
                        <div class="card product-card">
                            <div class="product-image">
                                <img src="assets/img/1.jpg" alt="Produit 1">
                            </div>
                            <div class="product-details">
                                <h3 class="product-name">Smartphone Premium</h3>
                                <p class="product-description">Smartphone haut de gamme avec écran AMOLED 6.5"</p>
                                <div class="product-price">€799.99</div>

                                <!-- Quantity Selector -->
                                <div class="quantity-selector">
                                    <button class="qty-btn" onclick="decreaseQty()">−</button>
                                    <input type="number" id="quantity" value="1" min="1" readonly>
                                    <button class="qty-btn" onclick="increaseQty()">+</button>
                                </div>

                                <button class="add-to-cart-btn">
                                    <i class="fas fa-cart-plus"></i> Ajouter
                                </button>
                            </div>
                        </div>

                    </div>
                </section>

                <!-- Divider -->
                <div class="divider"></div>

                <section class="product-table-section">
                    <div class="container">
                        <h2>Nos Produits</h2>
                        <table class="product-table">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Description</th>
                                    <th>Categorie</th>
                                    <th>Prix</th>
                                    <th>Prime</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Produit A</td>
                                    <td>Lorem ipsum dolor sit amet</td>
                                    <td>25&nbsp;€</td>
                                    <td>25&nbsp;€</td>
                                    <td>25&nbsp;€</td>
                                    <td>
                                        <button class="btn btn-primary"><i class="fas fa-edit"></i></i></button>&nbsp;&nbsp;
                                        <button class="btn btn-danger"><i class="fas fa-trash"></i></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Produit B</td>
                                    <td>Consectetur adipiscing elit</td>
                                    <td>25&nbsp;€</td>
                                    <td>25&nbsp;€</td>
                                    <td>25&nbsp;€</td>
                                    <td>
                                        <button class="btn btn-primary"><i class="fas fa-edit"></i></i></button>&nbsp;&nbsp;
                                        <button class="btn btn-danger"><i class="fas fa-trash"></i></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Produit C</td>
                                    <td>Sed do eiusmod tempor</td>
                                    <td>25&nbsp;€</td>
                                    <td>25&nbsp;€</td>
                                    <td>25&nbsp;€</td>
                                    <td>
                                        <button class="btn btn-primary"><i class="fas fa-edit"></i></i></button>&nbsp;&nbsp;
                                        <button class="btn btn-danger"><i class="fas fa-trash"></i></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <div class="divider"></div>

                <section class="dashboard-section">
                    <h2 class="section-title"><i class="fas fa-plus-circle"></i> Enregistrer un nouveau produit</h2>
                    <div class="card">
                        <form id="product-form" class="product-form">
                            <div class="form-grid">
                                <!-- Colonne de gauche -->
                                <div class="form-column">
                                    <div class="form-group">
                                        <label for="product-name">Nom du produit</label>
                                        <input type="text" id="product-name" name="product-name" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="product-price">Prix (€)</label>
                                        <input type="number" id="product-price" name="product-price" step="0.01" min="0"
                                            required>
                                    </div>

                                    <div class="form-group">
                                        <label for="product-category">Catégorie</label>
                                        <select id="product-category" name="product-category" required>
                                            <option value="">Sélectionnez une catégorie</option>
                                            <option value="electronique">Électronique</option>
                                            <option value="habillement">Habillement</option>
                                            <option value="alimentation">Alimentation</option>
                                            <option value="maison">Maison</option>
                                            <option value="autre">Autre</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Colonne de droite -->
                                <div class="form-column">
                                    <div class="form-group">
                                        <label for="product-description">Description</label>
                                        <textarea id="product-description" name="product-description" rows="4"
                                            required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="product-image">Image du produit</label>
                                        <div class="image-upload">
                                            <input type="file" id="product-image" name="product-image" accept="image/*">
                                            <label for="product-image" class="upload-btn">
                                                <i class="fas fa-cloud-upload-alt"></i> Choisir une image
                                            </label>
                                            <span class="file-name">Aucun fichier sélectionné</span>
                                        </div>
                                        <div class="image-preview" id="image-preview"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions justify-content-center">
                                <button type="submit" class="submit-btn">
                                    <i class="fas fa-save"></i> Enregistrer
                                </button>
                            </div>
                        </form>
                    </div>
                </section>

                <div class="divider"></div>

                <div class="animated-buttons-container">
                    <h2>Accès Rapide</h2>
                    <div class="button-grid">
                        <button class="animated-border-button">
                            <i class="fas fa-utensils"></i>
                            <span>Restaurant</span>
                        </button>
                        <button class="animated-border-button">
                            <i class="fas fa-hotel"></i>
                            <span>Hotel</span>
                        </button>
                    </div>
                </div>

                <div class="divider"></div>

                <section class="dashboard-section">
                    <h2 class="section-title"><i class="fas fa-user-circle"></i> Mon Profil</h2>
                    <div class="card-container">
                        <div class="card">
                            <div class="profile-header">
                                <div class="profile-avatar">
                                    <i id="profile-picture" class="fas fa-user-circle"></i>
                                </div>
                                <div class="profile-info">
                                    <h3>Client</h3>
                                </div>
                            </div>

                            <div class="profile-details">
                                <ul class="info-list">
                                    <li>
                                        <strong><i class="fas fa-user"></i> Nom & prénoms:</strong>
                                        <span>Kouassi Jean Pierre</span>
                                    </li>
                                    <li>
                                        <strong><i class="fas fa-phone"></i> Téléphone:</strong>
                                        <span>0748820709</span>
                                    </li>
                                    <li>
                                        <strong><i class="fas fa-map-marker-alt"></i> Adresse:</strong>
                                        <span>Cocody angré, cité des arts</span>
                                    </li>
                                    <li>
                                        <strong><i class="fas fa-calendar-check"></i> Inscrit(e) depuis:</strong>
                                        <span>15/06/2023</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="card">
                            <h3 class="card-title"><i class="fas fa-edit"></i> Modifier le profil</h3>
                            <form class="profile-form">
                                <div class="form-group mb-3">
                                    <label for="lastname">Nom</label>
                                    <input type="text" id="lastname" placeholder="Kouassi">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="firstname">Prénoms</label>
                                    <input type="text" id="firstname" placeholder="Jean Pierre">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="phone">Téléphone</label>
                                    <input type="tel" id="phone" placeholder="0748820304">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="address">Adresse</label>
                                    <textarea id="address" rows="2" placeholder="Cocody angré, cité des arts"></textarea>
                                </div>

                                <div class="form-actions justify-content-center">
                                    <button type="submit" class="save-btn btn-primary">
                                        <i class="fas fa-save"></i> Enregistrer
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>

                <div class="divider"></div>

                <!-- SECTION PANIER -->
                <section class="cart-section">
                    <div class="container">
                        <div class="monpannier_title">
                            <h2>Mon Panier</h2>
                        </div>

                        <div class="cart-table-wrapper">
                            <table class="cart-table">
                                <thead>
                                    <tr>
                                        <th>Produit</th>
                                        <th>Prix Unitaire</th>
                                        <th>Quantité</th>
                                        <th>Sous-total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Produit A</td>
                                        <td>25&nbsp;€</td>
                                        <td class="cart-qty-cell">
                                            <button class="cart-qty-btn" onclick="updateCartQty(0, -1)">−</button>
                                            <input type="number" class="cart-qty-input" value="2" min="1" readonly>
                                            <button class="cart-qty-btn" onclick="updateCartQty(0, 1)">+</button>
                                        </td>
                                        <td class="cart-row-subtotal">50&nbsp;€</td>
                                    </tr>
                                    <tr>
                                        <td>Produit B</td>
                                        <td>50&nbsp;€</td>
                                        <td class="cart-qty-cell">
                                            <button class="cart-qty-btn" onclick="updateCartQty(1, -1)">−</button>
                                            <input type="number" class="cart-qty-input" value="1" min="1" readonly>
                                            <button class="cart-qty-btn" onclick="updateCartQty(1, 1)">+</button>
                                        </td>
                                        <td class="cart-row-subtotal">50&nbsp;€</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" style="text-align:right;font-weight:600;">Sous-total :</td>
                                        <td id="cart-subtotal">100&nbsp;€</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="text-align:right;font-weight:600;">Total TTC (20%) :</td>
                                        <td id="cart-totaltc">120&nbsp;€</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <button class="cart-order-btn">
                            <i class="fas fa-shopping-cart"></i> Commander</button>
                    </div>
                </section>

                <div class="divider"></div>

                <!-- SECTION CARTE ADRESSE -->
                <section class="address-card-section">
                    <div class="container">
                        <h2>Carte adresse</h2>
                        <form class="address-card-form" id="addressCardForm" autocomplete="off">
                            <div class="acf-row">
                                <div class="acf-group">
                                    <label for="acf-city">Ville</label>
                                    <select id="acf-city" name="city" required>
                                        <option value="">Sélectionnez la ville</option>
                                        <option value="Paris">Paris</option>
                                        <option value="Lyon">Lyon</option>
                                        <option value="Marseille">Marseille</option>
                                    </select>
                                </div>
                                <div class="acf-group">
                                    <label for="acf-commune">Commune</label>
                                    <select id="acf-commune" name="commune" required>
                                        <option value="">Sélectionnez la commune</option>
                                        <option value="Centre">Centre</option>
                                        <option value="Nord">Nord</option>
                                        <option value="Sud">Sud</option>
                                    </select>
                                </div>
                            </div>

                            <div class="acf-row">
                                <div class="acf-group" style="flex: 1 1 100%;">
                                    <label for="acf-service-type">Type de service</label>
                                    <select id="acf-service-type" name="serviceType" required>
                                        <option value="">Sélectionnez...</option>
                                        <option value="hotel">Réservation hôtel</option>
                                        <option value="restaurant">Restaurant (nourriture, boisson)</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Bloc Résa Hôtel -->
                            <div id="acf-hotel-fields" style="display:none;">
                                <div class="acf-row">
                                    <div class="acf-group">
                                        <label for="acf-adult">Nombre d'adulte</label>
                                        <input type="number" id="acf-adult" min="1" max="10" value="1" required>
                                    </div>
                                    <div class="acf-group">
                                        <label for="acf-child">Nombre d'enfant</label>
                                        <input type="number" id="acf-child" min="0" max="10" value="0">
                                    </div>
                                </div>
                                <div class="acf-row">
                                    <div class="acf-group">
                                        <label for="acf-date-in">Date d'entrée</label>
                                        <input type="date" id="acf-date-in" required>
                                    </div>
                                    <div class="acf-group">
                                        <label for="acf-time-in">Heure d'entrée</label>
                                        <input type="time" id="acf-time-in" required>
                                    </div>
                                </div>
                                <div class="acf-row">
                                    <div class="acf-group">
                                        <label for="acf-date-out">Date de sortie</label>
                                        <input type="date" id="acf-date-out" required>
                                    </div>
                                    <div class="acf-group">
                                        <label for="acf-time-out">Heure de sortie</label>
                                        <input type="time" id="acf-time-out" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Bloc Restaurant -->
                            <div id="acf-restaurant-fields" style="display:none;">
                                <div class="acf-row">
                                    <div class="acf-group" style="flex:1 1 100%;">
                                        <label for="acf-restaurant-command-type">Type de commande</label>
                                        <select id="acf-restaurant-command-type" required>
                                            <option value="">Sélectionnez...</option>
                                            <option value="distance">Commande à distance</option>
                                            <option value="presentiel">Commande en présentielle</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Livraison à distance -->
                                <div id="acf-restaurant-distance" style="display:none;">
                                    <div class="acf-row">
                                        <div class="acf-group" style="flex:1 1 100%;">
                                            <label for="acf-delivery-address">Adresse de livraison</label>
                                            <input type="text" id="acf-delivery-address" placeholder="Votre adresse de livraison" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Présentiel -->
                                <div id="acf-restaurant-presentiel" style="display:none;">
                                    <div class="acf-row">
                                        <div class="acf-group" style="flex:1 1 100%;">
                                            <label for="acf-table-number">Numéro de table</label>
                                            <select id="acf-table-number" required>
                                                <option value="">Sélectionnez la table</option>
                                                <option value="1">Table 1</option>
                                                <option value="2">Table 2</option>
                                                <option value="3">Table 3</option>
                                                <option value="4">Table 4</option>
                                                <option value="5">Table 5</option>
                                                <option value="6">Table 6</option>
                                                <!-- Ajoutez d'autres tables si besoin -->
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="acf-action-row justify-content-center">
                                <button type="submit" class="acf-submit-btn"><i class="fas fa-arrow-right"></i> Poursuivre</button>
                            </div>
                        </form>
                    </div>
                </section>

                <div class="divider"></div>

                <section class="restaurant-section">
                    <div class="container">
                        <h2>Nos Restaurants</h2>
                        <div class="restaurant-search-bar">
                            <input type="text" id="restaurant-search-input" placeholder="Rechercher un restaurant, une spécialité, une ville..." autocomplete="off">
                            <button id="restaurant-search-btn"><i class="fas fa-search"></i></button>
                        </div>
                        <div class="restaurant-list" id="restaurant-list">
                            <div class="restaurant-card" data-stars="5" data-restaurant-name="Le Gourmet" data-restaurant-desc="Cuisine française moderne dans un cadre élégant, vins raffinés et spécialités du terroir.">
                                <div class="restaurant-photo">
                                    <div class="restaurant-stars" data-stars="5"></div>
                                    <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=400&q=80" alt="Restaurant Le Gourmet">
                                </div>
                                <div class="restaurant-info">
                                    <h3 class="restaurant-name">Le Gourmet</h3>
                                    <p class="restaurant-address"><i class="fas fa-map-marker-alt" style="color:var(--primary);"></i> 12 avenue Victor Hugo, 75016 Paris</p>
                                    <p class="restaurant-desc">Cuisine française moderne dans un cadre élégant, vins raffinés et spécialités du terroir.</p>
                                    <button class="restaurant-choose-btn">
                                        <i class="fas fa-arrow-right"></i> Entrer</button>
                                </div>
                            </div>
                            <div class="restaurant-card" data-stars="4" data-restaurant-name="La Dolce Vita" data-restaurant-desc="Saveurs italiennes : pizzas au feu de bois et pâtes fraîches dans une ambiance chaleureuse.">
                                <div class="restaurant-photo">
                                    <div class="restaurant-stars" data-stars="4"></div>
                                    <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?auto=format&fit=crop&w=400&q=80" alt="Restaurant La Dolce Vita">
                                </div>
                                <div class="restaurant-info">
                                    <h3 class="restaurant-name">La Dolce Vita</h3>
                                    <p class="restaurant-address"><i class="fas fa-map-marker-alt" style="color:var(--primary);"></i> 12 avenue Victor Hugo, 75016 Paris</p>
                                    <p class="restaurant-desc">Saveurs italiennes : pizzas au feu de bois et pâtes fraîches dans une ambiance chaleureuse.</p>
                                    <button class="restaurant-choose-btn">
                                        <i class="fas fa-arrow-right"></i> Entrer</button>
                                </div>
                            </div>
                            <div class="restaurant-card" data-stars="3" data-restaurant-name="Sushi Zen" data-restaurant-desc="Bar à sushis zen, poissons ultra frais, makis et spécialités japonaises à volonté.">
                                <div class="restaurant-photo">
                                    <div class="restaurant-stars" data-stars="3"></div>
                                    <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=400&q=80" alt="Sushi Zen">
                                </div>
                                <div class="restaurant-info">
                                    <h3 class="restaurant-name">Sushi Zen</h3>
                                    <p class="restaurant-address"><i class="fas fa-map-marker-alt" style="color:var(--primary);"></i> 12 avenue Victor Hugo, 75016 Paris</p>
                                    <p class="restaurant-desc">Bar à sushis zen, poissons ultra frais, makis et spécialités japonaises à volonté.</p>
                                    <button class="restaurant-choose-btn">
                                        <i class="fas fa-arrow-right"></i> Entrer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- SECTION RESTAURANTS -->

                <div class="divider"></div>

                <section class="hotel-section">
                    <div class="container">
                        <h2>Nos Hôtels</h2>
                        <div class="hotel-search-bar">
                            <input type="text" id="hotel-search-input" placeholder="Rechercher un hôtel, une ville, une adresse..." autocomplete="off">
                            <button id="hotel-search-btn"><i class="fas fa-search"></i></button>
                        </div>
                        <div class="hotel-list" id="hotel-list">
                            <div class="hotel-card" data-hotel-name="Hôtel Élysée" data-hotel-address="Paris" data-hotel-desc="Un hôtel 4 étoiles au cœur de Paris avec suites luxueuses, spa & rooftop sur la Seine.">
                                <div class="hotel-main-photo">
                                    <div class="hotel-stars" data-stars="4"></div>
                                    <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=600&q=80" alt="Hôtel Élysée">
                                </div>
                                <div class="hotel-info">
                                    <h3 class="hotel-name">Hôtel Élysée</h3>
                                    <p class="hotel-address"><i class="fas fa-map-marker-alt"></i> 25 Avenue des Champs-Élysées, Paris</p>
                                    <p class="hotel-desc">
                                        Un hôtel 4 étoiles au cœur de Paris avec suites luxueuses, spa & rooftop sur la Seine.
                                    </p>
                                    <div class="hotel-gallery">
                                        <img src="https://images.unsplash.com/photo-1512918728675-ed5a9ecdebfd?auto=format&fit=crop&w=300&q=80" alt="Suite Élysée">
                                        <img src="https://images.unsplash.com/photo-1484154218962-38ffec3eaf0a?auto=format&fit=crop&w=300&q=80" alt="Lobby Élysée">
                                        <img src="https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=crop&w=300&q=80" alt="Spa Élysée">
                                    </div>
                                    <button class="hotel-choose-btn">
                                        <i class="fas fa-check-square"></i> Choisir</button>
                                </div>
                            </div>
                            <div class="hotel-card" data-hotel-name="Hôtel Riviera" data-hotel-address="Nice" data-hotel-desc="Face à la mer, chambres panoramiques, petit-déjeuner sous la pergola et piscine chauffée.">
                                <div class="hotel-main-photo">
                                    <div class="hotel-stars" data-stars="5"></div>
                                    <img src="https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=600&q=80" alt="Hôtel Riviera">
                                </div>
                                <div class="hotel-info">
                                    <h3 class="hotel-name">Hôtel Riviera</h3>
                                    <p class="hotel-address"><i class="fas fa-map-marker-alt"></i> 5 Promenade des Anglais, Nice</p>
                                    <p class="hotel-desc">
                                        Face à la mer, chambres panoramiques, petit-déjeuner sous la pergola et piscine chauffée.
                                    </p>
                                    <div class="hotel-gallery">
                                        <img src="https://images.unsplash.com/photo-1507089947368-19c1da9775ae?auto=format&fit=crop&w=300&q=80" alt="Chambre Riviera">
                                        <img src="https://images.unsplash.com/photo-1491553895911-0055eca6402d?auto=format&fit=crop&w=300&q=80" alt="Piscine Riviera">
                                        <img src="https://images.unsplash.com/photo-1500534314209-0055eca6402d?auto=format&fit=crop&w=300&q=80" alt="Vue Riviera">
                                    </div>
                                    <button class="hotel-choose-btn">
                                        <i class="fas fa-check-square"></i> Choisir</button>
                                </div>
                            </div>
                            <div class="hotel-card" data-hotel-name="Hôtel Mont Blanc" data-hotel-address="Chamonix" data-hotel-desc="Refuge de montagne avec vue sur les Alpes, cheminée cosy et spa nordique privé.">
                                <div class="hotel-main-photo">
                                    <div class="hotel-stars" data-stars="3"></div>
                                    <img src="https://images.unsplash.com/photo-1470770841072-f978cf4d019e?auto=format&fit=crop&w=600&q=80" alt="Hôtel Mont Blanc">
                                </div>
                                <div class="hotel-info">
                                    <h3 class="hotel-name">Hôtel Mont Blanc</h3>
                                    <p class="hotel-address"><i class="fas fa-map-marker-alt"></i> 101 Route du Mont Blanc, Chamonix</p>
                                    <p class="hotel-desc">
                                        Refuge de montagne avec vue sur les Alpes, cheminée cosy et spa nordique privé.
                                    </p>
                                    <div class="hotel-gallery">
                                        <img src="https://images.unsplash.com/photo-1432888498266-38ffec3eaf0a?auto=format&fit=crop&w=300&q=80" alt="Chambre Mont Blanc">
                                        <img src="https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=300&q=80" alt="Salon Mont Blanc">
                                        <img src="https://images.unsplash.com/photo-1445019980597-93fa8acb246c?auto=format&fit=crop&w=300&q=80" alt="Spa Mont Blanc">
                                    </div>
                                    <button class="hotel-choose-btn">
                                        <i class="fas fa-check-square"></i> Choisir</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- SECTION HOTELS -->
            </div>
        </div>
    </div>
    <?php
    require "script.php";
    ?>
</body>

</html>