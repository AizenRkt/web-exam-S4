<?php
require_once __DIR__ . '/../controllers/interet/InteretController.php';

Flight::route('GET /interets', ['InteretController', 'showView']);
Flight::route('GET /ws/interets', ['InteretController', 'getInterets']);
