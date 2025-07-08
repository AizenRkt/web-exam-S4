<?php
require_once __DIR__ . '/../../../ws/config/config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>
    <h1>Connexion</h1>
    <form id="login-form">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required><br>
        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required><br>
        <button type="submit">Se connecter</button>
    </form>
    <div id="message"></div>

    <script>
document.getElementById('login-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const email = document.getElementById('email').value.trim();
    const mot_de_passe = document.getElementById('mot_de_passe').value;
    const messageDiv = document.getElementById('message');
    messageDiv.textContent = '';
    messageDiv.style.color = '';

    if (!email) {
        messageDiv.textContent = 'L\'email est requis';
        messageDiv.style.color = 'red';
        return;
    }
    if (!mot_de_passe) {
        messageDiv.textContent = 'Le mot de passe est requis';
        messageDiv.style.color = 'red';
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '<?= BASE_URL ?? '' ?>/connexion', true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    xhr.onload = function() {
        try {
            const response = JSON.parse(xhr.responseText);
            
            if (xhr.status >= 200 && xhr.status < 300) {
                if (response.success) {
                    window.location.href = response.redirect;
                } else {
                    messageDiv.textContent = response.message;
                    messageDiv.style.color = 'red';
                }
            } else {
                messageDiv.textContent = response.message || 'Erreur serveur';
                messageDiv.style.color = 'red';
            }
        } catch (e) {
            messageDiv.textContent = 'Erreur de traitement de la réponse';
            messageDiv.style.color = 'red';
            console.error('Erreur:', e, 'Réponse:', xhr.responseText);
        }
    };

    xhr.onerror = function() {
        messageDiv.textContent = 'Erreur réseau';
        messageDiv.style.color = 'red';
    };

    xhr.send(JSON.stringify({
        email: email,
        mot_de_passe: mot_de_passe
    }));
});
</script></body>
</html>