<?php
require_once __DIR__ . '/../../models/pret/Pret.php';
require_once __DIR__ . '/../../models/paiement/Payement.php';
require_once __DIR__ . '/../../helpers/Utils.php';
require_once __DIR__ . '/../../helpers/PretPDF.php';

class PretController {

    public static function formDemandePret() {
        include __DIR__ . '/../../views/pret/demanderPret.php';
    }

    public static function pageValidation() {
        include __DIR__ . '/../../views/pret/validationPret.php';
    }

    public static function listePret() {
        include __DIR__ . '/../../views/pret/listePret.php';
    }

    public static function validerPret($id) {
        $data = Flight::request()->data;

        Pret::validerPret($id, $data->id_utilisateur);

        $echeancier = Pret::rembourserPret($id);

        Flight::json([
            'message' => 'prêt validé et remboursement simulé',
            'echeancier' => $echeancier
        ]);
    }

    public static function rejeterPret($id) {
        $data = Flight::request()->data;
        Pret::rejeterPret($id, $data->id_utilisateur);
        Flight::json(['message' => 'Prêt rejeté']);
    }

    public static function getPretValide() {
        $prets = Pret::getAllPretsValides();
        Flight::json($prets);
    }

    public static function getAll() {
        $prets = Pret::getAll();
        Flight::json($prets);
    }

    public static function getAllNonTraite() {
        $prets = Pret::getAllPretNonTraite();
        Flight::json($prets);
    }

    public static function getById($id) {
        $pret = Pret::getById($id);
        Flight::json($pret);
    }

    public static function getDetails($id) {
        $pret = Pret::getByIdWithDetails($id);
        Flight::json($pret);
    }

    public static function pageDetails($id) {
        include __DIR__ . '/../../views/pret/detailsPret.php';
    }

    public static function create() {
        $data = Flight::request()->data;
        $id = Pret::create($data);
        
        Flight::json(['message' => 'Prêt ajouté', 'id' => $id]);
    }

    public static function generatePDF($id) {
        $pretDetails = Pret::getByIdWithDetails($id);
        
        if (!$pretDetails) {
            Flight::json(['error' => 'Prêt non trouvé'], 404);
            return;
        }
        
        // Préparer les données pour le PDF
        $pret = [
            'id' => $pretDetails['id'],
            'libelle' => $pretDetails['libelle'],
            'montant' => $pretDetails['montant'],
            'nombre_mensualite' => $pretDetails['nombre_mensualite'],
            'date' => $pretDetails['date']
        ];
        
        $client = [
            'nom' => $pretDetails['client_nom'],
            'prenom' => $pretDetails['client_prenom'],
            'email' => $pretDetails['client_email'],
            'telephone' => $pretDetails['client_telephone'],
            'adresse' => $pretDetails['client_adresse']
        ];
        
        $typePret = [
            'libelle' => $pretDetails['type_pret_libelle'],
            'taux_interet' => $pretDetails['taux_interet'],
            'description' => $pretDetails['type_pret_description']
        ];

        
$typePayement = [
    'libelle' => $pretDetails['type_payement_libelle'],
    'description' => $pretDetails['type_payement_description']
];

        
        
        // Créer le PDF
        $pdf = new PretPDF($pret, $client, $typePret,$typePayement);
        $pdf->generatePretDocument();
        
        // Générer le nom du fichier
        $filename = 'Contrat_Pret_' . str_pad($pret['id'], 6, '0', STR_PAD_LEFT) . '_' . date('Y-m-d') . '.pdf';
        
        // Envoyer le PDF au navigateur
        $pdf->Output('I', $filename);
    }

    public static function downloadPDF($id) {
        self::generatePDF($id);
    }

    public static function update($id) {
        $data = Flight::request()->data;
        Pret::update($id, $data);
        Flight::json(['message' => 'Prêt modifié']);
    }

    public static function delete($id) {
        Pret::delete($id);
        Flight::json(['message' => 'Prêt supprimé']);
    }

    // public static function simulationEcheancier($id) {
    //     $echeancier = Pret::rembourserPret($id);
    //     if (!$echeancier) {
    //         Flight::json(['error' => 'Prêt introuvable'], 404);
    //         return;
    //     }

    //     Flight::json([
    //         'pret_id' => $id,
    //         'echeancier' => $echeancier,
    //         'message' => "Échéancier généré"
    //     ]);
    // }
}
