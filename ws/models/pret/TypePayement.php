<?php
require_once __DIR__ . '/../../config/config.php';

class TypePayement {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query('SELECT id, libelle FROM type_payement');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 