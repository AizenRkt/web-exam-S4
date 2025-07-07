<?php require_once __DIR__ . '/../../config/config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un type de client</title>
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
        #typeclient-list {
            list-style-type: none;
            padding: 0;
        }
        #typeclient-list li {
            padding: 8px;
            margin: 5px 0;
            background-color: #f8f9fa;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h1>Ajouter un type de client</h1>
    <form id="typeclient-form">
        <label>Libellé :</label>
        <input type="text" name="libelle" required><br>
        <label>Description :</label>
        <textarea name="description" required></textarea><br>
        <button type="submit">Ajouter</button>
    </form>
    <div id="result"></div>
    <h2>Liste des types de client</h2>
    <ul id="typeclient-list"></ul>
    <script>
    const baseUrl = "<?= defined('BASE_URL') ? BASE_URL : '' ?>";
    
    function displayMessage(message, isSuccess) {
        const resultDiv = document.getElementById('result');
        resultDiv.textContent = message;
        resultDiv.className = isSuccess ? 'success' : 'error';
    }
    
    // Fonction utilitaire pour les requêtes XHR
    function makeRequest(method, url, data, callback) {
        const xhr = new XMLHttpRequest();
        xhr.open(method, url, true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    callback(null, response);
                } catch (e) {
                    callback(new Error('Réponse JSON invalide'), null);
                }
            } else {
                try {
                    const errorResponse = JSON.parse(xhr.responseText);
                    callback(new Error(errorResponse.message || 'Erreur serveur'), null);
                } catch (e) {
                    callback(new Error('Erreur ' + xhr.status), null);
                }
            }
        };
        
        xhr.onerror = function() {
            callback(new Error('Erreur réseau'), null);
        };
        
        if (data) {
            xhr.send(JSON.stringify(data));
        } else {
            xhr.send();
        }
    }
    
    // Charger les types de client
    function loadTypeClients() {
        makeRequest('GET', baseUrl + '/typeclients', null, function(err, response) {
            if (err) {
                console.error('Erreur lors du chargement:', err);
                displayMessage('Erreur lors du chargement: ' + err.message, false);
                return;
            }
            
            if (!response.success) {
                displayMessage(response.message || 'Erreur inconnue', false);
                return;
            }
            
            const ul = document.getElementById('typeclient-list');
            ul.innerHTML = '';
            
            if (response.data && response.data.length > 0) {
                response.data.forEach(t => {
                    const li = document.createElement('li');
                    li.textContent = `${t.libelle} : ${t.description}`;
                    ul.appendChild(li);
                });
            } else {
                const li = document.createElement('li');
                li.textContent = 'Aucun type de client trouvé';
                ul.appendChild(li);
            }
        });
    }
    
    // Gestion de la soumission du formulaire
    document.getElementById('typeclient-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = e.target;
        const formData = {
            libelle: form.libelle.value,
            description: form.description.value
        };
        
        makeRequest('POST', baseUrl + '/typeclients', formData, function(err, response) {
            if (err) {
                console.error('Erreur:', err);
                displayMessage('Erreur: ' + err.message, false);
                return;
            }
            
            if (!response.success) {
                displayMessage(response.message || 'Erreur inconnue', false);
                return;
            }
            
            displayMessage(response.message || 'Type de client ajouté avec succès', true);
            loadTypeClients();
            form.reset();
        });
    });
    
    // Chargement initial
    loadTypeClients();
    </script>
</body>
</html>