<?php
require_once __DIR__ . '/../../models/investissement/TypeInvestissement.php';
require_once __DIR__ . '/../../db.php';

class TypeInvestissementController {
    public static function getAll() {
        try {
            $types = TypeInvestissement::getAll();
            Flight::json(['success' => true, 'data' => $types]);
        } catch (Exception $e) {
            Flight::json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public static function getById($id) {
        try {
            $type = TypeInvestissement::getById($id);
            Flight::json(['success' => true, 'data' => $type]);
        } catch (Exception $e) {
            Flight::json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public static function add() {
        try {
            $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
            if (strpos($contentType, 'application/json') !== false) {
                $data = json_decode(file_get_contents('php://input'));
            } else {
                $data = (object) [
                    'libelle' => $_POST['libelle'] ?? '',
                    'taux_interet' => $_POST['taux_interet'] ?? '',
                    'description' => $_POST['description'] ?? ''
                ];
            }
            if (empty($data->libelle) || $data->taux_interet === '' || empty($data->description)) {
                throw new Exception('Tous les champs sont obligatoires');
            }
            $id = TypeInvestissement::create($data);
            Flight::json(['success' => true, 'message' => 'Type d\'investissement ajouté', 'id' => $id]);
        } catch (Exception $e) {
            Flight::json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public static function update($id) {
        try {
            $data = Flight::request()->data;
            TypeInvestissement::update($id, $data);
            Flight::json(['success' => true, 'message' => 'Type d\'investissement modifié']);
        } catch (Exception $e) {
            Flight::json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public static function delete($id) {
        try {
            TypeInvestissement::delete($id);
            Flight::json(['success' => true, 'message' => 'Type d\'investissement supprimé']);
        } catch (Exception $e) {
            Flight::json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public static function showAddForm() {
        Flight::render('investissement/type_add.php');
    }

} 