<?php
require_once __DIR__ . '/../../db.php';

class ValidationPret {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM validation_pret");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM validation_pret WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO validation_pret (id_pret, id_utilisateur, status) VALUES (?, ?, ?)");
        $stmt->execute([$data->id_pret, $data->id_utilisateur, $data->status]);
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE validation_pret SET id_pret = ?, id_utilisateur = ?, status = ? WHERE id = ?");
        $stmt->execute([$data->id_pret, $data->id_utilisateur, $data->status, $id]);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM validation_pret WHERE id = ?");
        $stmt->execute([$id]);
    }
}
