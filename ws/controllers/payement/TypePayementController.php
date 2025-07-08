<?php
require_once __DIR__ . '/../../models/payement/TypePayement.php';

class TypePayementController {
    public static function getAll() {
        $types = TypePayement::getAll();
        Flight::json($types);
    }

    public static function getById($id) {
        $type = TypePayement::getById($id);
        Flight::json($type);
    }

    public static function create() {
        $data = Flight::request()->data;
        $id = TypePayement::create($data);
        Flight::json(['message' => 'Type de paiement ajouté', 'id' => $id]);
    }

    public static function update($id) {
        $data = Flight::request()->data;
        TypePayement::update($id, $data);
        Flight::json(['message' => 'Type de paiement modifié']);
    }

    public static function delete($id) {
        TypePayement::delete($id);
        Flight::json(['message' => 'Type de paiement supprimé']);
    }
}
