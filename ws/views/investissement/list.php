<?php require_once __DIR__ . '/../../config/config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Liste des investissements</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .error {
            color: #d9534f;
            padding: 15px;
            margin: 20px 0;
            border: 1px solid #ebccd1;
            background-color: #f2dede;
            border-radius: 4px;
        }
        .loading {
            padding: 15px;
            color: #31708f;
            background-color: #d9edf7;
            border: 1px solid #bce8f1;
            border-radius: 4px;
        }
        .no-data {
            padding: 15px;
            color: #8a6d3b;
            background-color: #fcf8e3;
            border: 1px solid #faebcc;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h1>Liste des investissements</h1>
    <div id="status-message"></div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Libellé</th>
                <th>Montant</th>
                <th>ID Client</th>
                <th>ID Type Investissement</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody id="investissements-body">
            <!-- Les données seront insérées ici par JavaScript -->
        </tbody>
    </table>
    <script>
    const baseUrl = "<?= defined('BASE_URL') ? BASE_URL : '' ?>";
    function showMessage(elementId, message, type) {
        const element = document.getElementById(elementId);
        element.textContent = message;
        element.className = type;
        element.style.display = 'block';
    }
    function hideMessage(elementId) {
        document.getElementById(elementId).style.display = 'none';
    }
    function loadInvestissements() {
        const statusElement = 'status-message';
        showMessage(statusElement, 'Chargement des investissements en cours...', 'loading');
        const xhr = new XMLHttpRequest();
        xhr.open('GET', baseUrl + '/investissements', true);
        xhr.timeout = 10000; // 10 secondes timeout
        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        if (response.data && response.data.length > 0) {
                            displayInvestissements(response.data);
                            hideMessage(statusElement);
                        } else {
                            showMessage(statusElement, 'Aucun investissement trouvé dans la base de données', 'no-data');
                        }
                    } else {
                        showMessage(statusElement, response.message || 'Erreur lors du chargement des données', 'error');
                    }
                } catch (e) {
                    showMessage(statusElement, 'Erreur de format des données reçues', 'error');
                }
            } else {
                handleHttpError(xhr);
            }
        };
        xhr.onerror = function() {
            showMessage(statusElement, 'Erreur de réseau - Impossible de se connecter au serveur', 'error');
        };
        xhr.ontimeout = function() {
            showMessage(statusElement, 'Le serveur met trop de temps à répondre', 'error');
        };
        xhr.send();
    }
    function displayInvestissements(investissements) {
        const tbody = document.getElementById('investissements-body');
        tbody.innerHTML = '';
        investissements.forEach(function(inv) {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${inv.id || ''}</td>
                <td>${inv.libelle || ''}</td>
                <td>${inv.montant || ''}</td>
                <td>${inv.id_client || ''}</td>
                <td>${inv.id_type_investissement || ''}</td>
                <td>${inv.date || ''}</td>
            `;
            tbody.appendChild(tr);
        });
    }
    function handleHttpError(xhr) {
        const statusElement = 'status-message';
        let errorMessage = 'Erreur HTTP ' + xhr.status;
        try {
            const errorResponse = JSON.parse(xhr.responseText);
            if (errorResponse.message) {
                errorMessage += ': ' + errorResponse.message;
            }
        } catch (e) {
            errorMessage += ' - Réponse inattendue du serveur';
        }
        showMessage(statusElement, errorMessage, 'error');
    }
    document.addEventListener('DOMContentLoaded', loadInvestissements);
    </script>
</body>
</html> 