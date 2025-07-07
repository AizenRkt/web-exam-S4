<?php
require_once __DIR__ . '/../../models/client/TypeClient.php';
require_once __DIR__ . '/../../db.php';

class TypeClientController {
    public static function getAll() {
        try {
            $types = TypeClient::getAll();
            Flight::json(['success' => true, 'data' => $types]);
        } catch (Exception $e) {
            Flight::json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public static function getById($id) {
        try {
            $type = TypeClient::getById($id);
            Flight::json(['success' => true, 'data' => $type]);
        } catch (Exception $e) {
            Flight::json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public static function addTypeClient() {
        try {
            $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
            if (strpos($contentType, 'application/json') !== false) {
                $data = json_decode(file_get_contents('php://input'));
            } else {
                $data = (object) [
                    'libelle' => $_POST['libelle'] ?? '',
                    'description' => $_POST['description'] ?? ''
                ];
            }
            if (empty($data->libelle) || empty($data->description)) {
                throw new Exception('Libellé et description obligatoires');
            }
            $id = TypeClient::create($data);
            Flight::json(['success' => true, 'message' => 'Type client ajouté', 'id' => $id]);
        } catch (Exception $e) {
            Flight::json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public static function update($id) {
        try {
            $data = Flight::request()->data;
            TypeClient::update($id, $data);
            Flight::json(['success' => true, 'message' => 'Type client modifié']);
        } catch (Exception $e) {
            Flight::json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public static function delete($id) {
        try {
            TypeClient::delete($id);
            Flight::json(['success' => true, 'message' => 'Type client supprimé']);
        } catch (Exception $e) {
            Flight::json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public static function showAddForm() {
        include __DIR__ . '/../../views/client/typeclient_add.php';
    }
} 