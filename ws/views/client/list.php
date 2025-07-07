<?php require_once __DIR__ . '/../../config/config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Liste des clients</title>
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
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .status-message {
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .loading {
            color: #31708f;
            background-color: #d9edf7;
            border: 1px solid #bce8f1;
        }
        .error {
            color: #d9534f;
            background-color: #f2dede;
            border: 1px solid #ebccd1;
        }
    </style>
</head>
<body>
    <h1>Liste des clients</h1>
    <div id="status-message" class="status-message"></div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Adresse</th>
            </tr>
        </thead>
        <tbody id="clients-body"></tbody>
    </table>

    <script>
    const baseUrl = "<?= defined('BASE_URL') ? BASE_URL : '' ?>";
    const apiUrl = baseUrl + '/clients';
    
    function showMessage(message, type) {
        const element = document.getElementById('status-message');
        element.textContent = message;
        element.className = `status-message ${type}`;
    }

    function loadClients() {
        showMessage('Chargement en cours...', 'loading');
        
        const xhr = new XMLHttpRequest();
        xhr.open('GET', apiUrl, true);
        
        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    const clients = JSON.parse(xhr.responseText);
                    
                    if (clients && clients.length > 0) {
                        displayClients(clients);
                        document.getElementById('status-message').style.display = 'none';
                    } else {
                        showMessage('Aucun client trouvé', 'error');
                    }
                } catch (e) {
                    showMessage('Erreur de format des données', 'error');
                    console.error('Erreur parsing JSON:', e, 'Réponse:', xhr.responseText);
                }
            } else {
                showMessage(`Erreur ${xhr.status} lors du chargement`, 'error');
            }
        };
        
        xhr.onerror = function() {
            showMessage('Erreur de connexion au serveur', 'error');
        };
        
        xhr.send();
    }

    function displayClients(clients) {
        const tbody = document.getElementById('clients-body');
        tbody.innerHTML = '';
        
        clients.forEach(client => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${client.id}</td>
                <td>${client.id_type_client}</td>
                <td>${client.nom}</td>
                <td>${client.prenom}</td>
                <td>${client.email}</td>
                <td>${client.telephone}</td>
                <td>${client.adresse}</td>
            `;
            tbody.appendChild(tr);
        });
    }

    // Démarrer le chargement
    document.addEventListener('DOMContentLoaded', loadClients);
    </script>
</body>
</html>