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

                </div>
            </div>
        </div>
        <?php
            require "script.php";
        ?>
    </body>
</html>