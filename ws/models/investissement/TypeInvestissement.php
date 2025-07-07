<?php
require_once __DIR__ . '/../../db.php';

class TypeInvestissement {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM type_investissement");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM type_investissement WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO type_investissement (libelle, taux_interet, description) VALUES (?, ?, ?)");
        $stmt->execute([$data->libelle, $data->taux_interet, $data->description]);
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE type_investissement SET libelle = ?, taux_interet = ?, description = ? WHERE id = ?");
        $stmt->execute([$data->libelle, $data->taux_interet, $data->description, $id]);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM type_investissement WHERE id = ?");
        $stmt->execute([$id]);
    }
} 