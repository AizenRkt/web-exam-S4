<?php require_once __DIR__ . '/../../config/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ajouter un investissement</title>
    <link rel="shortcut icon" href="<?= Flight::get('flight.base_url') ?>/public/assets/compiled/svg/favicon.svg" type="image/x-icon" />
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/compiled/css/app.css" />
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/compiled/css/iconly.css" />
</head>
<body>
<div id="app">
    <?php Flight::render('template/menu/adminSidebar'); ?>
    <div id="main">
        <div class="page-heading">
            <h3>Ajouter un investissement</h3>
        </div>
        <div class="page-content">
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Formulaire d'investissement</h4>
                    </div>
                    <div class="card-body">
                        <form id="investissement-form">
                            <div class="form-group">
                                <label for="libelle">Libellé</label>
                                <input type="text" name="libelle" id="libelle" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="montant">Montant</label>
                                <input type="number" step="0.01" name="montant" id="montant" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="id_client">Client</label>
                                <select name="id_client" id="id_client" class="form-select" required>
                                    <option value="" class="loading">Chargement...</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="id_type_investissement">Type d'investissement</label>
                                <select name="id_type_investissement" id="id_type_investissement" class="form-select" required>
                                    <option value="" class="loading">Chargement...</option>
                                </select>
                            </div>
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">Ajouter</button>
                            </div>
                        </form>
                        <div id="result" class="mt-3"></div>
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
        resultDiv.className = isSuccess ? 'alert alert-success' : 'alert alert-danger';
    }

    function makeXHRRequest(method, url, data) {
        return new Promise(function(resolve, reject) {
            const xhr = new XMLHttpRequest();
            xhr.open(method, url, true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    try {
                        resolve(JSON.parse(xhr.responseText));
                    } catch {
                        reject(new Error("Réponse JSON invalide"));
                    }
                } else {
                    try {
                        const err = JSON.parse(xhr.responseText);
                        reject(new Error(err.message || "Erreur serveur"));
                    } catch {
                        reject(new Error("Erreur HTTP " + xhr.status));
                    }
                }
            };
            xhr.onerror = () => reject(new Error("Erreur réseau"));
            xhr.send(data ? JSON.stringify(data) : null);
        });
    }

    async function loadSelectData(url, selectId, displayField) {
        const select = document.getElementById(selectId);
        try {
            const response = await makeXHRRequest('GET', url);
            const data = Array.isArray(response) ? response : response.data || [];
            select.innerHTML = '';
            if (data.length === 0) {
                select.innerHTML = '<option value="">Aucune donnée disponible</option>';
                return;
            }
            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = item[displayField] || item.libelle || item.nom || item.prenom || 'Sans nom';
                select.appendChild(option);
            });
        } catch (err) {
            select.innerHTML = '<option value="">Erreur de chargement</option>';
            displayMessage(err.message, false);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        loadSelectData(baseUrl + '/clients', 'id_client', 'nom');
        loadSelectData(baseUrl + '/typeinvestissements', 'id_type_investissement', 'libelle');
    });

    document.getElementById('investissement-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        const form = e.target;
        if (!form.id_client.value || !form.id_type_investissement.value) {
            displayMessage('Veuillez compléter tous les champs', false);
            return;
        }

        const data = {
            libelle: form.libelle.value,
            montant: parseFloat(form.montant.value),
            id_client: parseInt(form.id_client.value),
            id_type_investissement: parseInt(form.id_type_investissement.value)
        };

        try {
            const response = await makeXHRRequest('POST', baseUrl + '/investissements', data);
            if (response.success) {
                displayMessage(response.message || "Investissement créé avec succès", true);
                form.reset();
            } else {
                throw new Error(response.message || "Erreur inconnue");
            }
        } catch (err) {
            displayMessage(err.message, false);
        }
    });
</script>
</body>
</html>
