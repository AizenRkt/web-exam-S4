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
    function loadTypeClients() {
        fetch(baseUrl + '/typeclients')
            .then(res => res.json())
            .then(response => {
                if (!response.success) {
                    throw new Error(response.message || 'Erreur inconnue');
                }
                const ul = document.getElementById('typeclient-list');
                ul.innerHTML = '';
                response.data.forEach(t => {
                    const li = document.createElement('li');
                    li.textContent = `${t.libelle} : ${t.description}`;
                    ul.appendChild(li);
                });
            })
            .catch(err => {
                console.error('Erreur lors du chargement:', err);
                displayMessage('Erreur lors du chargement des types de client: ' + err.message, false);
            });
    }
    document.getElementById('typeclient-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = e.target;
        const formData = {
            libelle: form.libelle.value,
            description: form.description.value
        };
        fetch(baseUrl + '/typeclients', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData)
        })
        .then(res => res.json())
        .then(response => {
            if (!response.success) {
                throw new Error(response.message || 'Erreur inconnue');
            }
            displayMessage(response.message || 'Type de client ajouté avec succès', true);
            loadTypeClients();
            form.reset();
        })
        .catch(err => {
            console.error('Erreur:', err);
            displayMessage(err.message || 'Erreur lors de l\'ajout', false);
        });
    });
    // Chargement initial
    loadTypeClients();
    </script>
</body>
</html>