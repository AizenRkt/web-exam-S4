<?php
require_once __DIR__ . '/../../models/other/User.php';

class LoginController {

    // Affiche le formulaire de login
    public static function afficher_log() {
        include __DIR__ . '/../../views/other/login.php';
    }

    public static function afficher_sign() {
        include __DIR__ . '/../../views/other/signin.php';
    }

    // Traite la soumission du formulaire
    public static function connecter() {
        try {
            $data = json_decode(Flight::request()->getBody(), true);
    
            $email = trim($data['email'] ?? '');
            $mot_de_passe = $data['mot_de_passe'] ?? '';
            $role = $data['role'] ?? '';
    
            $user = User::verifierConnexion($email, $mot_de_passe, $role);
    
            if ($user) {
                session_start();
                $_SESSION['user'] = $user;
    
                $redirect = ($role === 'dg') ? BASE_URL . "/directeur/dashboard" : BASE_URL . "/employe/dashboard";
    
                Flight::json([
                    'success' => true,
                    'message' => 'Connexion réussie',
                    'redirect' => $redirect
                ]);
            } else {
                Flight::json([
                    'success' => false,
                    'message' => 'Identifiants incorrects'
                ]);
            }
        } catch (Exception $e) {
            Flight::json([
                'success' => false,
                'message' => 'Erreur : ' . $e->getMessage()
            ], 500);
        }
    }    
    
    public static function inscrire() {
        $data = json_decode(Flight::request()->getBody());

        if (!$data) {
            Flight::json(['success' => false, 'message' => 'Données invalides']);
            return;
        }
        try {
            $id = User::create($data);
            Flight::json(['success' => true, 'id' => $id]);
        } catch (PDOException $e) {
            Flight::json(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()]);
        }
    }
}
