<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$utilisateur = $_SESSION['utilisateur'] ?? null;
?>
<nav>
    <ul>
        <li><a href="/home">Accueil</a></li>
        <?php if ($utilisateur): ?>
                <li><a href="/prets/creation">Créer un prêt</a></li>
                <li><a href="/investissements/creation">Créer un investissement</a></li>
            <?php if ($utilisateur['autorisation'] >= 2): ?>
                <li><a href="/prets/validation">Valider les prêts</a></li>
                <li><a href="/prets">Liste des prêts</a></li>
                <li><a href="/investissements">Liste des investissements</a></li>
            <?php elseif ($utilisateur['autorisation'] >= 3): ?>
                <li><a href="/admin">Administration</a></li>
            <?php endif; ?>
            <li><a href="/logout">Déconnexion</a></li>
        <?php else: ?>
            <li><a href="/login">Connexion</a></li>
        <?php endif; ?>
    </ul>
</nav>
