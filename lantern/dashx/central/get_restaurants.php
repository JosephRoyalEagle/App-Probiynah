<?php
require('session-control.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    http_response_code(403);
    echo json_encode(["status" => "error", "message" => "Accès non autorisé."]);
    exit;
}

// Fonction pour générer les étoiles en HTML
function generateStars($rating)
{
    $stars = '';
    $fullStars = floor($rating);
    $hasHalfStar = ($rating - $fullStars) >= 0.5;

    for ($i = 0; $i < 5; $i++) {
        if ($i < $fullStars) {
            $stars .= '<i class="fas fa-star"></i>';
        } elseif ($i == $fullStars && $hasHalfStar) {
            $stars .= '<i class="fas fa-star-half-alt"></i>';
        } else {
            $stars .= '<i class="far fa-star"></i>';
        }
    }
    return $stars;
}

// Fonction pour générer le modal HTML
function generateModalHtml($restaurant)
{
    // Récupérer les données nécessaires pour les selects
    $gestionnaires = $GLOBALS['db_host']->query("SELECT *,id_utilis, nom_utilis, prenom_utilis FROM utilisateurs WHERE lower(role_utilis) = 'gestionnaire'")->fetchAll();
    $pays = $GLOBALS['db_host']->query("SELECT id_pays, libelle_pays FROM pays")->fetchAll();

    $selectedGestionnaire = $restaurant['id_proprio'] ?? '';
    $selectedPays = $restaurant['id_pays'] ?? '';

    $gestionnaireOptions = '';
    foreach ($gestionnaires as $g) {
        $selected = $g['id_utilis'] == $selectedGestionnaire ? 'selected' : '';
        $gestionnaireOptions .= '<option value="' . $g['id_utilis'] . '" ' . $selected . '>' . ucwords($g['nom_utilis'] . ' ' . $g['prenom_utilis']) . '</option>';
    }

    $paysOptions = '';
    foreach ($pays as $p) {
        $selected = $p['id_pays'] == $selectedPays ? 'selected' : '';
        $paysOptions .= '<option value="' . $p['id_pays'] . '" ' . $selected . '>' . $p['libelle_pays'] . '</option>';
    }

    $imagePreview = '';
    if (!empty($restaurant['nomfichier_business_assets'])) {
        $imageSrc = '../../uploads/business/' . $restaurant['nomfichier_business_assets'];
        $imagePreview = '<img src="' . $imageSrc . '" class="img-thumbnail mt-2" style="max-height: 150px;">';
    }


    return <<<HTML
<div class="modal fade" id="modalUpdateRestaurant{$restaurant['id_business']}" tabindex="-1" aria-labelledby="modalUpdateRestaurantLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header text-white" style="background-color: var(--primary);">
                <h5 class="modal-title" id="modalUpdateRestaurantLabel">
                    <i class="fas fa-edit"></i> Modification du restaurant <span class="fw-bold text-black">{$restaurant['nom_business']}</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="card shadow">
                                <div class="card-body p-4">
                                    <form id="restaurant-form-{$restaurant['id_business']}" class="product-form" enctype="multipart/form-data">
                                        <div class="form-grid">
                                            <div class="form-column">
                                                <div class="form-group">
                                                    <label for="nom_business">Nom du restaurant</label>
                                                    <input type="text" id="nom_business" name="nom_business" class="form-control" value="{$restaurant['nom_business']}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="description_business">Description</label>
                                                    <textarea id="description_business" name="description_business" class="form-control" required>{$restaurant['description_business']}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="adresse_business">Adresse</label>
                                                    <input type="text" id="adresse_business" name="adresse_business" class="form-control" value="{$restaurant['adresse_business']}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="id_proprio">Administrateur</label>
                                                    <select id="id_proprio" name="id_proprio" class="form-select" required>
                                                        <option value="">Sélectionnez un utilisateur</option>
                                                        {$gestionnaireOptions}
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-column">
                                                <div class="form-group">
                                                    <label for="etoile_business">Évaluation</label>
                                                    <input type="number" id="etoile_business" name="etoile_business" min="0" max="5" step="0.5" class="form-control" value="{$restaurant['etoile_business']}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="id_pays">Pays</label>
                                                    <select id="id_pays" name="id_pays" class="id_pays_change form-select" required>
                                                        <option value="">Sélectionnez un pays</option>
                                                        {$paysOptions}
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
                                                    <label for="business_image">Image</label>
                                                    <input type="file" id="business_image" name="business_image" class="form-control" accept="image/*">
                                                    {$imagePreview}
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="restaurantId" value="{$restaurant['id_business']}">
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
HTML;
}

try {
    $query = "SELECT b.*, a.nomfichier_business_assets 
              FROM business b 
              LEFT JOIN business_assets a ON b.id_business = a.id_business 
              ORDER BY b.datecreation_business DESC";
    $stmt = $db_host->prepare($query);
    $stmt->execute();
    $restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Préparer les données pour le frontend
    $output = [];
    foreach ($restaurants as $r) {
        $output[] = [
            'id_business' => $r['id_business'],
            'nom_business' => htmlspecialchars($r['nom_business']),
            'description_business' => htmlspecialchars($r['description_business']),
            'adresse_business' => htmlspecialchars($r['adresse_business']),
            'etoile_business' => $r['etoile_business'],
            'nomfichier_business_assets' => $r['nomfichier_business_assets'],
            'stars_html' => generateStars($r['etoile_business']),
            'modal_html' => generateModalHtml($r),
            'delete_confirmation' => json_encode([
                'title' => 'Êtes-vous sûr ?',
                'text' => "Vous allez supprimer définitivement le restaurant " . htmlspecialchars($r['nom_business']),
                'icon' => 'warning',
                'confirmButtonText' => 'Oui, supprimer',
                'cancelButtonText' => 'Annuler'
            ])
        ];
    }

    echo json_encode([
        "status" => "success",
        "data" => $output
    ]);
} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Erreur lors de la récupération des restaurants."
    ]);
}
exit;
