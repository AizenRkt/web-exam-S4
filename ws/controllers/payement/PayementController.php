<?php
require_once __DIR__ . '/../../models/payement/Payement.php';

class PayementController {
    public static function getAll() {
        $payements = Payement::getAll();
        Flight::json($payements);
    }

    public static function getById($id) {
        $payement = Payement::getById($id);
        Flight::json($payement);
    }

    public static function create() {
        $data = Flight::request()->data;
        $id = Payement::create($data);
        Flight::json(['message' => 'Paiement ajouté', 'id' => $id]);
    }

    public static function update($id) {
        $data = Flight::request()->data;
        Payement::update($id, $data);
        Flight::json(['message' => 'Paiement modifié']);
    }

    public static function delete($id) {
        Payement::delete($id);
        Flight::json(['message' => 'Paiement supprimé']);
    }
}
