<?php
require_once __DIR__ . '/../../db.php';

class TypeInvestissement {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM type_investissement");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 