<?php
require_once __DIR__ . '/../../db.php';

class Client {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM client");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM client WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO client (id_type_client, nom, prenom, email, telephone, adresse) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$data->id_type_client, $data->nom, $data->prenom, $data->email, $data->telephone, $data->adresse]);
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE client SET id_type_client = ?, nom = ?, prenom = ?, email = ?, telephone = ?, adresse = ? WHERE id = ?");
        $stmt->execute([$data->id_type_client, $data->nom, $data->prenom, $data->email, $data->telephone, $data->adresse, $id]);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM client WHERE id = ?");
        $stmt->execute([$id]);
    }
} 