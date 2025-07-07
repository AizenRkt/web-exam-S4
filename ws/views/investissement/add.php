<?php require_once __DIR__ . '/../../config/config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un investissement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
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
        select {
            padding: 5px;
            margin-bottom: 10px;
            width: 200px;
        }
        label {
            display: inline-block;
            width: 150px;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="number"],
        textarea {
            padding: 5px;
            width: 200px;
            margin-bottom: 10px;
        }
        button {
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .loading {
            color: #666;
            font-style: italic;
        }
    </style>
</head>
<body>
    <h1>Ajouter un investissement</h1>
    <form id="investissement-form">
        <label>Libellé :</label>
        <input type="text" name="libelle" required><br>
        <label>Montant :</label>
        <input type="number" step="0.01" name="montant" required><br>
        <label>Client :</label>
        <select name="id_client" id="id_client" required>
            <option value="" class="loading">Chargement des clients...</option>
        </select><br>
        <label>Type d'investissement :</label>
        <select name="id_type_investissement" id="id_type_investissement" required>
            <option value="" class="loading">Chargement des types...</option>
        </select><br>
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

    function makeXHRRequest(method, url, data) {
        return new Promise(function(resolve, reject) {
            const xhr = new XMLHttpRequest();
            xhr.open(method, url, true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        resolve(response);
                    } catch (e) {
                        reject(new Error('Format de réponse invalide'));
                    }
                } else {
                    try {
                        const error = JSON.parse(xhr.responseText);
                        reject(new Error(error.message || 'Erreur serveur'));
                    } catch (e) {
                        reject(new Error('Erreur HTTP ' + xhr.status));
                    }
                }
            };
            
            xhr.onerror = function() {
                reject(new Error('Erreur de connexion au serveur'));
            };
            
            xhr.send(data ? JSON.stringify(data) : null);
        });
    }

    async function loadSelectData(url, selectId, displayField) {
        const select = document.getElementById(selectId);
        try {
            const response = await makeXHRRequest('GET', url, null);
            
            // Gestion des différents formats de réponse
            let data = [];
            if (Array.isArray(response)) {
                data = response;
            } else if (response && Array.isArray(response.data)) {
                data = response.data;
            } else {
                throw new Error('Format de données inattendu');
            }

            select.innerHTML = '';
            
            if (data.length === 0) {
                const option = document.createElement('option');
                option.value = '';
                option.textContent = 'Aucune donnée disponible';
                select.appendChild(option);
                return;
            }

            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                // Essayer différents champs pour l'affichage
                const displayValue = item[displayField] || item.libelle || item.nom || item.prenom || 'Sans nom';
                option.textContent = displayValue;
                select.appendChild(option);
            });
            
        } catch (error) {
            select.innerHTML = '';
            const option = document.createElement('option');
            option.value = '';
            option.textContent = 'Erreur de chargement';
            select.appendChild(option);
            displayMessage('Erreur lors du chargement: ' + error.message, false);
            console.error('Erreur:', error, 'URL:', url);
        }
    }

    // Chargement initial des données
    document.addEventListener('DOMContentLoaded', function() {
        loadSelectData(baseUrl + '/clients', 'id_client', 'nom');
        loadSelectData(baseUrl + '/typeinvestissements', 'id_type_investissement', 'libelle');
    });

    // Soumission du formulaire
 // Dans votre fichier HTML, modifiez la partie script comme suit :

document.getElementById('investissement-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    const form = e.target;
    
    // Validation côté client
    if (!form.id_client.value || !form.id_type_investissement.value) {
        displayMessage('Veuillez sélectionner un client et un type d\'investissement', false);
        return;
    }

    const formData = {
        libelle: form.libelle.value,
        montant: parseFloat(form.montant.value),
        id_client: parseInt(form.id_client.value),
        id_type_investissement: parseInt(form.id_type_investissement.value)
    };

    try {
        const response = await makeXHRRequest('POST', baseUrl + '/investissements', formData);
        
        if (response.success) {
            displayMessage(response.message || 'Investissement créé avec succès', true);
            form.reset();
        } else {
            throw new Error(response.message || 'Erreur lors de la création');
        }
    } catch (error) {
        console.error('Erreur détaillée:', error);
        displayMessage('Erreur: ' + error.message, false);
    }
});
    </script>
</body>
</html>