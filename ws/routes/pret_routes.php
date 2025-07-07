<?php
require_once __DIR__ . '/../controllers/pret/TypePretController.php';
require_once __DIR__ . '/../controllers/pret/PretController.php';

// type de pret
Flight::route('GET /type-prets', ['TypePretController', 'getAll']);
Flight::route('GET /type-prets/@id', ['TypePretController', 'getById']);
Flight::route('POST /type-prets', ['TypePretController', 'create']);
Flight::route('PUT /type-prets/@id', ['TypePretController', 'update']);
Flight::route('DELETE /type-prets/@id', ['TypePretController', 'delete']);

// pret 
Flight::route('POST /prets', ['PretController', 'create']);
Flight::route('POST /prets/@id/valider', ['PretController', 'validerPret']);
Flight::route('POST /prets/@id/rejeter', ['PretController', 'rejeterPret']);

// page
Flight::route('GET /prets/validation', ['PretController', 'pageValidation']);
Flight::route('GET /creationTypePret', ['TypePretController', 'creerTypePret']);
Flight::route('GET /demande-pret', ['PretController', 'formDemandePret']);