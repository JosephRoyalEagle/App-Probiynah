<?php
require('session-control.php');
header('Content-Type: application/json');

// Vérification que la requête est bien AJAX et POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    header('Location: https://www.probiynah.com');
    exit();
}

$columns = ['id_commune', 'nom_commune', 'dateinsertion_commune', 'heureeinsertion_commune'];

// Récupération des paramètres POST
$limit = isset($_POST['length']) ? intval($_POST['length']) : 10;
$start = isset($_POST['start']) ? intval($_POST['start']) : 0;
$orderIndex = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 0;
$orderColumn = isset($columns[$orderIndex]) ? $columns[$orderIndex] : 'id_commune';
$orderDir = isset($_POST['order'][0]['dir']) && in_array($_POST['order'][0]['dir'], ['asc', 'desc']) ? $_POST['order'][0]['dir'] : 'asc';
$searchValue = isset($_POST['search']['value']) ? trim($_POST['search']['value']) : '';

$customDateDebut = $_POST['customDateDebut'] ?? null;
$customDateFin = $_POST['customDateFin'] ?? null;

// Construction de la requête de base
$query = "SELECT * FROM commune";
$countQuery = "SELECT COUNT(*) FROM commune"; // Pour le comptage total

$whereClauses = [];
$params = [];
$countParams = [];

// Gestion de la recherche globale
if (!empty($searchValue)) {
    $whereClauses[] = "(nom_commune LIKE :search)";
    $params[':search'] = "%$searchValue%";
    $countParams[':search'] = "%$searchValue%";
}

// Filtres par date
if (!empty($customDateDebut) && !empty($customDateFin)) {
    $whereClauses[] = "dateinsertion_commune BETWEEN :dateDebut AND :dateFin";
    $params[':dateDebut'] = $customDateDebut;
    $params[':dateFin'] = $customDateFin;
    $countParams[':dateDebut'] = $customDateDebut;
    $countParams[':dateFin'] = $customDateFin;
} elseif (!empty($customDateDebut)) {
    $whereClauses[] = "dateinsertion_commune >= :dateDebut";
    $params[':dateDebut'] = $customDateDebut;
    $countParams[':dateDebut'] = $customDateDebut;
} elseif (!empty($customDateFin)) {
    $whereClauses[] = "dateinsertion_commune <= :dateFin";
    $params[':dateFin'] = $customDateFin;
    $countParams[':dateFin'] = $customDateFin;
}

// Ajout des conditions WHERE si nécessaire
if (!empty($whereClauses)) {
    $query .= " WHERE " . implode(" AND ", $whereClauses);
    $countQuery .= " WHERE " . implode(" AND ", $whereClauses);
}

// Tri et pagination
$query .= " ORDER BY $orderColumn $orderDir LIMIT :start, :limit";

// Préparation et exécution de la requête principale
$stmt = $db_host->prepare($query);

// Liaison des paramètres
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}

$stmt->bindValue(':start', $start, PDO::PARAM_INT);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->execute();

// Récupération des données
$data = [];
$numero = $start + 1;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $subArray = [];
    $subArray['numero'] = $numero++;
    $subArray['nom_commune'] = ucwords($row['nom_commune']);
    $subArray['dateinsertion_commune'] = date('d-m-Y', strtotime($row['dateinsertion_commune']));
    $subArray['heureeinsertion_commune'] = $row['heureeinsertion_commune'] ?? 'Inconnu';

    // Boutons d'action
    $subArray['actions'] = '
        <button class="btn btn-primary btn-sm editBtn" data-id="' . $row['id_commune'] . '"
         data-libelle="' . htmlspecialchars(ucwords($row['nom_commune']), ENT_QUOTES) . '"
          data-ville="' . htmlspecialchars(ucwords($row['id_ville']), ENT_QUOTES) . '">
            <i class="fas fa-edit"></i>
        </button>
        <button class="btn btn-danger btn-sm deleteBtn" data-id="' . $row['id_commune'] . '">
            <i class="fas fa-trash"></i>
        </button>
    ';
    $data[] = $subArray;
}

// Comptage des résultats
$totalData = $db_host->query("SELECT COUNT(*) FROM commune")->fetchColumn();

// Comptage des résultats filtrés
$countStmt = $db_host->prepare($countQuery);
foreach ($countParams as $key => $value) {
    $countStmt->bindValue($key, $value);
}
$countStmt->execute();
$totalFiltered = $countStmt->fetchColumn();

// Préparation de la réponse JSON
$response = [
    "totalDataReturn" => count($data),
    "draw" => intval($_POST['draw'] ?? 0),
    "recordsTotal" => $totalData,
    "recordsFiltered" => $totalFiltered,
    "data" => $data
];

echo json_encode($response, JSON_PRETTY_PRINT);
