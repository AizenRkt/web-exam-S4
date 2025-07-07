<?php
require_once __DIR__ . '/../../db.php';

class Investissement {
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM investissement");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM investissement WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO investissement (libelle, montant, id_client, id_type_investissement) VALUES (?, ?, ?, ?)");
        $stmt->execute([$data->libelle, $data->montant, $data->id_client, $data->id_type_investissement]);
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE investissement SET libelle = ?, montant = ?, id_client = ?, id_type_investissement = ? WHERE id = ?");
        $stmt->execute([$data->libelle, $data->montant, $data->id_client, $data->id_type_investissement, $id]);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM investissement WHERE id = ?");
        $stmt->execute([$id]);
    }

    public static function createWithCompte($data) {
        $db = getDB();
        try {
            $db->beginTransaction();
    
            // 1. Ajouter le compte
            $stmtCompte = $db->prepare("INSERT INTO compte (solde) VALUES (?)");
            $stmtCompte->execute([$data->montant]);
            $id_compte = $db->lastInsertId();
    
            // 2. Ajouter l'investissement (tu peux stocker l'id_compte si tu veux le lier)
            $stmtInv = $db->prepare("INSERT INTO investissement (libelle, montant, id_client, id_type_investissement) VALUES (?, ?, ?, ?)");
            $stmtInv->execute([
                $data->libelle,
                $data->montant,
                $data->id_client,
                $data->id_type_investissement
            ]);
            $id_investissement = $db->lastInsertId();
    
            $db->commit();
            return [
                'id_investissement' => $id_investissement,
                'id_compte' => $id_compte
            ];
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }
} 