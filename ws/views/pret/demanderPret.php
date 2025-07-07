<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Demande de prêt client</title>
  <style>
    body { font-family: sans-serif; padding: 20px; }
    input, select, button { margin: 5px; padding: 5px; }
    table { border-collapse: collapse; width: 100%; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
  </style>
</head>
<body>

  <h1>Demande de prêt client</h1>

  <div>
    <input type="text" id="libelle" placeholder="Libellé du prêt">
    <input type="number" step="0.01" id="montant" placeholder="Montant">
    <input type="number" id="mensualites" placeholder="Nombre de mensualités">
    <input type="number" id="id_client" placeholder="ID Client">
    
    <select id="type_pret_select">
      <option value="">-- Sélectionner un type de prêt --</option>
    </select>

    <button onclick="envoyerDemande()">Soumettre la demande</button>
  </div>

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

    function envoyerDemande() {
      const libelle = document.getElementById("libelle").value;
      const montant = parseFloat(document.getElementById("montant").value);
      const mensualites = parseInt(document.getElementById("mensualites").value);
      const id_client = parseInt(document.getElementById("id_client").value);
      const id_type_pret = parseInt(document.getElementById("type_pret_select").value);

      if (!libelle || !montant || !mensualites || !id_client || !id_type_pret) {
        alert("Veuillez remplir tous les champs !");
        return;
      }

      const body = {
        libelle,
        montant,
        nombre_mensualite: mensualites,
        id_client,
        id_type_pret
      };

      ajax("POST", "/prets", body, (resp) => {
        alert("Demande de prêt enregistrée !");
        // Tu peux aussi vider les champs ici
      }, true);
    }

    chargerTypes();
  </script>

</body>
</html>
