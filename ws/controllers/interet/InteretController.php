<?php
require_once __DIR__ . '/../../db.php';

class InteretController {
    public static function getInterets() {
        $db = getDB();

        $debut = $_GET['debut'] ?? null;
        $fin = $_GET['fin'] ?? null;

        $where = "";
        $params = [];

        if ($debut && $fin) {
            $where = "WHERE i.date BETWEEN ? AND ?";
            $params = [$debut, $fin];
        }

        $sql = "
            SELECT 
                DATE_FORMAT(i.date, '%Y-%m') AS mois_annee,
                SUM(i.montant * ti.taux_interet / 100) AS total_interet
            FROM investissement i
            JOIN type_investissement ti ON i.id_type_investissement = ti.id
            $where
            GROUP BY mois_annee
            ORDER BY mois_annee ASC
        ";

        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        Flight::json($result);
    }

    public static function showView() {
        Flight::render('interet/interet');
    }
}
