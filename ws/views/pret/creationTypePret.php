<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Gestion des types de prêt</title>
  <style>
    body { font-family: sans-serif; padding: 20px; }
    input, textarea, button { margin: 5px; padding: 5px; }
    table { border-collapse: collapse; width: 100%; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
  </style>
</head>
<body>

  <h1>Gestion des types de prêt</h1>

  <div>
    <input type="hidden" id="id">
    <input type="text" id="libelle" placeholder="Libellé">
    <input type="number" step="0.01" id="taux_interet" placeholder="Taux d'intérêt (%)">
    <textarea id="description" placeholder="Description" rows="2" cols="30"></textarea>
    <button onclick="ajouterOuModifier()">Ajouter / Modifier</button>
  </div>

  <table id="table-types">
    <thead>
      <tr>
        <th>ID</th><th>Libellé</th><th>Taux (%)</th><th>Description</th><th>Date</th><th>Actions</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>

  <script>
    const apiBase = "http://localhost<?= Flight::base() ?>";

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
        const tbody = document.querySelector("#table-types tbody");
        tbody.innerHTML = "";
        data.forEach(t => {
          const tr = document.createElement("tr");
          tr.innerHTML = `
            <td>${t.id}</td>
            <td>${t.libelle}</td>
            <td>${t.taux_interet ?? '-'}</td>
            <td>${t.description ?? ''}</td>
            <td>${t.date}</td>
            <td>
              <button onclick='remplirFormulaire(${JSON.stringify(t)})'>✏️</button>
              <button onclick='supprimerType(${t.id})'>🗑️</button>
            </td>
          `;
          tbody.appendChild(tr);
        });
      });
    }

    function ajouterOuModifier() {
      const id = document.getElementById("id").value;
      const libelle = document.getElementById("libelle").value;
      const taux = document.getElementById("taux_interet").value;
      const description = document.getElementById("description").value;

      const body = { libelle, taux_interet: taux, description };
      if (id) {
        ajax("PUT", `/type-prets/${id}`, body, () => {
          resetForm();
          chargerTypes();
        }, true);
      } else {
        const formData = `libelle=${encodeURIComponent(libelle)}&taux_interet=${encodeURIComponent(taux)}&description=${encodeURIComponent(description)}`;
        ajax("POST", "/type-prets", formData, () => {
          resetForm();
          chargerTypes();
        });
      }
    }

    function remplirFormulaire(t) {
      document.getElementById("id").value = t.id;
      document.getElementById("libelle").value = t.libelle;
      document.getElementById("taux_interet").value = t.taux_interet;
      document.getElementById("description").value = t.description;
    }

    function supprimerType(id) {
      if (confirm("Supprimer ce type de prêt ?")) {
        ajax("DELETE", `/type-prets/${id}`, null, () => {
          chargerTypes();
        });
      }
    }

    function resetForm() {
      document.getElementById("id").value = "";
      document.getElementById("libelle").value = "";
      document.getElementById("taux_interet").value = "";
      document.getElementById("description").value = "";
    }

    chargerTypes();
  </script>

</body>
</html>
