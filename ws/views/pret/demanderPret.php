<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Demande de prêt client</title>

  <link rel="shortcut icon" href="<?= Flight::get('flight.base_url') ?>/public/assets/compiled/svg/favicon.svg" type="image/x-icon" />
  <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/compiled/css/app.css" />
  <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/compiled/css/iconly.css" />
</head>
<body>
  <div id="app">
    <?php Flight::render('template/menu/adminSidebar'); ?>
    <main id="main" class="content-wrapper">
      <div class="page-heading">
        <h3>Demande de prêt client</h3>
      </div>

      <section class="section">
        <div class="card">
          <div class="card-body">
            <form id="demandePretForm" onsubmit="envoyerDemande(); return false;">
              <div class="row g-3">
                <div class="col-md-6">
                  <label for="libelle" class="form-label">Libellé du prêt</label>
                  <input type="text" id="libelle" class="form-control" placeholder="Libellé du prêt" required />
                </div>
                <div class="col-md-6">
                  <label for="montant" class="form-label">Montant</label>
                  <input type="number" step="0.01" id="montant" class="form-control" placeholder="Montant" required />
                </div>
                <div class="col-md-4">
                  <label for="mensualites" class="form-label">Nombre de mensualités</label>
                  <input type="number" id="mensualites" class="form-control" placeholder="Nombre de mensualités" required />
                </div>
                <div class="col-md-4">
                  <label for="delai_remboursement" class="form-label">Délai de remboursement (mois)</label>
                  <input type="number" id="delai_remboursement" class="form-control" placeholder="Délai de remboursement (mois)" required />
                </div>
                <div class="col-md-4">
                    <label for="id_client_select" class="form-label">Client</label>
                    <select id="id_client_select" class="form-select" required>
                        <option value="">-- Sélectionner un client --</option>
                    </select>
                </div>
                <div class="col-md-6">
                  <label for="type_pret_select" class="form-label">Type de prêt</label>
                  <select id="type_pret_select" class="form-select" required>
                    <option value="">-- Sélectionner un type de prêt --</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="type_payement_select" class="form-label">Type de payement</label>
                  <select id="type_payement_select" class="form-select">
                    <option value="">-- Sélectionner un type de payement --</option>
                  </select>
                </div>
              </div>

              <div class="mt-4">
                <button type="submit" class="btn btn-primary">Soumettre la demande</button>
              </div>
            </form>
          </div>
        </div>
      </section>
    </main>
  </div>

  <script src="<?= Flight::get('flight.base_url') ?>/public/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <script src="<?= Flight::get('flight.base_url') ?>/public/assets/compiled/js/app.js"></script>
  <script>
    const apiBase = "<?= Flight::request()->base ?>";

    function ajax(method, url, data, callback, sendJson = false) {
      const xhr = new XMLHttpRequest();
      xhr.open(method, apiBase + url, true);
      xhr.setRequestHeader("Content-Type", sendJson ? "application/json" : "application/x-www-form-urlencoded");
      xhr.onreadystatechange = () => {
        if (xhr.readyState === 4 && xhr.status === 200) {
          callback(JSON.parse(xhr.responseText));
        }
      };
      if (sendJson && data) {
        xhr.send(JSON.stringify(data));
      } else {
        xhr.send(data);
      }
    }

    function chargerTypes() {
      ajax("GET", "/type-prets", null, (data) => {
        const select = document.getElementById("type_pret_select");
        data.forEach(t => {
          const option = document.createElement("option");
          option.value = t.id;
          option.textContent = `${t.libelle} (${t.taux_interet ?? 0}% intérêt)`;
          select.appendChild(option);
        });
      });
    }

    function chargerTypesPayement() {
      ajax("GET", "/typepayements", null, (data) => {
        const select = document.getElementById("type_payement_select");
        data.forEach(t => {
          const option = document.createElement("option");
          option.value = t.id;
          option.textContent = `${t.libelle}`;
          select.appendChild(option);
        });
      });
    }

    function chargerClients() {
        ajax("GET", "/clients", null, (data) => {
            const select = document.getElementById("id_client_select");
            data.forEach(client => {
            const option = document.createElement("option");
            option.value = client.id;
            option.textContent = client.nom + (client.prenom ? " " + client.prenom : "");
            select.appendChild(option);
            });
        });
    }

    function envoyerDemande() {
        const libelle = document.getElementById("libelle").value.trim();
        const montant = parseFloat(document.getElementById("montant").value);
        const mensualites = parseInt(document.getElementById("mensualites").value);
        const delai = parseInt(document.getElementById("delai_remboursement").value);
        const id_client = parseInt(document.getElementById("id_client_select").value);
        const id_type_pret = parseInt(document.getElementById("type_pret_select").value);
        const id_type_payement = parseInt(document.getElementById("type_payement_select").value);

        if (!libelle || isNaN(montant) || isNaN(mensualites) || isNaN(delai) || isNaN(id_client) || isNaN(id_type_pret)) {
            alert("Veuillez remplir tous les champs obligatoires !");
            return;
        }

        const body = {
            libelle,
            montant,
            nombre_mensualite: mensualites,
            delai_remboursement: delai,
            id_client,
            id_type_pret,
            id_type_payement: id_type_payement || null
        };

        ajax("POST", "/prets", body, (resp) => {
            alert("Demande de prêt enregistrée !");
            document.getElementById("demandePretForm").reset();
        }, true);
    }

    chargerClients();
    chargerTypesPayement();
    chargerTypes();
  </script>
</body>
</html>
