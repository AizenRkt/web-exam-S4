<?php
require_once __DIR__ . '/../../db.php';

class Pret {
    public static function validerPret($id_pret, $id_utilisateur) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO validation_pret (id_pret, id_utilisateur, status) VALUES (?, ?, true)");
        $stmt->execute([$id_pret, $id_utilisateur]);
    }

    public static function rejeterPret($id_pret, $id_utilisateur) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO validation_pret (id_pret, id_utilisateur, status) VALUES (?, ?, false)");
        $stmt->execute([$id_pret, $id_utilisateur]);
    }

    public static function isPretValide($id_pret) {
        $db = getDB();
        $stmt = $db->prepare("SELECT status FROM validation_pret WHERE id_pret = ? ORDER BY date DESC LIMIT 1");
        $stmt->execute([$id_pret]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result && $result['status'] === '1';
    }

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
