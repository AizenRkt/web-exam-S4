<?php
require_once __DIR__ . '/../../db.php';

class TypePret {

    public static function getTauxInteret($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT taux_interet FROM type_pret WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? (float) $result['taux_interet'] : null;
    }

    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM type_pret");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM type_pret WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO type_pret (libelle, taux_interet,taux_assurance, description) VALUES (?, ?, ?, ?)");
        $stmt->execute([$data->libelle, $data->taux_interet,$data->taux_assurance, $data->description]);
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE type_pret SET libelle = ?, taux_interet = ?,taux_assurance=?, description = ? WHERE id = ?");
        $stmt->execute([$data->libelle, $data->taux_interet, $data->taux_assurance, $data->description, $id]);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM type_pret WHERE id = ?");
        $stmt->execute([$id]);
    }
}
