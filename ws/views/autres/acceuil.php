<?php
require_once __DIR__ . '/../../../ws/config/config.php';

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
</head>
<body>
    <?php include __DIR__ . '/../partials/navbar.php'; ?>

    <h1>Bienvenue sur la page d’accueil</h1>
    <p>Bonjour, <?= htmlspecialchars($_SESSION['utilisateur']['nom'] ?? 'Utilisateur') ?> !</p>
    <!-- Affiche ici les liens/fonctionnalités selon l'autorisation -->

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
