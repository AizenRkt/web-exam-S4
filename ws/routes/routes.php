<?php
require_once __DIR__ . '/../controllers/autres/UtilisateurController.php';
require_once __DIR__ . '/../routes/client_routes.php';
require_once __DIR__ . '/../routes/investissement_routes.php';
require_once __DIR__ . '/../controllers/autres/RoleController.php';

// //  Étudiant

// // Login
Flight::route('GET /', ['UtilisateurController', 'afficher_log']);
Flight::route('POST /connexion', ['UtilisateurController', 'connecter']);
Flight::route('GET /inscription', ['UtilisateurController', 'afficher_sign']);
Flight::route('POST /inscription', ['UtilisateurController', 'inscrire']);
Flight::route('GET /acceuil', ['UtilisateurController', 'affiche_acceuil']);


Flight::route('GET /roles', ['RoleController', 'getAll']);
// // Après connexion
