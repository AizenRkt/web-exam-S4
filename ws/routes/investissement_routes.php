<?php
require_once __DIR__ . '/../controllers/investissement/InvestissementController.php';
require_once __DIR__ . '/../controllers/investissement/TypeInvestissementController.php';

// Investissement CRUD
Flight::route('GET /investissements', ['InvestissementController', 'getAll']);
Flight::route('GET /investissements/@id', ['InvestissementController', 'getById']);
Flight::route('POST /investissements', ['InvestissementController', 'addInvestissement']);
Flight::route('PUT /investissements/@id', ['InvestissementController', 'update']);
Flight::route('DELETE /investissements/@id', ['InvestissementController', 'delete']);
Flight::route('GET /investissement/add', ['InvestissementController', 'showAddForm']);
Flight::route('GET /investissement/list', ['InvestissementController', 'showList']);

// TypeInvestissement CRUD
Flight::route('GET /typeinvestissements', ['TypeInvestissementController', 'getAll']);
Flight::route('GET /typeinvestissements/@id', ['TypeInvestissementController', 'getById']);
Flight::route('POST /typeinvestissements', ['TypeInvestissementController', 'add']);
Flight::route('PUT /typeinvestissements/@id', ['TypeInvestissementController', 'update']);
Flight::route('DELETE /typeinvestissements/@id', ['TypeInvestissementController', 'delete']);
// Vues
Flight::route('GET /typeinvestissement/add', ['TypeInvestissementController', 'showAddForm']);