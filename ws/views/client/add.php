<?php require_once __DIR__ . '/../../config/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ajouter un client</title>
  <link rel="shortcut icon" href="<?= Flight::get('flight.base_url') ?>/public/assets/compiled/svg/favicon.svg" type="image/x-icon">
  <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/compiled/css/app.css">
  <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/compiled/css/iconly.css">
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
        <h3>Ajouter un client</h3>
      </div>
      <div class="page-content">
        <section class="row">
          <div class="col-12 col-md-8 offset-md-2">
            <div class="card">
              <div class="card-header">
                <h4>Formulaire</h4>
              </div>
              <div class="card-body">
                <form id="client-form">
                  <div class="form-group mb-3">
                    <label for="id_type_client">Type de client</label>
                    <select class="form-control" name="id_type_client" id="id_type_client" required></select>
                  </div>
                  <div class="form-group mb-3">
                    <label>Nom</label>
                    <input type="text" class="form-control" name="nom" required>
                  </div>
                  <div class="form-group mb-3">
                    <label>Prénom</label>
                    <input type="text" class="form-control" name="prenom" required>
                  </div>
                  <div class="form-group mb-3">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" required>
                  </div>
                  <div class="form-group mb-3">
                    <label>Téléphone</label>
                    <input type="text" class="form-control" name="telephone" required>
                  </div>
                  <div class="form-group mb-3">
                    <label>Adresse</label>
                    <input type="text" class="form-control" name="adresse" required>
                  </div>
                  <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>
                <div id="result" class="mt-3"></div>
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

  function displayMessage(message, isSuccess) {
    const resultDiv = document.getElementById('result');
    resultDiv.textContent = message;
    resultDiv.className = isSuccess ? 'alert alert-success' : 'alert alert-danger';
  }

  // Charger types de clients
  (function () {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', baseUrl + '/client/typeclient', true);
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        const data = JSON.parse(xhr.responseText);
        const select = document.getElementById('id_type_client');
        data.forEach(t => {
          const opt = document.createElement('option');
          opt.value = t.id;
          opt.textContent = t.libelle;
          select.appendChild(opt);
        });
      }
    };
    xhr.send();
  })();

  // Envoi du formulaire
  document.getElementById('client-form').addEventListener('submit', function (e) {
    e.preventDefault();
    const form = e.target;
    const formData = {
      id_type_client: form.id_type_client.value,
      nom: form.nom.value,
      prenom: form.prenom.value,
      email: form.email.value,
      telephone: form.telephone.value,
      adresse: form.adresse.value
    };
    const xhr = new XMLHttpRequest();
    xhr.open('POST', baseUrl + '/clients', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
        try {
          const response = JSON.parse(xhr.responseText);
          if (xhr.status === 200 && response.success) {
            displayMessage(response.message || 'Client ajouté avec succès', true);
            form.reset();
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
</script>
</body>
</html>