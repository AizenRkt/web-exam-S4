<?php
require_once __DIR__ . '/../../../ws/db.php';

class User {

    // Vérifie la connexion avec prénom et mot de passe
    public static function verifierConnexion($prenom, $pwd) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM user WHERE prenom = ? AND pwd = ?");
        $stmt->execute([$prenom, $pwd]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retourne l'utilisateur si trouvé
    }

    // Récupère tous les utilisateurs
    public static function getAll() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM user");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupère un utilisateur par son ID
    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM user WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crée un nouvel utilisateur
    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO user (id_role, nom, prenom, pwd) VALUES (?, ?, ?, ?)");
        $stmt->execute([$data->id_role, $data->nom, $data->prenom, $data->pwd]);
        return $db->lastInsertId();
    }

    // Met à jour un utilisateur
    public static function update($id, $data) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE user SET id_role = ?, nom = ?, prenom = ?, pwd = ? WHERE id = ?");
        $stmt->execute([$data->id_role, $data->nom, $data->prenom, $data->pwd, $id]);
    }

    // Supprime un utilisateur
    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM user WHERE id = ?");
        $stmt->execute([$id]);
    }
}
