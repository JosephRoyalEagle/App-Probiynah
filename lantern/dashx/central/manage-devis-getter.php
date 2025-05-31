<?php
require ('session-control.php');
header('Content-Type: application/json');

// Vérifie que la requête est bien AJAX et POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    header('Location: https://www.probiynah.com');
    exit();
}

$columns = ['id_devis', 'code_devis', 'termes_conditions_devis', 'reglement_conditions_devis', 'tva_devis', 'remise_devis', 'nom_offreur_devis', 'email_offreur_devis', 'tel_offreur_devis', 'adresse_offreur_devis', 'logo_offreur_devis', 'nom_client_devis', 'email_client_devis', 'tel_client_devis', 'adresse_client_devis', 'dateinsertion_devis', 'echeance_devis', 'heureinsertion_devis', 'id_business'];

// Récupération des paramètres POST
$limit = isset($_POST['length']) ? intval($_POST['length']) : 10;
$start = isset($_POST['start']) ? intval($_POST['start']) : 0;
$orderIndex = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 0;
$orderColumn = isset($columns[$orderIndex]) ? $columns[$orderIndex] : 'id_devis';
$orderDir = isset($_POST['order'][0]['dir']) && in_array($_POST['order'][0]['dir'], ['asc', 'desc']) ? $_POST['order'][0]['dir'] : 'asc';
$searchValue = isset($_POST['search']['value']) ? trim($_POST['search']['value']) : '';

$customDateDebut = $_POST['customDateDebut'] ?? null;
$customDateFin = $_POST['customDateFin'] ?? null;

// Base de la requête
$query = "SELECT * FROM devis";

$whereClauses = [];
$params = [];

// Bloc de recherche
if (!empty($searchValue)) {
    $whereClauses[] = "(code_devis LIKE :search OR nom_offreur_devis LIKE :search OR email_offreur_devis LIKE :search OR tel_offreur_devis LIKE :search OR adresse_offreur_devis LIKE :search OR nom_client_devis LIKE :search OR email_client_devis LIKE :search OR tel_client_devis LIKE :search OR adresse_client_devis LIKE :search OR echeance_devis LIKE :search)";
    $params[':search'] = "%$searchValue%";
}

// Filtres par date d'adhésion
if (!empty($customDateDebut) && !empty($customDateFin)) {
    $whereClauses[] = "dateinsertion_devis BETWEEN :dateDebut AND :dateFin";
    $params[':dateDebut'] = $customDateDebut;
    $params[':dateFin'] = $customDateFin;
} elseif (!empty($customDateDebut)) {
    $whereClauses[] = "dateinsertion_devis >= :dateDebut";
    $params[':dateDebut'] = $customDateDebut;
} elseif (!empty($customDateFin)) {
    $whereClauses[] = "dateinsertion_devis <= :dateFin";
    $params[':dateFin'] = $customDateFin;
}

// Application de la condition id_business vide/null
$whereClauses[] = "(id_business IS NULL OR TRIM(id_business) = '')";

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
    $subArray['numero_devis'] = $numero++;
    $subArray['code_devis'] = $row['code_devis'];
    $subArray['emeteur_devis'] = $row['nom_offreur_devis'];
    $subArray['destinataire_devis'] = $row['nom_client_devis'];
    $subArray['tva_devis'] = !empty($row['tva_devis']) ? $row['tva_devis'] : 0;
    $subArray['remise_devis'] = !empty($row['remise_devis']) ? $row['remise_devis'] : 0;
    $subArray['echeance_devis'] = date('d-m-Y', strtotime($row['echeance_devis']));
    $subArray['date_devis'] = date('d-m-Y', strtotime($row['dateinsertion_devis']));
    $subArray['heure_devis'] = $row['heureinsertion_devis'];

    $logoHtml = '';
    if (!empty(trim($row['logo_offreur_devis']))) {
        $safeLogo = htmlspecialchars($row['logo_offreur_devis'], ENT_QUOTES, 'UTF-8');
        $logoHtml = '<li class="list-group-item"><img src="../../uploads/devis/'.$safeLogo.'" height="80" alt="Logo de l\'entreprise" class="img-thumbnail"></li>';
    }


    $subArray['autres_info_devis'] = '
        <button class="btn btn-primary btn-sm viewBtn mt-1" data-id="'.$numero.'" data-bs-toggle="modal" data-bs-target="#modalViewDevisAutresInfos'.$numero.'">
            <i class="fas fa-eye"></i> Consulter
        </button>
        
        <div class="modal fade" id="modalViewDevisAutresInfos'.$numero.'" tabindex="-1" aria-labelledby="modalViewDevisAutresInfosLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header text-white" style="background-color: var(--primary);">
                        <h5 class="modal-title" id="modalViewDevisAutresInfosLabel"><i class="fas fa-plus-circle"></i> Informations sur le devis <span class="fw-bold text-black">'.$row['code_devis'].'</span></h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row justify-content-center">
                                <div class="col-lg-12">
                                    <div class="card shadow">
                                        <div class="card-body p-4">
                                            <div class="row">
                                                <div class="col-12 col-md-6 mb-3">
                                                    <h2>EMETTEUR</h2>
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item">Nom : <span class="fw-bold text-black">'.$row['nom_offreur_devis'].'</span></li>
                                                        <li class="list-group-item">Telephone : <span class="fw-bold text-black">'.$row['tel_offreur_devis'].'</span></li>
                                                        <li class="list-group-item">Email : <span class="fw-bold text-black">'.$row['email_offreur_devis'].'</span></li>
                                                        <li class="list-group-item">Adresse : <span class="fw-bold text-black">'.$row['adresse_offreur_devis'].'</span></li>
                                                        '.$logoHtml.'
                                                    </ul>
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    <h2>DESTINATAIRE</h2>
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item">Nom : <span class="fw-bold text-black">'.$row['nom_client_devis'].'</span></li>
                                                        <li class="list-group-item">Telephone : <span class="fw-bold text-black">'.$row['tel_client_devis'].'</span></li>
                                                        <li class="list-group-item">Email : <span class="fw-bold text-black">'.$row['email_client_devis'].'</span></li>
                                                        <li class="list-group-item">Adresse : <span class="fw-bold text-black">'.$row['adresse_client_devis'].'</span></li>
                                                    </ul>
                                                </div>
                                                <div class="col-12 col-md-12 mb-3">
                                                    <h2>TERMES ET CONDITIONS</h2>
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item">Reglement devis : <span class="fw-bold text-black">'.$row['termes_conditions_devis'].'</span></li>
                                                        <li class="list-group-item">Reglement facture : <span class="fw-bold text-black">'.$row['reglement_conditions_devis'].'</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';

    $subArray['contenu_devis'] = '
        <a class="btn btn-primary btn-sm mx-1 my-1" href="manage-devis-contain.php?edsrlo='.encryptData($row['id_devis']).'&amp;edsrlon='.encryptData($row['code_devis']).'">
            <i class="fas fa-pencil-alt"></i> Consulter
        </a>';

    $subArray['actions_devis'] = '
        <a class="btn btn-success btn-sm mx-1 my-1" href="manage-devis.php?devis='.encryptData($row['id_devis']).'">
            <i class="fas fa-download"></i> Devis
        </a>

        <a class="btn btn-warning btn-sm mx-1 my-1" href="manage-devis.php?facture='.encryptData($row['id_devis']).'">
            <i class="fas fa-download"></i> Facture
        </a>

        <!-- Bouton Modifier -->
        <button class="btn btn-primary btn-sm editBtn mt-1" data-id="'.$numero.'" data-bs-toggle="modal" data-bs-target="#modalUpdateNewData'.$numero.'">
            <i class="fas fa-edit"></i>
        </button>

        <!-- Bouton Supprimer -->
        <button class="btn btn-danger btn-sm deleteBtn mx-1 my-1" data-id="'.encryptData($row['id_devis']).'">
            <i class="fas fa-trash"></i>
        </button>
        
        <!-- Modal Modification -->
        <div class="modal fade" id="modalUpdateNewData'.$numero.'" tabindex="-1" aria-labelledby="modalUpdateNewDataLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header text-white" style="background-color: var(--primary);">
                        <h5 class="modal-title" id="modalUpdateNewDataLabel"><i class="fas fa-plus-circle"></i> Modification du devis <span class="fw-bold text-black">'.$row['code_devis'].'</span></h5>
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
                                                            <label for="nomEmetteurDevis">Nom emetteur</label>
                                                            <input type="text" id="nomEmetteurDevis" name="nomEmetteurDevis" placeholder="Loroval" value="'.$row['nom_offreur_devis'].'" class="form-control" minlength="2" maxlength="50">
                                                        </div>

                                                        <div class="form-group mb-3">
                                                            <label for="phoneEmetteurDevis">Téléphone emetteur</label>
                                                            <input type="text" id="phoneEmetteurDevis" name="phoneEmetteurDevis" placeholder="+2250504586594" value="'.$row['tel_offreur_devis'].'" class="form-control" minlength="7" maxlength="20">
                                                        </div>

                                                        <div class="form-group mb-3">
                                                            <label for="emailEmetteurDevis">Email emetteur</label>
                                                            <input type="email" id="emailEmetteurDevis" name="emailEmetteurDevis" placeholder="info@loroval.com" value="'.$row['email_offreur_devis'].'" class="form-control" maxlength="100">
                                                        </div>

                                                        <div class="form-group mb-3">
                                                            <label for="adresseEmetteurDevis">Adresse emetteur</label>
                                                            <input type="text" id="adresseEmetteurDevis" name="adresseEmetteurDevis" placeholder="Cocody Saint Jean" value="'.$row['adresse_offreur_devis'].'" class="form-control" minlength="2" maxlength="50">
                                                        </div>

                                                        <div class="form-group mb-3">
                                                            <label for="imageProd">Logo emetteur (*.png, *.jpg, *.jpeg)</label>
                                                            <input type="file" id="imageProd" name="imageProd" class="form-control" accept=".png, .jpg, .jpeg, image/png, image/jpeg">
                                                        </div>

                                                        <div class="form-group mb-3">
                                                            <label for="nomDestinataireDevis">Nom destinataire</label>
                                                            <input type="text" id="nomDestinataireDevis" name="nomDestinataireDevis" placeholder="Jared Seoan" value="'.$row['nom_client_devis'].'" class="form-control" minlength="2" maxlength="50">
                                                        </div>

                                                        <div class="form-group mb-3">
                                                            <label for="phoneDestinataireDevis">Téléphone destinataire</label>
                                                            <input type="text" id="phoneDestinataireDevis" name="phoneDestinataireDevis" placeholder="+225070486594" value="'.$row['tel_client_devis'].'" class="form-control" minlength="7" maxlength="20">
                                                        </div>

                                                        <div class="form-group mb-3">
                                                            <label for="emailDestinataireDevis">Email destinataire</label>
                                                            <input type="email" id="emailDestinataireDevis" name="emailDestinataireDevis" placeholder="jared45@gmail.com" value="'.$row['email_client_devis'].'" class="form-control" maxlength="100">
                                                        </div>

                                                        <div class="form-group mb-3">
                                                            <label for="adresseDestinataireDevis">Adresse destinataire</label>
                                                            <input type="text" id="adresseDestinataireDevis" name="adresseDestinataireDevis" placeholder="Cocody Angré" value="'.$row['adresse_client_devis'].'" class="form-control" minlength="2" maxlength="50">
                                                        </div>

                                                        <div class="form-group mb-3">
                                                            <label for="dateValiditeDevis">Date de validité</label>
                                                            <input type="date" id="dateValiditeDevis" name="dateValiditeDevis" value="'.$row['echeance_devis'].'" class="form-control">
                                                        </div>

                                                        <div class="form-group mb-3">
                                                            <label for="tvaDevis">TVA</label>
                                                            <input type="text" id="tvaDevis" name="tvaDevis" placeholder="0" value="'.$row['tva_devis'].'" class="form-control" minlength="1" maxlength="3">
                                                        </div>

                                                        <div class="form-group mb-3">
                                                            <label for="remiseDevis">Remise</label>
                                                            <input type="text" id="remiseDevis" name="remiseDevis" placeholder="0" value="'.$row['remise_devis'].'" class="form-control" minlength="1" maxlength="3">
                                                        </div>

                                                        <div class="form-group mb-3">
                                                            <label for="termesDevis">Conditions devis</label>
                                                            <textarea id="termesDevis" name="termesDevis" placeholder="Le paiement sera effectué par virement bancaire." rows="4" class="form-control" minlength="10" maxlength="200">'.$row['termes_conditions_devis'].'</textarea>
                                                        </div>

                                                        <div class="form-group mb-3">
                                                            <label for="termesFacture">Conditions facture</label>
                                                            <textarea id="termesFacture" name="termesFacture" placeholder="Le paiement sera effectué par virement bancaire." rows="4" class="form-control" minlength="10" maxlength="200">'.$row['reglement_conditions_devis'].'</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="input-group mb-3">
                                                    <input type="hidden" class="form-control" id="serverDataIdHidden" name="serverDataIdHidden" value="'.encryptData($row['id_devis']).'" required>
                                                </div>

                                                <div class="form-actions justify-content-center mt-4">
                                                    <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">
                                                        <i class="fas fa-times"></i> Annuler
                                                    </button>
                                                    <button type="button" id="btn-sub-updateprod" class="submit-btn" data-id="'.$numero.'">
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
$totalData = $db_host->query("SELECT COUNT(*) FROM devis WHERE id_business IS NULL OR TRIM(id_business) = ''")->fetchColumn();
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