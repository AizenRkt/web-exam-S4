<?php
require_once __DIR__ . '/../../../ws/db.php';

class Role {

    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM role");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
