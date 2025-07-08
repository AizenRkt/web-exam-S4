<?php
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/Role.php';

class Utilisateur
{
    public static function verifierConnexion($email, $mot_de_passe) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM utilisateur WHERE email = ?");
        $stmt->execute([trim($email)]);
        $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($utilisateur && password_verify($mot_de_passe, $utilisateur['mot_de_passe'])) {
            // Récupérer le rôle
            $role = null;
            $stmtRole = $db->prepare("SELECT * FROM role WHERE id = ?");
            $stmtRole->execute([$utilisateur['id_role']]);
            $role = $stmtRole->fetch(PDO::FETCH_ASSOC);
            if ($role) {
                $utilisateur['role'] = $role['libelle'];
                $utilisateur['autorisation'] = $role['autorisation'];
            }
            return $utilisateur;
        }
        return false;
    }    
    
    // Récupère tous les utilisateurs
    public static function getAll()
    {
        $db = getDB();
        $stmt = $db->query("
            SELECT u.*, r.libelle AS role
            FROM utilisateur u
            JOIN role r ON u.id_role = r.id
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupère un utilisateur par ID
    public static function getById($id)
    {
        $db = getDB();
        $stmt = $db->prepare("
            SELECT u.*, r.libelle AS role
            FROM utilisateur u
            JOIN role r ON u.id_role = r.id
            WHERE u.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupère un utilisateur par email et libellé de rôle
    public static function getByLibelle($email, $roleLibelle)
    {
        $db = getDB();
        $stmt = $db->prepare("
            SELECT u.*, r.libelle AS role
            FROM utilisateur u
            JOIN role r ON u.id_role = r.id
            WHERE u.email = ? AND r.libelle = ?
        ");
        $stmt->execute([$email, $roleLibelle]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crée un nouvel utilisateur avec mot de passe hashé
    public static function create($data) {
        $db = getDB();
    
        $hashedPwd = password_hash($data['mot_de_passe'], PASSWORD_DEFAULT);
    
        $stmt = $db->prepare("
            INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, telephone, adresse, id_role)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['nom'],
            $data['prenom'],
            $data['email'],
            $hashedPwd,
            $data['telephone'],
            $data['adresse'],
            $data['id_role']
        ]);
    
        return $db->lastInsertId();
    }       

    // Met à jour un utilisateur (avec hashage du mot de passe si modifié)
    public static function update($id, $data)
    {
        $db = getDB();
        $hashedPwd = password_hash($data['mot_de_passe'], PASSWORD_DEFAULT);

        $stmt = $db->prepare("
            UPDATE utilisateur 
            SET id_role = ?, nom = ?, prenom = ?, email = ?, mot_de_passe = ?, telephone = ?, adresse = ?
            WHERE id = ?
        ");
        $stmt->execute([
            $data['id_role'],
            $data['nom'],
            $data['prenom'],
            $data['email'],
            $hashedPwd,
            $data['telephone'] ?? null,
            $data['adresse'] ?? null,
            $id
        ]);
    }

    // Supprime un utilisateur
    public static function delete($id)
    {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM utilisateur WHERE id = ?");
        $stmt->execute([$id]);
    }

   
}
