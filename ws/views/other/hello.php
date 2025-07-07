<?php
require_once __DIR__ . '/../../../ws/config/config.php';

?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Page Hello</title>
</head>
<body>
  <h1>Bonjour depuis la page Home</h1>
  
  <p><a href="<?php echo BASE_URL; ?>/etablissement">établissement</a></p>
  <p><a href="<?php echo BASE_URL; ?>/client">client</a></p>
  <p><a href="<?php echo BASE_URL; ?>/investisseur">investisseur</a></p>

  <a href="<?php echo BASE_URL; ?>/login">Logout</a>

  <div>
  <ul>
        <li><strong>Email :</strong> <?= htmlspecialchars($email) ?></li>
        <li><strong>Mot de passe :</strong> <?= htmlspecialchars($mot_de_passe) ?></li>
        <li><strong>Rôle :</strong> <?= htmlspecialchars($role) ?></li>
    </ul>
  </div>
</body>
</html>
