<?php
require_once __DIR__ . '/../../models/client/Client.php';
require_once __DIR__ . '/../../models/client/TypeClient.php';
require_once __DIR__ . '/../../db.php';

class ClientController {
    public static function getAll() {
        $clients = Client::getAll();
        Flight::json($clients);
    }

    public static function getById($id) {
        $client = Client::getById($id);
        Flight::json($client);
    }

    public static function addClient() {
        $data = Flight::request()->data;
        $id = Client::create($data);
        Flight::json(['message' => 'Client ajouté', 'id' => $id]);
    }

    public static function update($id) {
        $data = Flight::request()->data;
        Client::update($id, $data);
        Flight::json(['message' => 'Client modifié']);
    }

    public static function delete($id) {
        Client::delete($id);
        Flight::json(['message' => 'Client supprimé']);
    }

    public static function getTypeClient() {
        $types = TypeClient::getAll();
        Flight::json($types);
    }

    public static function showAddForm() {
        Flight::render('client/add.php');
    }

    public static function showList() {
        include __DIR__ . '/../../views/client/list.php';
    }
} 