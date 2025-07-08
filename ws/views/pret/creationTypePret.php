<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etablissement financier</title>
    <link rel="shortcut icon" href="<?= Flight::get('flight.base_url') ?>/public/assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACEAAAAiCAYAAADRcLDBAAAEs2lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iWE1QIENvcmUgNS41LjAiPgogPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4KICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgeG1sbnM6ZXhpZj0iaHR0cDovL25zLmFkb2JlLmNvbS9leGlmLzEuMC8iCiAgICB4bWxuczp0aWZmPSJodHRwOi8vbnMuYWRvYmUuY29tL3RpZmYvMS4wLyIKICAgIHhtbG5zOnBob3Rvc2hvcD0iaHR0cDovL25zLmFkb2JlLmNvbS9waG90b3Nob3AvMS4wLyIKICAgIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIKICAgIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIgogICAgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIKICAgZXhpZjpQaXhlbFhEaW1lbnNpb249IjMzIgogICBleGlmOlBpeGVsWURpbWVuc2lvbj0iMzQiCiAgIGV4aWY6Q29sb3JTcGFjZT0iMSIKICAgdGlmZjpJbWFnZVdpZHRoPSIzMyIKICAgdGlmZjpJbWFnZUxlbmd0aD0iMzQiCiAgIHRpZmY6UmVzb2x1dGlvblVuaXQ9IjIiCiAgIHRpZmY6WFJlc29sdXRpb249Ijk2LjAiCiAgIHRpZmY6WVJlc29sdXRpb249Ijk2LjAiCiAgIHBob3Rvc2hvcDpDb2xvck1vZGU9IjMiCiAgIHBob3Rvc2hvcDpJQ0NQcm9maWxlPSJzUkdCIElFQzYxOTY2LTIuMSIKICAgeG1wOk1vZGlmeURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiCiAgIHhtcDpNZXRhZGF0YURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiPgogICA8eG1wTU06SGlzdG9yeT4KICAgIDxyZGY6U2VxPgogICAgIDxyZGY6bGkKICAgICAgc3RFdnQ6YWN0aW9uPSJwcm9kdWNlZCIKICAgICAgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWZmaW5pdHkgRGVzaWduZXIgMS4xMC4xIgogICAgICBzdEV2dDp3aGVuPSIyMDIyLTAzLTMxVDEwOjUwOjIzKzAyOjAwIi8+CiAgICA8L3JkZjpTZXE+CiAgIDwveG1wTU06SGlzdG9yeT4KICA8L3JkZjpEZXNjcmlwdGlvbj4KIDwvcmRmOlJERj4KPC94OnhtcG1ldGE+Cjw/eHBhY2tldCBlbmQ9InIiPz5V57uAAAABgmlDQ1BzUkdCIElFQzYxOTY2LTIuMQAAKJF1kc8rRFEUxz9maORHo1hYKC9hISNGTWwsRn4VFmOUX5uZZ36oeTOv954kW2WrKLHxa8FfwFZZK0WkZClrYoOe87ypmWTO7dzzud97z+nec8ETzaiaWd4NWtYyIiNhZWZ2TvE946WZSjqoj6mmPjE1HKWkfdxR5sSbgFOr9Ll/rXoxYapQVik8oOqGJTwqPL5i6Q5vCzeo6dii8KlwpyEXFL519LjLLw6nXP5y2IhGBsFTJ6ykijhexGra0ITl5bRqmWU1fx/nJTWJ7PSUxBbxJkwijBBGYYwhBgnRQ7/MIQIE6ZIVJfK7f/MnyUmuKrPOKgZLpEhj0SnqslRPSEyKnpCRYdXp/9++msneoFu9JgwVT7b91ga+LfjetO3PQ9v+PgLvI1xkC/m5A+h7F32zoLXug38dzi4LWnwHzjeg8UGPGbFfySvuSSbh9QRqZ6H+Gqrm3Z7l9zm+h+iafNUV7O5Bu5z3L/wAdthn7QIme0YAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAJTSURBVFiF7Zi9axRBGIefEw2IdxFBRQsLWUTBaywSK4ubdSGVIY1Y6HZql8ZKCGIqwX/AYLmCgVQKfiDn7jZeEQMWfsSAHAiKqPiB5mIgELWYOW5vzc3O7niHhT/YZvY37/swM/vOzJbIqVq9uQ04CYwCI8AhYAlYAB4Dc7HnrOSJWcoJcBS4ARzQ2F4BZ2LPmTeNuykHwEWgkQGAet9QfiMZjUSt3hwD7psGTWgs9pwH1hC1enMYeA7sKwDxBqjGnvNdZzKZjqmCAKh+U1kmEwi3IEBbIsugnY5avTkEtIAtFhBrQCX2nLVehqyRqFoCAAwBh3WGLAhbgCRIYYinwLolwLqKUwwi9pxV4KUlxKKKUwxC6ZElRCPLYAJxGfhSEOCz6m8HEXvOB2CyIMSk6m8HoXQTmMkJcA2YNTHm3congOvATo3tE3A29pxbpnFzQSiQPcB55IFmFNgFfEQeahaAGZMpsIJIAZWAHcDX2HN+2cT6r39GxmvC9aPNwH5gO1BOPFuBVWAZue0vA9+A12EgjPadnhCuH1WAE8ivYAQ4ohKaagV4gvxi5oG7YSA2vApsCOH60WngKrA3R9IsvQUuhIGY00K4flQG7gHH/mLytB4C42EgfrQb0mV7us8AAMeBS8mGNMR4nwHamtBB7B4QRNdaS0M8GxDEog7iyoAguvJ0QYSBuAOcAt71Kfl7wA8DcTvZ2KtOlJEr+ByyQtqqhTyHTIeB+ONeqi3brh+VgIN0fohUgWGggizZFTplu12yW8iy/YLOGWMpDMTPXnl+Az9vj2HERYqPAAAAAElFTkSuQmCC" type="image/png">
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/compiled/css/app.css">

    <!-- modul css -->    
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/compiled/css/iconly.css">
</head>
<style>
    body { padding: 20px; }
    input, textarea, button { margin: 5px; padding: 5px; }
    table { border-collapse: collapse; width: 100%; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
</style>
<body>
    <div id="app">
        <?php Flight::render('template/menu/adminSidebar'); ?>
        <div id="main">
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
                <th>ID</th>
                <th>Libellé</th>
                <th>Taux (%)</th>
                <th>Description</th>
                <th>Date</th>
                <th>Actions</th>
              </tr>
              </thead>
            <tbody></tbody>
            </table>
        </div>
    </div>
    <script src="<?= Flight::get('flight.base_url') ?>/public/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?= Flight::get('flight.base_url') ?>/public/assets/compiled/js/app.js"></script>
</body>
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
</html>