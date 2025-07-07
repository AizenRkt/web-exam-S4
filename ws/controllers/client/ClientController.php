<?php
require_once __DIR__ . '/../../models/other/User.php';
require_once __DIR__ . '/../../models/other/Role.php';

class ClientController
{
    // Affiche la page d'accueil client
    public static function afficher()
    {
        include __DIR__ . '/../../views/client/home.php';
    }

    // Affiche le formulaire de création
    public static function create()
    {
        $roles = Role::getAll(); // Récupère tous les rôles pour le formulaire
        include __DIR__ . '/../../views/other/signin.php';
    }

    // Traite la soumission du formulaire (POST)
    public static function store()
    {
        // Récupère les données envoyées en POST
        $data = (object)[
            'id_role' => Flight::request()->data->id_role,
            'nom'     => Flight::request()->data->nom,
            'prenom'  => Flight::request()->data->prenom,
            'pwd'     => Flight::request()->data->pwd
        ];

        // Appelle la méthode de création
        User::create($data);

        // Redirige vers la page d’accueil ou une page de confirmation
        Flight::redirect('/login');
    }
}
