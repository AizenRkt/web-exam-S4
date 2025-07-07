<?php
require_once __DIR__ . '/../controllers/CompteController.php';

// Endpoints API AJAX CRUD
Flight::route('GET /comptes', ['CompteController', 'getAll']);
Flight::route('GET /comptes/@id', ['CompteController', 'getById']);
Flight::route('POST /comptes', ['CompteController', 'add']);
Flight::route('PUT /comptes/@id', ['CompteController', 'update']);
Flight::route('DELETE /comptes/@id', ['CompteController', 'delete']);