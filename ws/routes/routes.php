<?php
require_once __DIR__ . '/../controllers/client/ClientController.php';
require_once __DIR__ . '/../routes/client_routes.php';
require_once __DIR__ . '/../routes/investissement_routes.php';

require_once __DIR__ . '/../routes/pret_routes.php';
require_once __DIR__ . '/../controllers/pret/TypePretController.php';
require_once __DIR__ . '/../controllers/pret/PretController.php';

//  Étudiant
Flight::route('GET /etudiants', ['EtudiantController', 'getAll']);
Flight::route('GET /etudiants/@id', ['EtudiantController', 'getOne']);
Flight::route('POST /etudiants', ['EtudiantController', 'create']);
Flight::route('PUT /etudiants/@id', ['EtudiantController', 'update']);
Flight::route('DELETE /etudiants/@id', ['EtudiantController', 'delete']);

// // Login
// Flight::route('GET /login', ['LoginController', 'afficher']);
// Flight::route('POST /login', ['LoginController', 'connecter']);


// Etablissement 
Flight::route('GET /etablissement', ['EtablissementController', 'afficher']);

//Investisseur
Flight::route('GET /investisseur', ['InvestisseurController', 'afficher']);

// Login
Flight::route('GET /login', ['LoginController', 'afficher']);
Flight::route('POST /login', ['LoginController', 'connecter']);

// type de prêt 
// Flight::route('GET /creationTypePret', ['TypePretController', 'creerTypePret']);

// Flight::route('GET /type-prets', ['TypePretController', 'getAll']);
// Flight::route('GET /type-prets/@id', ['TypePretController', 'getById']);
// Flight::route('POST /type-prets', ['TypePretController', 'create']);
// Flight::route('PUT /type-prets/@id', ['TypePretController', 'update']);
// Flight::route('DELETE /type-prets/@id', ['TypePretController', 'delete']);

// Flight::route('POST /prets', ['PretController', 'create']);
// Flight::route('GET /type-prets', ['TypePretController', 'getAll']);
// Flight::route('GET /demande-pret', ['PretController', 'formDemandePret']);