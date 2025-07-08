<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Validation des prêts</title>
  <style>
    body { font-family: sans-serif; padding: 20px; }
    button { margin: 5px; padding: 5px; }
    table { border-collapse: collapse; width: 100%; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
  </style>
</head>
<body>

<h1>Validation des prêts</h1>

<table id="table-prets">
  <thead>
    <tr>
      <th>ID</th><th>Libellé</th><th>Montant</th><th>Client</th><th>Mensualités</th><th>Date</th><th>Actions</th>
    </tr>
  </thead>
  <tbody></tbody>
</table>

<script>
const apiBase = "http://localhost<?= Flight::request()->base ?>";

function ajax(method, url, data, callback, sendJson = false) {
  const xhr = new XMLHttpRequest();
  xhr.open(method, apiBase + url, true);
  xhr.setRequestHeader("Content-Type", sendJson ? "application/json" : "application/x-www-form-urlencoded");
  xhr.onreadystatechange = () => {
    if (xhr.readyState === 4 && xhr.status === 200) {
      callback(JSON.parse(xhr.responseText));
    }
  };
  if (sendJson && data) xhr.send(JSON.stringify(data));
  else xhr.send(data);
}

function chargerPrets() {
  ajax("GET", "/pretsNonTraite", null, (data) => {
    const tbody = document.querySelector("#table-prets tbody");
    tbody.innerHTML = "";
    data.forEach(p => {
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td>${p.id}</td>
        <td>${p.libelle}</td>
        <td>${p.montant}</td>
        <td>${p.id_client}</td>
        <td>${p.nombre_mensualite}</td>
        <td>${p.date}</td>
        <td>
          <button onclick="validerPret(${p.id}, 1)">✅ Valider</button>
          <button onclick="rejeterPret(${p.id}, 1)">❌ Rejeter</button>
        </td>
      `;
      tbody.appendChild(tr);
    });
  });
}

function validerPret(id_pret, id_utilisateur) {
  ajax("POST", "/prets/" + id_pret + "/valider", { id_utilisateur }, () => {
    alert("Prêt validé !");
    chargerPrets();
  }, true);
}

function rejeterPret(id_pret, id_utilisateur) {
  ajax("POST", "/prets/" + id_pret + "/rejeter", { id_utilisateur }, () => {
    alert("Prêt rejeté !");
    chargerPrets();
  }, true);
}

chargerPrets();
</script>

</body>
</html>
