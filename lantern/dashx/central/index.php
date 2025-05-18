<!DOCTYPE html>
<html lang="fr">
    <head>
        <?php
            require "head.php";
        ?>
        <title>Superviseur - Probiynah App</title>
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
                                    <img src="1.jpg" alt="Produit 1">
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
                                    <img src="1.jpg" alt="Produit 1">
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
                                    <img src="1.jpg" alt="Produit 1">
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

                    <!-- Section: Tableau des produits -->
                    <section class="dashboard-section">
                        <h2 class="section-title"><i class="fas fa-list-alt"></i> Liste des Produits</h2>
                        <div class="card">
                            <div class="product-table-section">
                                <table class="product-table">
                                    <thead>
                                        <tr>
                                            <th>Produit</th>
                                            <th>Prix Unitaire</th>
                                            <th>Quantité</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Smartphone Premium</td>
                                            <td>€799.99</td>
                                            <td>1</td>
                                            <td>€799.99</td>
                                        </tr>
                                        <tr>
                                            <td>Smartphone Premium</td>
                                            <td>€799.99</td>
                                            <td>1</td>
                                            <td>€799.99</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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

                                <div class="form-actions">
                                    <button type="submit" class="submit-btn">
                                        <i class="fas fa-save"></i> Enregistrer le produit
                                    </button>
                                    <button type="reset" class="reset-btn">
                                        <i class="fas fa-undo"></i> Réinitialiser
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
                    <!-- Ajoutez cette section dans le content-body -->
                    <section class="dashboard-section">
                        <h2 class="section-title"><i class="fas fa-user-circle"></i> Mon Profil</h2>
                        <div class="card-container">
                            <!-- Colonne de gauche - Informations du profil -->
                            <div class="card">
                                <div class="profile-header">
                                    <div class="profile-avatar">
                                        <img src="https://via.placeholder.com/150" alt="Photo de profil"
                                            id="profile-picture">
                                        <input type="file" id="avatar-upload" accept="image/*" style="display: none;">
                                    </div>
                                    <div class="profile-info">
                                        <h3>Client</h3>
                                        <p class="member-since">Membre depuis: 15/06/2023</p>
                                    </div>
                                </div>

                                <div class="profile-details">
                                    <ul class="info-list">
                                        <li>
                                            <strong><i class="fas fa-envelope"></i> Email:</strong>
                                            <span>contact@probjynah.com</span>
                                        </li>
                                        <li>
                                            <strong><i class="fas fa-phone"></i> Téléphone:</strong>
                                            <span>+33 6 12 34 56 78</span>
                                        </li>
                                        <li>
                                            <strong><i class="fas fa-map-marker-alt"></i> Adresse:</strong>
                                            <span>123 Rue Example, Paris, France</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Colonne de droite - Formulaire d'édition -->
                            <div class="card">
                                <h3 class="card-title"><i class="fas fa-edit"></i> Modifier le profil</h3>
                                <form class="profile-form">
                                    <div class="form-group">
                                        <label for="username">Nom d'utilisateur</label>
                                        <input type="text" id="username" value="cp2118503921" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label for="fullname">Nom complet</label>
                                        <input type="text" id="fullname" value="Admin Probjynah">
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" id="email" value="contact@probjynah.com">
                                    </div>

                                    <div class="form-group">
                                        <label for="phone">Téléphone</label>
                                        <input type="tel" id="phone" value="+33 6 12 34 56 78">
                                    </div>

                                    <div class="form-group">
                                        <label for="address">Adresse</label>
                                        <textarea id="address" rows="2">123 Rue Example, Paris, France</textarea>
                                    </div>

                                    <div class="form-actions">
                                        <button type="button" class="cancel-btn btn-secondary">
                                            <i class="fas fa-times"></i> Annuler
                                        </button>
                                        <button type="submit" class="save-btn btn-primary">
                                            <i class="fas fa-save"></i> Enregistrer
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
    </body>
</html>