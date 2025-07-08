<?php
require_once __DIR__ . '/../../models/compte/Compte.php';
require_once __DIR__ . '/../../db.php';

class CompteController {
    public static function getAll() {
        try {
            $comptes = Compte::getAll();
            Flight::json(['success' => true, 'data' => $comptes]);
        } catch (Exception $e) {
            Flight::json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public static function getById($id) {
        try {
            $compte = Compte::getById($id);
            Flight::json(['success' => true, 'data' => $compte]);
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
                    'solde' => $_POST['solde'] ?? 0
                ];
            }
            if (!isset($data->solde)) {
                throw new Exception('Le solde est obligatoire');
            }
            $id = Compte::create($data);
            Flight::json(['success' => true, 'message' => 'Compte ajouté', 'id' => $id]);
        } catch (Exception $e) {
            Flight::json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public static function update($id) {
        try {
            $data = Flight::request()->data;
            Compte::update($id, $data);
            Flight::json(['success' => true, 'message' => 'Compte modifié']);
        } catch (Exception $e) {
            Flight::json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public static function delete($id) {
        try {
            Compte::delete($id);
            Flight::json(['success' => true, 'message' => 'Compte supprimé']);
        } catch (Exception $e) {
            Flight::json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public static function showAddForm() {
        Flight::render('compte/add.php');
    }
    public static function showList() {
        Flight::render('compte/list.php');
    }
    
} 