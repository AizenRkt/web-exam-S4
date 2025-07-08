<?php require_once __DIR__ . '/../../config/config.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Liste des clients</title>
  <link rel="shortcut icon" href="<?= Flight::get('flight.base_url') ?>/public/assets/compiled/svg/favicon.svg" type="image/x-icon" />
  <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/compiled/css/app.css" />
  <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/compiled/css/iconly.css" />
</head>
<body>
  <div id="app">
    <?php Flight::render('template/menu/adminSidebar'); ?>
    <div id="main" class="layout-navbar">
      <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
          <i class="bi bi-justify fs-3"></i>
        </a>
      </header>

      <div id="main-content">
        <div class="page-heading">
          <h3>Liste des clients</h3>
        </div>

        <div class="page-content">
          <section class="row">
            <div class="col-12">
              <div id="status-message" class="alert alert-info d-none"></div>
              <div class="card">
                <div class="card-header">
                  <h4>Clients enregistrés</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered mb-0">
                      <thead class="thead-light">
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
                        <!-- Clients chargés dynamiquement -->
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>

      </div>
    </div>
  </div>

  <script src="<?= Flight::get('flight.base_url') ?>/public/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <script src="<?= Flight::get('flight.base_url') ?>/public/assets/compiled/js/app.js"></script>
  <script>
    const baseUrl = "<?= defined('BASE_URL') ? BASE_URL : '' ?>";
    const apiUrl = baseUrl + '/clients';

    function showMessage(message, type = 'info') {
      const element = document.getElementById('status-message');
      element.textContent = message;
      element.className = `alert alert-${type}`;
      element.classList.remove('d-none');
    }

    function hideMessage() {
      const element = document.getElementById('status-message');
      element.classList.add('d-none');
    }

    function loadClients() {
      showMessage('Chargement des clients...', 'info');

      const xhr = new XMLHttpRequest();
      xhr.open('GET', apiUrl, true);
      xhr.onload = function () {
        if (xhr.status === 200) {
          try {
            const clients = JSON.parse(xhr.responseText);
            if (clients && clients.length > 0) {
              displayClients(clients);
              hideMessage();
            } else {
              showMessage('Aucun client trouvé.', 'warning');
            }
          } catch (e) {
            showMessage('Erreur de lecture des données.', 'danger');
            console.error('Erreur JSON:', e, 'Réponse:', xhr.responseText);
          }
        } else {
          showMessage(`Erreur ${xhr.status} lors du chargement.`, 'danger');
        }
      };
      xhr.onerror = function () {
        showMessage('Erreur de connexion au serveur.', 'danger');
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

    document.addEventListener('DOMContentLoaded', loadClients);
  </script>
</body>
</html>
