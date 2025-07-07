<?php
require_once __DIR__ . '/../db.php';

class Utilisateur {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM utilisateur");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM utilisateur WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, telephone, adresse, id_role) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$data->nom, $data->prenom, $data->email, $data->mot_de_passe, $data->telephone, $data->adresse, $data->id_role]);
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE utilisateur SET nom = ?, prenom = ?, email = ?, mot_de_passe = ?, telephone = ?, adresse = ?, id_role = ? WHERE id = ?");
        $stmt->execute([$data->nom, $data->prenom, $data->email, $data->mot_de_passe, $data->telephone, $data->adresse, $data->id_role, $id]);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM utilisateur WHERE id = ?");
        $stmt->execute([$id]);
    }
} 