<?php
require_once __DIR__ . '/../controllers/auth/AuthController.php';

// type de pret
Flight::route('GET /login', ['AuthController', 'login']);
Flight::route('GET /signin', ['AuthController', 'signin']);