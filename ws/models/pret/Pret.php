<?php
require_once __DIR__ . '/../../db.php';

class Pret {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM pret");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM pret WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO pret (libelle, montant, id_type_pret, id_client, nombre_mensualite) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$data->libelle, $data->montant, $data->id_type_pret, $data->id_client, $data->nombre_mensualite]);
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE pret SET libelle = ?, montant = ?, id_type_pret = ?, id_client = ?, nombre_mensualite = ? WHERE id = ?");
        $stmt->execute([$data->libelle, $data->montant, $data->id_type_pret, $data->id_client, $data->nombre_mensualite, $id]);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM pret WHERE id = ?");
        $stmt->execute([$id]);
    }
}
