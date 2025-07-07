<?php require_once __DIR__ . '/../../config/config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un type d'investissement</title>
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
    <h1>Ajouter un type d'investissement</h1>
    <form id="typeinvestissement-form">
        <label>Libellé :</label>
        <input type="text" name="libelle" required><br>
        <label>Taux d'intérêt :</label>
        <input type="number" step="0.01" name="taux_interet" required><br>
        <label>Description :</label>
        <textarea name="description" required></textarea><br>
        <button type="submit">Ajouter</button>
    </form>
    <div id="result"></div>
    <h2>Liste des types d'investissement</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Libellé</th>
                <th>Taux d'intérêt</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody id="typeinvestissements-body"></tbody>
    </table>
    <script>
    const baseUrl = "<?= defined('BASE_URL') ? BASE_URL : '' ?>";
    function displayMessage(message, isSuccess) {
        const resultDiv = document.getElementById('result');
        resultDiv.textContent = message;
        resultDiv.className = isSuccess ? 'success' : 'error';
    }
    function loadTypeInvestissements() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', baseUrl + '/typeinvestissements', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    try {
                        var response = JSON.parse(xhr.responseText);
                        if (!response.success) {
                            throw new Error(response.message || 'Erreur inconnue');
                        }
                        var tbody = document.getElementById('typeinvestissements-body');
                        tbody.innerHTML = '';
                        response.data.forEach(function(type) {
                            var tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td>${type.id}</td>
                                <td>${type.libelle}</td>
                                <td>${type.taux_interet}</td>
                                <td>${type.description}</td>
                            `;
                            tbody.appendChild(tr);
                        });
                    } catch (err) {
                        displayMessage('Erreur lors du chargement : ' + err.message, false);
                    }
                } else {
                    displayMessage('Erreur lors du chargement : ' + xhr.status, false);
                }
            }
        };
        xhr.send();
    }
    document.getElementById('typeinvestissement-form').addEventListener('submit', function(e) {
        e.preventDefault();
        var form = e.target;
        var formData = {
            libelle: form.libelle.value,
            taux_interet: form.taux_interet.value,
            description: form.description.value
        };
        var xhr = new XMLHttpRequest();
        xhr.open('POST', baseUrl + '/typeinvestissements', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    if (xhr.status === 200 && response.success) {
                        displayMessage(response.message || 'Type d\'investissement ajouté avec succès', true);
                        form.reset();
                        loadTypeInvestissements();
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
    // Chargement initial
    loadTypeInvestissements();
    </script>
</body>
</html> 