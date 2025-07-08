<?php
require_once __DIR__ . '/../../models/pret/TypePayement.php';

class TypePayementController {
    public static function getAll() {
        $types = TypePayement::getAll();
        Flight::json($types);
    }
} 