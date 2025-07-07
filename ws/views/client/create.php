<?php
require_once __DIR__ . '/../../../ws/config/config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Création de compte</title>
</head>
<body>
  <h1>Création de compte utilisateur</h1>

  <form method="post" action="<?= BASE_URL ?>/client/create">
    <div>
      <label for="id_role">Rôle</label>
      <select name="id_role" id="id_role" required>
        <?php foreach ($roles as $role): ?>
          <option value="<?= $role['id'] ?>"><?= htmlspecialchars($role['valeur']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div>
      <label for="nom">Nom</label>
      <input type="text" name="nom" id="nom" placeholder="Entrez votre nom" required>
    </div>

    <div>
      <label for="prenom">Prénom</label>
      <input type="text" name="prenom" id="prenom" placeholder="Entrez votre prénom" required>
    </div>

    <div>
      <label for="pwd">Mot de passe</label>
      <input type="password" name="pwd" id="pwd" placeholder="Entrez votre mot de passe" required>
    </div>

    <button type="submit">Créer le compte</button>
  </form>

  <p><a href="<?= BASE_URL ?>/client">Retour à l'accueil</a></p>
</body>
</html>
