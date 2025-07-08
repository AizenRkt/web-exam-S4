<?php
require_once __DIR__ . '/../../db.php';

class TypePayement {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM type_payement");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM type_payement WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO type_payement (libelle, description) VALUES (?, ?)");
        $stmt->execute([$data->libelle, $data->description]);
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE type_payement SET libelle = ?, description = ? WHERE id = ?");
        $stmt->execute([$data->libelle, $data->description, $id]);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM type_payement WHERE id = ?");
        $stmt->execute([$id]);
    }
}

class Payement {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM payement");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM payement WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO payement (id_pret, id_type_payement, montant) VALUES (?, ?, ?)");
        $stmt->execute([$data->id_pret, $data->id_type_payement, $data->montant]);
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE payement SET id_pret = ?, id_type_payement = ?, montant = ? WHERE id = ?");
        $stmt->execute([$data->id_pret, $data->id_type_payement, $data->montant, $id]);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM payement WHERE id = ?");
        $stmt->execute([$id]);
    }
}
