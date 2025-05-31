<?php
require ('session-control.php');
header('Content-Type: application/json');

// Vérifie que la requête est bien AJAX et POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    header('Location: https://www.probiynah.com');
    exit();
}

$columns = ['id_cateprod', 'designation_cateprod', 'type_cateprod', 'dateinsertion_cateprod', 'heureinsertion_cateprod'];

// Récupération des paramètres POST
$limit = isset($_POST['length']) ? intval($_POST['length']) : 10;
$start = isset($_POST['start']) ? intval($_POST['start']) : 0;
$orderIndex = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 0;
$orderColumn = isset($columns[$orderIndex]) ? $columns[$orderIndex] : 'id_cateprod';
$orderDir = isset($_POST['order'][0]['dir']) && in_array($_POST['order'][0]['dir'], ['asc', 'desc']) ? $_POST['order'][0]['dir'] : 'asc';
$searchValue = isset($_POST['search']['value']) ? trim($_POST['search']['value']) : '';

$customDateDebut = $_POST['customDateDebut'] ?? null;
$customDateFin = $_POST['customDateFin'] ?? null;

// Base de la requête
$query = "SELECT * FROM categorie_produits";

$whereClauses = [];
$params = [];

// Bloc de recherche
if (!empty($searchValue)) {
    $whereClauses[] = "(designation_cateprod LIKE :search OR type_cateprod LIKE :search)";
    $params[':search'] = "%$searchValue%";
}

// Filtres par date d'adhésion
if (!empty($customDateDebut) && !empty($customDateFin)) {
    $whereClauses[] = "dateinsertion_cateprod BETWEEN :dateDebut AND :dateFin";
    $params[':dateDebut'] = $customDateDebut;
    $params[':dateFin'] = $customDateFin;
} elseif (!empty($customDateDebut)) {
    $whereClauses[] = "dateinsertion_cateprod >= :dateDebut";
    $params[':dateDebut'] = $customDateDebut;
} elseif (!empty($customDateFin)) {
    $whereClauses[] = "dateinsertion_cateprod <= :dateFin";
    $params[':dateFin'] = $customDateFin;
}

// Application des conditions WHERE
if (!empty($whereClauses)) {
    $query .= ' WHERE ' . implode(' AND ', $whereClauses);
}

// Tri + pagination
$query .= " ORDER BY $orderColumn $orderDir LIMIT :start, :limit";

// Préparation et exécution
$stmt = $db_host->prepare($query);

// Binding des valeurs
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value, PDO::PARAM_STR);
}

$stmt->bindParam(':start', $start, PDO::PARAM_INT);
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->execute();

$data = [];
$numero = $start + 1;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $subArray = [];
    $subArray['numero_catprod'] = $numero++;
    $subArray['designation_catprod'] = $row['designation_cateprod'];
    $subArray['typeproduit_catprod'] = $row['type_cateprod'];
    $subArray['date_catprod'] = date('d-m-Y', strtotime($row['dateinsertion_cateprod']));
    $subArray['heure_catprod'] = $row['heureinsertion_cateprod'];

    $subArray['actions_catprod'] = '
        <!-- Bouton Modifier -->
        <button class="btn btn-primary btn-sm editBtn mt-1" data-id="'.$numero.'" data-bs-toggle="modal" data-bs-target="#modalUpdateNewData'.$numero.'">
            <i class="fas fa-edit"></i>
        </button>

        <!-- Bouton Supprimer -->
        <button class="btn btn-danger btn-sm deleteBtn mx-1 my-1" data-id="'.encryptData($row['id_cateprod']).'">
            <i class="fas fa-trash"></i>
        </button>
        
        <!-- Modal Modification -->
        <div class="modal fade" id="modalUpdateNewData'.$numero.'" tabindex="-1" aria-labelledby="modalUpdateNewDataLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header text-white" style="background-color: var(--primary);">
                        <h5 class="modal-title" id="modalUpdateNewDataLabel"><i class="fas fa-plus-circle"></i> Modification de la catégorie <span class="fw-bold text-black">'.$row['designation_cateprod'].'</span></h5>
                        <button type="button" class="btn-close btn-close-white btn-close-modal-reloaded" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row justify-content-center">
                                <div class="col-lg-12">
                                    <div class="card shadow">
                                        <div class="card-body p-4">
                                            <form id="product-form" class="product-form" enctype="multipart/form-data">
                                                <div class="form-row">
                                                    <div class="col-md-12">
                                                        <div class="form-group mb-3">
                                                            <label for="designation">Désignation</label>
                                                            <input type="text" id="designation" name="designation" placeholder="Liqueur" value="'.$row['designation_cateprod'].'" class="form-control" minlenght="2" maxlength="70">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group mb-3">
                                                            <label for="typeproduit">Type de produit</label>
                                                            <select id="typeproduit" name="typeproduit" class="form-control">
                                                                <option value="">Sélectionnez</option>
                                                                <option value="Nourriture">Nourriture</option>
                                                                <option value="Boisson">Boisson</option>
                                                                <option value="'.$row['type_cateprod'].'" selected>'.$row['type_cateprod'].'</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="input-group mb-3">
                                                    <input type="hidden" class="form-control" id="serverDataIdHidden" name="serverDataIdHidden" value="'.encryptData($row['id_cateprod']).'" required>
                                                </div>

                                                <div class="form-actions justify-content-center mt-4">
                                                    <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">
                                                        <i class="fas fa-times"></i> Annuler
                                                    </button>
                                                    <button type="button" id="btn-sub-updatecatprod" class="submit-btn" data-id="'.$numero.'">
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
        </div>'
        ;

    $data[] = $subArray;
}

// Compter le nombre total
$totalData = $db_host->query("SELECT COUNT(*) FROM categorie_produits")->fetchColumn();
$totalFiltered = !empty($searchValue) ? $stmt->rowCount() : $totalData;

// Calcul du total des categorie_produits affichés (filtrés)
$totalDataReturn = 0;
if ($totalFiltered > 0) {
    $totalDataReturn = $totalFiltered;
}

// 🔒 Protection contre erreur "Undefined index: draw"
$draw = isset($_POST['draw']) ? intval($_POST['draw']) : 0;

// Réponse JSON
$response = [
    "totalDataReturn" => $totalDataReturn,
    "draw" => intval($_POST['draw']),
    "recordsTotal" => $totalData,
    "recordsFiltered" => $totalFiltered,
    "data" => $data
];

echo json_encode($response, JSON_PRETTY_PRINT);
?>