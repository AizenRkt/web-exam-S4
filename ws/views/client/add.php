<?php require_once __DIR__ . '/../../config/config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un client</title>
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
    // Remplir le select type de client dynamiquement
    fetch(baseUrl + '/client/typeclient')
        .then(res => res.json())
        .then(data => {
            const select = document.getElementById('id_type_client');
            data.forEach(t => {
                const opt = document.createElement('option');
                opt.value = t.id;
                opt.textContent = t.libelle;
                select.appendChild(opt);
            });
        });
    // Soumission AJAX
    document.getElementById('client-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        fetch(baseUrl + '/clients', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById('result').textContent = data.message || JSON.stringify(data);
            form.reset();
        })
        .catch(err => {
            document.getElementById('result').textContent = 'Erreur lors de l\'ajout.';
        });
    });
    </script>
</body>
</html> 