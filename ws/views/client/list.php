<?php require_once __DIR__ . '/../../config/config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Liste des clients</title>
</head>
<body>
    <h1>Liste des clients</h1>
    <table border="1">
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
        <tbody id="clients-body">
        </tbody>
    </table>
    <script>
    const baseUrl = "<?= defined('BASE_URL') ? BASE_URL : '' ?>";
    function loadClients() {
        fetch(baseUrl + '/clients')
            .then(res => res.json())
            .then(data => {
                const tbody = document.getElementById('clients-body');
                tbody.innerHTML = '';
                data.forEach(client => {
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
            });
    }
    loadClients();
    </script>
</body>
</html> 