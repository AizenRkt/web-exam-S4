<?php
require_once __DIR__ . '/../../models/auth/Utilisateur.php';
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../models/auth/Role.php';

class UtilisateurController {
    // Affiche le formulaire de login
    public static function afficher_log() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        include __DIR__ . '/../../views/template/auth/connexion.php';
    }

    public static function afficher_sign() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        include __DIR__ . '/../../views/template/auth/inscription.php';
    }

    public static function affiche_acceuil() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        Flight::redirect('/demande-pret');
    }

    public static function connecter() {
        try {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $data = json_decode(Flight::request()->getBody(), true);
            
            if (!$data) {
                throw new Exception('Données invalides');
            }

            $email = trim($data['email'] ?? '');
            $mot_de_passe = $data['mot_de_passe'] ?? '';

            if (empty($email)) {
                throw new Exception('L\'email est requis');
            }
            if (empty($mot_de_passe)) {
                throw new Exception('Le mot de passe est requis');
            }

            $utilisateur = Utilisateur::verifierConnexion($email, $mot_de_passe);

            if ($utilisateur) {
                $_SESSION['utilisateur'] = [
                    'id' => $utilisateur['id'],
                    'nom' => $utilisateur['nom'],
                    'role' => $utilisateur['role'],
                    'email' => $utilisateur['email'],
                    'prenom' => $utilisateur['prenom'],
                    'telephone' => $utilisateur['telephone'],
                    'autorisation' => $utilisateur['autorisation']
                ];

                Flight::json([
                    'success' => true,
                    'message' => 'Connexion réussie',
                    'redirect' => defined('BASE_URL') ? BASE_URL . '/acceuil' : '/acceuil'
                ]);
            } else {
                Flight::json([
                    'success' => false,
                    'message' => 'Email ou mot de passe incorrect'
                ], 401);
            }
        } catch (Exception $e) {
            Flight::json([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ], 500);
        }
    }

    public static function inscrire() {
        try {
            $data = json_decode(Flight::request()->getBody(), true);
            
            if (!$data) {
                throw new Exception('Données invalides');
            }

            $id = Utilisateur::create($data);
            $utilisateur = Utilisateur::getById($id);
            
            if ($utilisateur) {
                $role = null;
                $role = Role::getById($utilisateur['id_role']);
                if ($role) {
                    $utilisateur['role'] = $role['libelle'];
                    $utilisateur['autorisation'] = $role['autorisation'];
                }
                
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                
                $_SESSION['utilisateur'] = [
                    'id' => $utilisateur['id'],
                    'nom' => $utilisateur['nom'],
                    'role' => $utilisateur['role'],
                    'autorisation' => $utilisateur['autorisation']
                ];

                Flight::json([
                    'success' => true,
                    'message' => 'Inscription réussie',
                    'redirect' => BASE_URL . '/acceuil'
                ]);
            }
        } catch (Exception $e) {
            Flight::json([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ], 500);
        }
    }
}