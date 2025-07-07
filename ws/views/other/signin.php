<?php
require_once __DIR__ . '/../../../ws/config/config.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Créer un compte</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/login.css">
</head>

<body>

    <form class="form" action="<?= BASE_URL ?>/client/create" method="post">
        <h2 class="title">Créer un compte</h2>

        <!-- Rôle -->
        <div class="flex-column">
            <label for="id_role">Rôle</label>
        </div>
        <div class="inputForm">
            <select name="id_role" id="id_role" class="input" required>
                <?php foreach ($roles as $role): ?>
                    <option value="<?= $role['id'] ?>" <?= $role['id'] == 3 ? 'selected' : '' ?>>
                        <?= htmlspecialchars($role['valeur']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>


        <!-- Nom -->
        <div class="flex-column">
            <label for="nom">Nom</label>
        </div>
        <div class="inputForm">
            <svg height="20" width="20" viewBox="0 0 24 24">
                <path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z" />
            </svg>
            <input type="text" class="input" name="nom" id="nom" placeholder="Entrez votre nom" required>
        </div>

        <!-- Prénom -->
        <div class="flex-column">
            <label for="prenom">Prénom</label>
        </div>
        <div class="inputForm">
            <svg height="20" width="20" viewBox="0 0 24 24">
                <path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z" />
            </svg>
            <input type="text" class="input" name="prenom" id="prenom" placeholder="Entrez votre prénom" required>
        </div>

        <!-- Mot de passe -->
        <div class="flex-column">
            <label for="pwd">Mot de passe</label>
        </div>
        <div class="inputForm">
            <svg height="20" width="20" viewBox="0 0 24 24">
                <path d="M12 17a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm6-7h-1V7a5 5 0 0 0-10 0v3H6a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2zM8 7a4 4 0 1 1 8 0v3H8V7z" />
            </svg>
            <input type="password" class="input" name="pwd" id="pwd" placeholder="Entrez votre mot de passe" required>
        </div>

        <button type="submit" class="button-submit">Créer le compte</button>

        <p class="p">
            <a href="<?= BASE_URL ?>/login">Déjà inscrit ? <span class="span">Se connecter</span></a>
        </p>
    </form>

</body>

</html>