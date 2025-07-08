<?php require_once __DIR__ . '/../../config/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Liste des investissements</title>
    <link rel="shortcut icon" href="<?= Flight::get('flight.base_url') ?>/public/assets/compiled/svg/favicon.svg" type="image/x-icon" />
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/compiled/css/app.css" />
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/compiled/css/iconly.css" />
</head>
<body>
<div id="app">
    <?php Flight::render('template/menu/adminSidebar'); ?>
    <div id="main">
        <div class="page-heading">
            <h3>Liste des investissements</h3>
        </div>
        <div class="page-content">
            <section class="section">
                <div id="status-message" class="alert alert-info" style="display: none;"></div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tableau des investissements</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-investissements">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Libellé</th>
                                        <th>Montant</th>
                                        <th>Client</th>
                                        <th>Type d'investissement</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody id="investissements-body">
                                    <!-- Rempli dynamiquement -->
                                </tbody>
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

    function showMessage(id, message, type = 'info') {
        const el = document.getElementById(id);
        el.className = 'alert alert-' + type;
        el.textContent = message;
        el.style.display = 'block';
    }

    function hideMessage(id) {
        const el = document.getElementById(id);
        el.style.display = 'none';
    }

    function displayInvestissements(data) {
        const tbody = document.getElementById('investissements-body');
        tbody.innerHTML = '';

        data.forEach(inv => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${inv.id || ''}</td>
                <td>${inv.libelle || ''}</td>
                <td>${inv.montant || ''}</td>
                <td>${inv.id_client || ''}</td>
                <td>${inv.id_type_investissement || ''}</td>
                <td>${inv.date || ''}</td>
            `;
            tbody.appendChild(row);
        });
    }

    function loadInvestissements() {
        showMessage('status-message', 'Chargement en cours...');

        const xhr = new XMLHttpRequest();
        xhr.open('GET', baseUrl + '/investissements', true);
        xhr.timeout = 10000;

        xhr.onload = () => {
            try {
                const res = JSON.parse(xhr.responseText);
                if (res.success) {
                    if (res.data?.length) {
                        displayInvestissements(res.data);
                        hideMessage('status-message');
                    } else {
                        showMessage('status-message', 'Aucun investissement trouvé.', 'warning');
                    }
                } else {
                    showMessage('status-message', res.message || 'Erreur inconnue', 'danger');
                }
            } catch (e) {
                showMessage('status-message', 'Réponse invalide du serveur.', 'danger');
            }
        };

        xhr.onerror = () => showMessage('status-message', 'Erreur réseau', 'danger');
        xhr.ontimeout = () => showMessage('status-message', 'Délai d’attente dépassé', 'danger');

        xhr.send();
    }

    document.addEventListener('DOMContentLoaded', loadInvestissements);
</script>
</body>
</html>
