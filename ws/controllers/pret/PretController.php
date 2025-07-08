<?php
require_once __DIR__ . '/../../models/pret/Pret.php';
require_once __DIR__ . '/../../models/paiement/Payement.php';
require_once __DIR__ . '/../../helpers/Utils.php';

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

    public static function simulationEcheancier($id) {
        $echeancier = Pret::rembourserPret($id);
        if (!$echeancier) {
            Flight::json(['error' => 'Prêt introuvable'], 404);
            return;
        }

        Flight::json([
            'pret_id' => $id,
            'echeancier' => $echeancier,
            'message' => "Échéancier généré"
        ]);
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

    public static function create() {
        $data = Flight::request()->data;
        $id = Pret::create($data);
        Flight::json(['message' => 'Prêt ajouté', 'id' => $id]);
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
}
