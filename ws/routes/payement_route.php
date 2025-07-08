<?php
require_once __DIR__ . '/../controllers/pret/TypePayementController.php';

Flight::route('GET /typepayements', ['TypePayementController', 'getAll']); 