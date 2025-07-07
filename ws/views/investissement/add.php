<?php require_once __DIR__ . '/../../config/config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un investissement</title>
</head>
<body>
    <h1>Ajouter un investissement</h1>
    <form id="investissement-form">
        <label>Libellé :</label>
        <input type="text" name="libelle" required><br>
        <label>Montant :</label>
        <input type="number" step="0.01" name="montant" required><br>
        <label>Client :</label>
        <select name="id_client" id="id_client" required></select><br>
        <label>Type d'investissement :</label>
        <select name="id_type_investissement" id="id_type_investissement" required></select><br>
        <button type="submit">Ajouter</button>
    </form>
    <div id="result"></div>
    <script>
    const baseUrl = "<?= defined('BASE_URL') ? BASE_URL : '' ?>";
    // Remplir les selects dynamiquement
    fetch(baseUrl + '/investissement/formdata')
        .then(res => res.json())
        .then(data => {
            const clientSelect = document.getElementById('id_client');
            data.clients.forEach(c => {
                const opt = document.createElement('option');
                opt.value = c.id;
                opt.textContent = c.nom + ' ' + c.prenom;
                clientSelect.appendChild(opt);
            });
            const typeSelect = document.getElementById('id_type_investissement');
            data.types.forEach(t => {
                const opt = document.createElement('option');
                opt.value = t.id;
                opt.textContent = t.libelle;
                typeSelect.appendChild(opt);
            });
        });
    // Soumission AJAX
    document.getElementById('investissement-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        fetch(baseUrl + '/investissements', {
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