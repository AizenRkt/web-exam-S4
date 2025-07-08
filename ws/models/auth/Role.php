<?php
require_once __DIR__ . '/../../db.php';

class Role {

    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM role");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
     // Récupère un rôle par son ID
     public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM role WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
