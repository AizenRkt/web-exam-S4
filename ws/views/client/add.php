<?php require_once __DIR__ . '/../../config/config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un client</title>
    <style>
        #result {
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <h1>Ajouter un client</h1>
    <form id="client-form">
        <label>Type de client :</label>
        <select name="id_type_client" id="id_type_client" required></select><br>
        <label>Nom :</label>
        <input type="text" name="nom" required><br>
        <label>Prénom :</label>
        <input type="text" name="prenom" required><br>
        <label>Email :</label>
        <input type="email" name="email" required><br>
        <label>Téléphone :</label>
        <input type="text" name="telephone" required><br>
        <label>Adresse :</label>
        <input type="text" name="adresse" required><br>
        <button type="submit">Ajouter</button>
    </form>
    <div id="result"></div>
    <script>
    const baseUrl = "<?= defined('BASE_URL') ? BASE_URL : '' ?>";
    function displayMessage(message, isSuccess) {
        const resultDiv = document.getElementById('result');
        resultDiv.textContent = message;
        resultDiv.className = isSuccess ? 'success' : 'error';
    }
    // Remplir le select type de client dynamiquement avec XHR
    (function() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', baseUrl + '/client/typeclient', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);
                var select = document.getElementById('id_type_client');
                data.forEach(function(t) {
                    var opt = document.createElement('option');
                    opt.value = t.id;
                    opt.textContent = t.libelle;
                    select.appendChild(opt);
                });
            }
        };
        xhr.send();
    })();
    // Soumission AJAX avec XHR
    document.getElementById('client-form').addEventListener('submit', function(e) {
        e.preventDefault();
        var form = e.target;
        var formData = {
            id_type_client: form.id_type_client.value,
            nom: form.nom.value,
            prenom: form.prenom.value,
            email: form.email.value,
            telephone: form.telephone.value,
            adresse: form.adresse.value
        };
        var xhr = new XMLHttpRequest();
        xhr.open('POST', baseUrl + '/clients', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    if (xhr.status === 200 && response.success) {
                        displayMessage(response.message || 'Client ajouté avec succès', true);
                        form.reset();
                    } else {
                        displayMessage((response && response.message) || 'Erreur lors de l\'ajout', false);
                    }
                } catch (err) {
                    displayMessage('Erreur lors de l\'ajout', false);
                }
            }
        };
        xhr.send(JSON.stringify(formData));
    });
    </script>
</body>
</html> 