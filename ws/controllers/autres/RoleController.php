<?php

class RoleController {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM role");
        $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        Flight::json($roles);
    }
} 