<?php
require_once __DIR__ . '/../../../ws/config/config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>
<body>
    <h1>Créer un compte</h1>
    <form id="signup-form">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required><br>
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required><br>
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required><br>
        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required><br>
        <label for="telephone">Téléphone :</label>
        <input type="text" id="telephone" name="telephone"><br>
        <label for="adresse">Adresse :</label>
        <input type="text" id="adresse" name="adresse"><br>
        <label for="id_role">Rôle :</label>
        <select id="role-select" name="id_role" required>
            <option value="">Sélectionner un rôle...</option>
        </select><br>
        <button type="submit">S'inscrire</button>
    </form>
    <div id="message"></div>

    <script>
    const baseUrl = "<?= defined('BASE_URL') ? BASE_URL : '' ?>";
    // Charger dynamiquement les rôles avec AJAX (XHR)
    var xhrRoles = new XMLHttpRequest();
    xhrRoles.open('GET', baseUrl + '/roles', true);
    xhrRoles.onreadystatechange = function() {
      if (xhrRoles.readyState === 4 && xhrRoles.status === 200) {
        var roles = JSON.parse(xhrRoles.responseText);
        var select = document.getElementById('role-select');
        roles.forEach(function(role) {
          var option = document.createElement('option');
          option.value = role.id;
          option.textContent = role.libelle;
          select.appendChild(option);
        });
      }
    };
    xhrRoles.send();

    // Soumission du formulaire avec AJAX (XHR)
    document.getElementById('signup-form').addEventListener('submit', function(e) {
      e.preventDefault();
      var data = {
        nom: document.getElementById('nom').value,
        prenom: document.getElementById('prenom').value,
        email: document.getElementById('email').value,
        mot_de_passe: document.getElementById('mot_de_passe').value,
        telephone: document.getElementById('telephone').value,
        adresse: document.getElementById('adresse').value,
        id_role: document.getElementById('role-select').value
      };
      var xhr = new XMLHttpRequest();
      xhr.open('POST', baseUrl + '/inscription', true);
      xhr.setRequestHeader('Content-Type', 'application/json');
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
          var msg = document.getElementById('message');
          try {
            var resp = JSON.parse(xhr.responseText);
            if (xhr.status === 200 && resp.success) {
              window.location.href = baseUrl + '/acceuil';
            } else {
              msg.textContent = resp.message || 'Erreur lors de l\'inscription.';
              msg.style.color = 'red';
            }
          } catch (e) {
            msg.textContent = 'Erreur serveur.';
            msg.style.color = 'red';
          }
        }
      };
      xhr.send(JSON.stringify(data));
    });
    </script>
</body>
</html>