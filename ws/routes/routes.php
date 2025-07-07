<?php
require_once __DIR__ . '/../controllers/EtudiantController.php';
require_once __DIR__ . '/../controllers/other/HelloController.php';
require_once __DIR__ . '/../controllers/other/LoginController.php';
require_once __DIR__ . '/../controllers/client/ClientController.php';
require_once __DIR__ . '/../controllers/etablissement/EtablissementController.php';
require_once __DIR__ . '/../controllers/investisseur/InvestisseurController.php';

require_once __DIR__ . '/../controllers/pret/TypePretController.php';
//  Étudiant
Flight::route('GET /etudiants', ['EtudiantController', 'getAll']);
Flight::route('GET /etudiants/@id', ['EtudiantController', 'getOne']);
Flight::route('POST /etudiants', ['EtudiantController', 'create']);
Flight::route('PUT /etudiants/@id', ['EtudiantController', 'update']);
Flight::route('DELETE /etudiants/@id', ['EtudiantController', 'delete']);

//  Hello
Flight::route('GET /hello', ['HelloController', 'afficher']);

//  Client 
Flight::route('GET /client', ['ClientController', 'afficher']);
Flight::route('GET /create', ['ClientController', 'create']);
Flight::route('POST /client/create', ['ClientController', 'store']);


// Etablissement 
Flight::route('GET /etablissement', ['EtablissementController', 'afficher']);

//Investisseur
Flight::route('GET /investisseur', ['InvestisseurController', 'afficher']);

// Login
Flight::route('GET /login', ['LoginController', 'afficher']);
Flight::route('POST /login', ['LoginController', 'connecter']);

// type de prêt 
Flight::route('GET /creationTypePret', ['TypePretController', 'creerTypePret']);

Flight::route('GET /type-prets', ['TypePretController', 'getAll']);
Flight::route('GET /type-prets/@id', ['TypePretController', 'getById']);
Flight::route('POST /type-prets', ['TypePretController', 'create']);
Flight::route('PUT /type-prets/@id', ['TypePretController', 'update']);
Flight::route('DELETE /type-prets/@id', ['TypePretController', 'delete']);
