<?php require_once __DIR__ . '/../../config/config.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ajouter un type d'investissement</title>
    <link rel="shortcut icon" href="<?= Flight::get('flight.base_url') ?>/public/assets/compiled/svg/favicon.svg" type="image/x-icon" />
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/compiled/css/app.css" />
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/compiled/css/iconly.css" />

    <style>
        #result {
            display: none;
            margin: 1rem 0;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
        }
        .success {
            background-color: #d1e7dd;
            color: #0f5132;
        }
        .error {
            background-color: #f8d7da;
            color: #842029;
        }
    </style>
</head>
<body>
<div id="app">
    <?php Flight::render('template/menu/adminSidebar'); ?>
    <div id="main">
        <div class="page-heading">
            <h3>Ajouter un type d'investissement</h3>
        </div>

        <div class="page-content">
            <section class="section">

                <!-- Message -->
                <div id="result"></div>

                <!-- Formulaire -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Nouveau type d'investissement</h4>
                    </div>
                    <div class="card-body">
                        <form id="typeinvestissement-form">
                            <div class="form-group mb-3">
                                <label class="form-label">Libellé :</label>
                                <input type="text" name="libelle" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Taux d'intérêt :</label>
                                <input type="number" step="0.01" name="taux_interet" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Description :</label>
                                <textarea name="description" class="form-control" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </form>
                    </div>
                </div>

                <!-- Liste -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h4 class="card-title">Liste des types d'investissement</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
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
                        </div>
                    </div>
                </div>

            </section>
        </div>
    </div>
</div>

<script src="<?= Flight::get('flight.base_url') ?>/public/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="<?= Flight::get('flight.base_url') ?>/public/assets/compiled/js/app.js"></script>
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
</script>
</body>
</html>


