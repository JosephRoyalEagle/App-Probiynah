<?php
require ('session-control.php');
header('Content-Type: application/json');

// Vérifie que la requête est bien AJAX et POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    header('Location: https://www.probiynah.com');
    exit();
}

$columns = ['id_utilis', 'nom_utilis', 'prenom_utilis', 'numero_utilis', 'dateinscription_utilis', 'heureinscription_utilis', 'statut_utilis', 'role_utilis'];

// Récupération des paramètres POST
$limit = isset($_POST['length']) ? intval($_POST['length']) : 10;
$start = isset($_POST['start']) ? intval($_POST['start']) : 0;
$orderIndex = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 0;
$orderColumn = isset($columns[$orderIndex]) ? $columns[$orderIndex] : 'id_utilis';
$orderDir = isset($_POST['order'][0]['dir']) && in_array($_POST['order'][0]['dir'], ['asc', 'desc']) ? $_POST['order'][0]['dir'] : 'asc';
$searchValue = isset($_POST['search']['value']) ? trim($_POST['search']['value']) : '';

$customDateDebut = $_POST['customDateDebut'] ?? null;
$customDateFin = $_POST['customDateFin'] ?? null;

// Base de la requête
$query = "SELECT * FROM utilisateurs";

$whereClauses = [];
$params = [];

// Bloc de recherche
$searchClause = "";
if (!empty($searchValue)) {
    $searchClause = "(nom_utilis LIKE :search OR prenom_utilis LIKE :search OR role_utilis LIKE :search OR numero_utilis LIKE :search OR statut_utilis LIKE :search)";
    $params[':search'] = "%$searchValue%";
}

// Bloc de dates
$dateClauses = [];
if (!empty($customDateDebut) && !empty($customDateFin)) {
    $dateClauses[] = "dateinscription_utilis BETWEEN :dateDebut AND :dateFin";
    $params[':dateDebut'] = $customDateDebut;
    $params[':dateFin'] = $customDateFin;
} elseif (!empty($customDateDebut)) {
    $dateClauses[] = "dateinscription_utilis >= :dateDebut";
    $params[':dateDebut'] = $customDateDebut;
} elseif (!empty($customDateFin)) {
    $dateClauses[] = "dateinscription_utilis <= :dateFin";
    $params[':dateFin'] = $customDateFin;
}

// Clause SAdmin Ou Gestionnaire seule
$roleClause = "(role_utilis = :role1 OR role_utilis = :role2)";
$params[':role1'] = "SAdmin";
$params[':role2'] = "Gestionnaire";

// Finaliser les WHERE
$allWhere = [];

if (!empty($searchClause)) {
    $allWhere[] = "($searchClause)";
}

if (!empty($dateClauses)) {
    $allWhere[] = "(" . implode(' AND ', $dateClauses) . ")";
}

$allWhere[] = $roleClause;
$query .= " WHERE " . implode(' AND ', $allWhere);

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
$roles_key = [
    'SAdmin' => 'Administrateur',
    'Gestionnaire' => 'Gestionnaire',
];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $subArray = [];
    $subArray['numero_admin'] = $numero++;
    $subArray['nom_admin'] = $row['nom_utilis'];
    $subArray['prenom_admin'] = $row['prenom_utilis'];
    $subArray['role_admin'] = $roles_key[$row['role_utilis']] ?? 'Inconnu';
    $subArray['statut_admin'] = $row['statut_utilis'];
    $subArray['telephone_admin'] = $row['numero_utilis'];
    $subArray['date_admin'] = date('d-m-Y', strtotime($row['dateinscription_utilis']));
    $subArray['heure_admin'] = $row['heureinscription_utilis'];

    $subArray['actions_admin'] = '
        <!-- Bouton Modifier -->
        <a class="btn btn-primary btn-sm mx-1 my-1" href="manage-profile.php?pfrlo='.encryptData($row['id_utilis']).'&amp;pfrlon='.encryptData($row['nom_utilis'] . ' ' . $row['prenom_utilis']).'">
            <i class="fas fa-edit"></i>
        </a>

        <!-- Bouton Supprimer -->
        <button class="btn btn-danger btn-sm deleteBtn mx-1 my-1" data-id="'.encryptData($row['id_utilis']).'">
            <i class="fas fa-trash"></i>
        </button>';

    $data[] = $subArray;
}

// Compter le nombre total
$stmt = $db_host->prepare("SELECT COUNT(*) FROM utilisateurs WHERE role_utilis IN (?, ?)");
$stmt->execute(['SAdmin', 'Gestionnaire']);
$totalData = $stmt->fetchColumn();

// Compter le nombre total filtré
$totalFiltered = !empty($searchValue) ? $stmt->rowCount() : $totalData;

// Calcul du total des utilisateurs affichés (filtrés)
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