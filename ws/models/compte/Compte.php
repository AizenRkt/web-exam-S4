<?php
require_once __DIR__ . '../../db.php';

class Compte {
    public static function getSoldeActuel() {
        $db = getDB();

        $stmt = $db->prepare("SELECT solde FROM compte ORDER BY date DESC LIMIT 1");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result['solde'];
        } else {
            return 0;
        }
    }

    public static function calculerPayementsRecus() {
        $db = getDB();
        $stmt = $db->query("SELECT SUM(montant) AS total FROM payement");
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res['total'] ?? 0;
    }

    public static function calculerPretsValides() {
        $db = getDB();
        $stmt = $db->query("
            SELECT SUM(p.montant) AS total 
            FROM pret p
            JOIN (
                SELECT id_pret
                FROM validation_pret
                WHERE status = true
                GROUP BY id_pret
                HAVING MAX(date)
            ) v ON p.id = v.id_pret
        ");
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res['total'] ?? 0;
    }

    public static function calculerInvestissements() {
        $db = getDB();
        $stmt = $db->query("SELECT SUM(montant) AS total FROM investissement");
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res['total'] ?? 0;
    }

    public static function calculerSolde() {
        $investissements = self::calculerInvestissements();
        $prets = self::calculerPretsValides();
        $remboursements = self::calculerPayementsRecus();

        return $investissements - $prets + $remboursements;
    }

    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM compte");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM compte WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO compte (solde) VALUES (?)");
        $stmt->execute([$data->solde]);
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE compte SET solde = ? WHERE id = ?");
        $stmt->execute([$data->solde, $id]);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM compte WHERE id = ?");
        $stmt->execute([$id]);
    }
} 