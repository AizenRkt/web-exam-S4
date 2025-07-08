<?php
require_once __DIR__ . '/../../db.php';
require_once 'TypePret.php';
class Pret {

    public static function getDateValidation($id_pret) {
        $db = getDB();
        $stmt = $db->prepare("SELECT date FROM validation_pret WHERE id_pret = ? AND status = true ORDER BY date DESC LIMIT 1");
        $stmt->execute([$id_pret]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ? $res['date'] : null;
    }

    public static function getDelaiRemboursement($id_pret) {
        $db = getDB();
        $stmt = $db->prepare("SELECT delai_remboursement FROM pret WHERE id = ?");
        $stmt->execute([$id_pret]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ? $res['delai_remboursement'] : null;
    }

    public static function rembourserMois($id_pret, $mois, $date_echeance) {
        $pret = self::getById($id_pret);
        if (!$pret) return null;

        $montant = $pret['montant'];
        $taux_annuel = TypePret::getTauxInteret($pret['id_type_pret']);
        $taux_mensuel = $taux_annuel / 12 / 100;
        $n = $pret['nombre_mensualite'];

        $annuite = ($montant * $taux_mensuel) / (1 - pow(1 + $taux_mensuel, -$n));

        try {
            Payement::create((object)[
                    'id_pret' => $id_pret,
                    'id_type_payement' => 1,
                    'montant' => round($annuite, 2),
                    'date' => $date_echeance
                ]);
        } catch (Exception $e) {
            error_log("Erreur création payement : " . $e->getMessage());
            Flight::halt(500, 'Erreur lors de la création du paiement.');
        }

        return [
            'mois' => $mois,
            'montant' => round($annuite, 2),
            'date_echeance' => $date_echeance
        ];
    }

    public static function rembourserPret($id_pret) {
        $pret = self::getById($id_pret);
        if (!$pret) return null;

        $n = $pret['nombre_mensualite'];
        $validationDate = self::getDateValidation($id_pret);
        if (!$validationDate) return null;

        $delaiRemboursement = self::getDelaiRemboursement($id_pret);
        if (!$delaiRemboursement) return null;

        $start = (new DateTime($validationDate))->modify("+$delaiRemboursement month");

        $echeancier = [];

        for ($i = 0; $i < $n; $i++) {
            $date = (clone $start)->modify("+$i month")->format('Y-m-d');
            $echeancier[] = self::rembourserMois($id_pret, $i + 1, $date);
        }

        return $echeancier;
    }

    // public static function rembourserPret($id_pret, $delai) {
    //     $pret = self::getById($id_pret);
    //     if (!$pret) return null;

    //     $n = $pret['nombre_mensualite'];
    //     $validationDate = self::getDateValidation($id_pret);
    //     if (!$validationDate) return null;

    //     // $delaiRemboursement = self::getDelaiRemboursement($id_pret);
    //     // if (!$delaiRemboursement) return null;

    //     $start = (new DateTime($validationDate));
    //     // ->modify("+$delaiRemboursement month");

    //     $echeancier = [];

    //     for ($i = 0; $i < $n; $i++) {
    //         $date = (clone $start)->modify("+$i month")->format('Y-m-d');
    //         $echeancier[] = self::rembourserMois($id_pret, $i + 1, $date);
    //     }

    //     return $echeancier;
    // }

    // public static function rembourserPret($id_pret, $delai) { 
    //     $pret = self::getById($id_pret);
    //     if (!$pret) return null;

    //     $n = $pret['nombre_mensualite'];
    //     $validationDate = self::getDateValidation($id_pret);
    //     if (!$validationDate) return null;

    //     $start = new DateTime($validationDate);
    //     $start->modify("+$delai month");

    //     $echeancier = [];

    //     for ($i = 0; $i < $n; $i++) {
    //         $date = (clone $start)->modify("+$i month")->format('Y-m-d');
    //         $echeancier[] = self::rembourserMois($id_pret, $i + 1, $date);
    //     }

    //     return $echeancier;
    // }


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

    public static function getAllPretNonTraite() {
        $db = getDB();
        $stmt = $db->query("
            SELECT p.* 
            FROM pret p
            LEFT JOIN validation_pret vp ON p.id = vp.id_pret
            WHERE vp.id_pret IS NULL
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    public static function getByIdWithDetails($id) {
        $db = getDB();
        $stmt = $db->prepare("
            SELECT p.*, c.nom as client_nom, c.prenom as client_prenom, c.email as client_email, 
                   c.telephone as client_telephone, c.adresse as client_adresse,
                   tp.libelle as type_pret_libelle, tp.taux_interet, tp.description as type_pret_description
            FROM pret p
            JOIN client c ON p.id_client = c.id
            JOIN type_pret tp ON p.id_type_pret = tp.id
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO pret (libelle, montant, id_type_pret, id_client, nombre_mensualite, delai_remboursement) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$data->libelle, $data->montant, $data->id_type_pret, $data->id_client, $data->nombre_mensualite, $data->delai_remboursement]);
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
