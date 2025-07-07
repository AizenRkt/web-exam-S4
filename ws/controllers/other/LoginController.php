<?php
require_once __DIR__ . '/../../models/other/User.php';

class LoginController {
    
    public static function afficher() {
        include __DIR__ . '/../../views/other/login.php';
    }

    public static function connecter() {
        $prenom = Flight::request()->data->prenom;
        $pwd = Flight::request()->data->pwd;

        $user = User::verifierConnexion($prenom, $pwd);

        if ($user) {
            session_start();
            $_SESSION['user'] = $user;

            // Redirection en fonction du prénom (rôle)
            switch ($user['prenom']) {
                case 'Investisseur':
                    Flight::redirect('/investisseur');
                    break;
                case 'Etablissement':
                    Flight::redirect('/etablissement');
                    break;
                case 'Client':
                    Flight::redirect('/client');
                    break;
                default:
                    // Si rôle non reconnu, renvoyer vers login
                    Flight::redirect('/login');
                    break;
            }
        } else {
            Flight::redirect('/login');
        }
    }
}
