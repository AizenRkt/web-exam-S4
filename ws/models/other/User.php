<?php
require_once __DIR__ . '/../../db.php';

class User
{
    // Vérifie les identifiants et le rôle (email + mot de passe + rôle)
    public static function verifierConnexion($email, $mot_de_passe, $role) {
        $db = getDB();
    
        $stmt = $db->prepare("
            SELECT u.*, r.libelle AS role 
            FROM utilisateur u
            JOIN role r ON u.id_role = r.id
            WHERE u.email = ? AND r.libelle = ?
        ");
        
        // Trim des valeurs
        $email = trim($email);
        $role = trim($role);
    
        $stmt->execute([$email, $role]);
    
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user) {
            echo "✅ Utilisateur trouvé<br>";
            echo "Mot de passe fourni : " . $mot_de_passe . "<br>";
            echo "Hash en base : " . $user['mot_de_passe'] . "<br>";
    
            if (password_verify($mot_de_passe, $user['mot_de_passe'])) {
                echo "✅ Mot de passe correct<br>";
                return $user;
            } else {
                echo "❌ Mot de passe incorrect<br>";
            }
        } else {
            echo "❌ Aucun utilisateur trouvé avec cet email et rôle<br>";
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
    
        $hashedPwd = password_hash($data->mot_de_passe, PASSWORD_DEFAULT);
    
        $stmt = $db->prepare("
            INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, telephone, adresse, id_role)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data->nom,
            $data->prenom,
            $data->email,
            $hashedPwd,
            $data->telephone,
            $data->adresse,
            $data->id_role
        ]);
    
        return $db->lastInsertId();
    }       

    // Met à jour un utilisateur (avec hashage du mot de passe si modifié)
    public static function update($id, $data)
    {
        $db = getDB();
        $hashedPwd = password_hash($data->mot_de_passe, PASSWORD_DEFAULT);

        $stmt = $db->prepare("
            UPDATE utilisateur 
            SET id_role = ?, nom = ?, prenom = ?, email = ?, mot_de_passe = ?, telephone = ?, adresse = ?
            WHERE id = ?
        ");
        $stmt->execute([
            $data->id_role,
            $data->nom,
            $data->prenom,
            $data->email,
            $hashedPwd,
            $data->telephone ?? null,
            $data->adresse ?? null,
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
