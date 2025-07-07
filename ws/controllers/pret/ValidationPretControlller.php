<?php
require_once __DIR__ . '/../../models/pret/ValidationPret.php';
require_once __DIR__ . '/../../helpers/Utils.php';

class ValidationPretController {
    public static function getAll() {
        $validations = ValidationPret::getAll();
        Flight::json($validations);
    }

    public static function getById($id) {
        $validation = ValidationPret::getById($id);
        Flight::json($validation);
    }

    public static function create() {
        $data = Flight::request()->data;
        $id = ValidationPret::create($data);
        Flight::json(['message' => 'Validation ajoutée', 'id' => $id]);
    }

    public static function update($id) {
        $data = Flight::request()->data;
        ValidationPret::update($id, $data);
        Flight::json(['message' => 'Validation modifiée']);
    }

    public static function delete($id) {
        ValidationPret::delete($id);
        Flight::json(['message' => 'Validation supprimée']);
    }
}
