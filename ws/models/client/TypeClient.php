<?php
require_once __DIR__ . '/../../db.php';

class TypeClient {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM type_client");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO type_client (libelle, description) VALUES (?, ?)");
        $stmt->execute([$data->libelle, $data->description]);
        return $db->lastInsertId();
    }
} 