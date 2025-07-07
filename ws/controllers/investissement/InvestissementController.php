<?php
require_once __DIR__ . '/../../models/investissement/Investissement.php';
require_once __DIR__ . '/../../models/client/Client.php';
require_once __DIR__ . '/../../models/investissement/TypeInvestissement.php';

class InvestissementController {
    public static function getAll() {
        $investissements = Investissement::getAll();
        Flight::json($investissements);
    }

    public static function getById($id) {
        $investissement = Investissement::getById($id);
        Flight::json($investissement);
    }

    public static function addInvestissement() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = (object) [
                'libelle' => $_POST['libelle'],
                'montant' => $_POST['montant'],
                'id_client' => $_POST['id_client'],
                'id_type_investissement' => $_POST['id_type_investissement']
            ];
            $id = Investissement::create($data);
            Flight::json(['message' => 'Investissement ajouté', 'id' => $id]);
        }
    }

    public static function update($id) {
        $data = Flight::request()->data;
        Investissement::update($id, $data);
        Flight::json(['message' => 'Investissement modifié']);
    }

    public static function delete($id) {
        Investissement::delete($id);
        Flight::json(['message' => 'Investissement supprimé']);
    }

    public static function getFormData() {
        $clients = Client::getAll();
        $types = TypeInvestissement::getAll();
        Flight::json(['clients' => $clients, 'types' => $types]);
    }
} 