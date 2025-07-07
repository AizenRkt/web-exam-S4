<?php
require_once __DIR__ . '/../../models/investissement/Investissement.php';
require_once __DIR__ . '/../../models/client/Client.php';
require_once __DIR__ . '/../../models/investissement/TypeInvestissement.php';

class InvestissementController {
    public static function getAll() {
        try {
            $investissements = Investissement::getAll();
            Flight::json(['success' => true, 'data' => $investissements]);
        } catch (Exception $e) {
            Flight::json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public static function getById($id) {
        try {
            $investissement = Investissement::getById($id);
            if ($investissement) {
                Flight::json(['success' => true, 'data' => $investissement]);
            } else {
                Flight::json(['success' => false, 'message' => 'Investissement non trouvé'], 404);
            }
        } catch (Exception $e) {
            Flight::json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public static function addInvestissement() {
        try {
            $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
            if (strpos($contentType, 'application/json') !== false) {
                $data = json_decode(file_get_contents('php://input'));
            } else {
                $data = (object) [
                    'libelle' => $_POST['libelle'] ?? '',
                    'montant' => $_POST['montant'] ?? '',
                    'id_client' => $_POST['id_client'] ?? '',
                    'id_type_investissement' => $_POST['id_type_investissement'] ?? ''
                ];
            }
            $result = Investissement::createWithCompte($data);
            Flight::json([
                'success' => true,
                'message' => 'Investissement et compte ajoutés',
                'id_investissement' => $result['id_investissement'],
                'id_compte' => $result['id_compte']
            ]);
        } catch (Exception $e) {
            Flight::json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public static function update($id) {
        try {
            $json = file_get_contents('php://input');
            $data = json_decode($json);
            
            if (!$data) {
                throw new Exception('Données invalides');
            }

            Investissement::update($id, $data);
            Flight::json(['success' => true, 'message' => 'Investissement modifié']);
            
        } catch (Exception $e) {
            Flight::json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public static function delete($id) {
        try {
            Investissement::delete($id);
            Flight::json(['success' => true, 'message' => 'Investissement supprimé']);
        } catch (Exception $e) {
            Flight::json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    public static function showAddForm() {
        Flight::render('investissement/add.php');
    }

    public static function showList() {
        Flight::render('investissement/list.php');
    }
}