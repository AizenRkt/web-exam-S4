<?php
require_once __DIR__ . '/../../db.php';

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
        try {
            // Démarrer la transaction
            $db->beginTransaction();
    
            // Vérification des champs requis
            $requiredFields = ['id_pret', 'id_type_payement', 'montant'];
            $missingFields = [];
    
            foreach ($requiredFields as $field) {
                if (!isset($data->$field)) {
                    $missingFields[] = $field;
                }
            }
    
            if (!empty($missingFields)) {
                throw new Exception("Champs requis manquants : " . implode(', ', $missingFields));
            }
    
            // Insertion dans payement
            if (isset($data->date)) {
                $stmt = $db->prepare("INSERT INTO payement (id_pret, id_type_payement, montant, date) VALUES (?, ?, ?, ?)");
                $stmt->execute([$data->id_pret, $data->id_type_payement, $data->montant, $data->date]);
            } else {
                $stmt = $db->prepare("INSERT INTO payement (id_pret, id_type_payement, montant) VALUES (?, ?, ?)");
                $stmt->execute([$data->id_pret, $data->id_type_payement, $data->montant]);
            }
    
            // Insertion dans compte via méthode existante
            Compte::create((object)[
                'solde' => $data->montant,
                'date' => $data->date ?? null
            ], $db); // <-- On passe la même connexion
    
            // Commit des deux opérations
            $db->commit();
    
            return $db->lastInsertId(); // retourne l'ID de la dernière insertion (payement ici)
    
        } catch (Exception $e) {
            $db->rollBack();
            error_log("Erreur création paiement ou compte : " . $e->getMessage());
            throw new Exception("Échec de la transaction : " . $e->getMessage());
        }
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
