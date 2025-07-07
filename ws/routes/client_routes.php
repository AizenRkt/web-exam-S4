<?php
require_once __DIR__ . '/../controllers/client/ClientController.php';
require_once __DIR__ . '/../controllers/client/TypeClientController.php';

// Vues
Flight::route('GET /typeclients/add', ['TypeClientController', 'showAddForm']);
Flight::route('GET /client/add', ['ClientController', 'showAddForm']);
Flight::route('GET /client/list', ['ClientController', 'showList']);

// Endpoints AJAX CRUD Client
Flight::route('GET /clients', ['ClientController', 'getAll']);
Flight::route('GET /clients/@id', ['ClientController', 'getById']);
Flight::route('POST /clients', ['ClientController', 'addClient']);
Flight::route('PUT /clients/@id', ['ClientController', 'update']);
Flight::route('DELETE /clients/@id', ['ClientController', 'delete']);
Flight::route('GET /client/typeclient', ['ClientController', 'getTypeClient']);

// Endpoints AJAX CRUD TypeClient
Flight::route('GET /typeclients', ['TypeClientController', 'getAll']);
Flight::route('GET /typeclients/@id', ['TypeClientController', 'getById']);
Flight::route('POST /typeclients', ['TypeClientController', 'addTypeClient']);
Flight::route('PUT /typeclients/@id', ['TypeClientController', 'update']);
Flight::route('DELETE /typeclients/@id', ['TypeClientController', 'delete']); 