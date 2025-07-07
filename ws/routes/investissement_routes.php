<?php
require_once __DIR__ . '/../controllers/investissement/InvestissementController.php';

// Investissement CRUD
Flight::route('GET /investissements', ['InvestissementController', 'getAll']);
Flight::route('GET /investissements/@id', ['InvestissementController', 'getById']);
Flight::route('POST /investissements', ['InvestissementController', 'addInvestissement']);
Flight::route('PUT /investissements/@id', ['InvestissementController', 'update']);
Flight::route('DELETE /investissements/@id', ['InvestissementController', 'delete']);
Flight::route('GET /investissement/formdata', ['InvestissementController', 'getFormData']); 