<?php require_once __DIR__ . '/../../config/config.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Type de client</title>
    <link rel="shortcut icon" href="<?= Flight::get('flight.base_url') ?>/public/assets/compiled/svg/favicon.svg" type="image/x-icon" />
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/compiled/css/app.css" />
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/compiled/css/iconly.css" />
</head>
<body>
<div id="app">
    <?php Flight::render('template/menu/adminSidebar'); ?>
    <div id="main">
        <div class="page-heading">
            <h3>Gestion des types de client</h3>
        </div>
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">

                    <!-- Formulaire -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Ajouter un type de client</h4>
                            </div>
                            <div class="card-body">
                                <div id="result"></div>
                                <form id="typeclient-form">
                                    <div class="mb-3">
                                        <label for="libelle" class="form-label">Libellé</label>
                                        <input type="text" class="form-control" name="libelle" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" name="description" rows="3" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Ajouter</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Liste -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Liste des types de client</h4>
                            </div>
                            <div class="card-body">
                                <ul id="typeclient-list" class="list-group list-group-flush"></ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts Mazer -->
<script src="<?= Flight::get('flight.base_url') ?>/public/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="<?= Flight::get('flight.base_url') ?>/public/assets/compiled/js/app.js"></script>
<script>
    const baseUrl = "<?= defined('BASE_URL') ? BASE_URL : '' ?>";

    function displayMessage(message, isSuccess) {
        const resultDiv = document.getElementById('result');
        resultDiv.innerHTML = `
            <div class="alert ${isSuccess ? 'alert-success' : 'alert-danger'}" role="alert">
                ${message}
            </div>`;
    }

    function makeRequest(method, url, data, callback) {
        const xhr = new XMLHttpRequest();
        xhr.open(method, url, true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onload = function () {
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
        xhr.onerror = function () {
            callback(new Error('Erreur réseau'), null);
        };
        if (data) xhr.send(JSON.stringify(data));
        else xhr.send();
    }

    function loadTypeClients() {
        makeRequest('GET', baseUrl + '/typeclients', null, function (err, response) {
            const ul = document.getElementById('typeclient-list');
            ul.innerHTML = '';

            if (err || !response.success) {
                ul.innerHTML = `<li class="list-group-item text-danger">Erreur lors du chargement</li>`;
                return;
            }

            if (response.data && response.data.length > 0) {
                response.data.forEach(t => {
                    const li = document.createElement('li');
                    li.className = "list-group-item";
                    li.textContent = `${t.libelle} : ${t.description}`;
                    ul.appendChild(li);
                });
            } else {
                ul.innerHTML = `<li class="list-group-item">Aucun type de client trouvé</li>`;
            }
        });
    }

    document.getElementById('typeclient-form').addEventListener('submit', function (e) {
        e.preventDefault();
        const form = e.target;
        const formData = {
            libelle: form.libelle.value,
            description: form.description.value
        };
        makeRequest('POST', baseUrl + '/typeclients', formData, function (err, response) {
            if (err || !response.success) {
                displayMessage(err?.message || response?.message || 'Erreur inconnue', false);
                return;
            }
            displayMessage(response.message || 'Type de client ajouté avec succès', true);
            loadTypeClients();
            form.reset();
        });
    });

    document.addEventListener('DOMContentLoaded', loadTypeClients);
</script>
</body>
</html>