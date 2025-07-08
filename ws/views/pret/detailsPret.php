<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Détails du prêt</title>
  <style>
    body { 
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
      padding: 20px; 
      background-color: #f5f5f5;
      margin: 0;
    }
    .container {
      max-width: 800px;
      margin: 0 auto;
      background: white;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    h1 {
      color: #333;
      text-align: center;
      margin-bottom: 30px;
      border-bottom: 3px solid #2196F3;
      padding-bottom: 10px;
    }
    .section {
      margin-bottom: 30px;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 8px;
      background-color: #fafafa;
    }
    .section h2 {
      color: #2196F3;
      margin-top: 0;
      margin-bottom: 15px;
    }
    .info-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
      padding: 8px 0;
      border-bottom: 1px solid #eee;
    }
    .info-label {
      font-weight: bold;
      color: #555;
    }
    .info-value {
      color: #333;
    }
    .btn {
      display: inline-block;
      padding: 12px 24px;
      background-color: #2196F3;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      border: none;
      cursor: pointer;
      font-size: 16px;
      margin: 10px 5px;
      transition: background-color 0.3s;
    }
    .btn:hover {
      background-color: #1976D2;
    }
    .btn-secondary {
      background-color: #6c757d;
    }
    .btn-secondary:hover {
      background-color: #545b62;
    }
    .actions {
      text-align: center;
      margin-top: 30px;
      padding-top: 20px;
      border-top: 2px solid #eee;
    }
    .loading {
      text-align: center;
      padding: 40px;
      color: #666;
      font-size: 18px;
    }
  </style>
</head>
<body>

<div class="container">
  <h1>Détails du prêt</h1>
  
  <div id="loading" class="loading">
    Chargement des détails du prêt...
  </div>
  
  <div id="pret-details" style="display: none;">
    <div class="section">
      <h2>Informations du contrat</h2>
      <div class="info-row">
        <span class="info-label">Numéro de contrat:</span>
        <span class="info-value" id="numero-contrat"></span>
      </div>
      <div class="info-row">
        <span class="info-label">Date de création:</span>
        <span class="info-value" id="date-creation"></span>
      </div>
      <div class="info-row">
        <span class="info-label">Libellé:</span>
        <span class="info-value" id="libelle"></span>
      </div>
    </div>
    
    <div class="section">
      <h2>Informations du client</h2>
      <div class="info-row">
        <span class="info-label">Nom complet:</span>
        <span class="info-value" id="client-nom"></span>
      </div>
      <div class="info-row">
        <span class="info-label">Email:</span>
        <span class="info-value" id="client-email"></span>
      </div>
      <div class="info-row">
        <span class="info-label">Téléphone:</span>
        <span class="info-value" id="client-telephone"></span>
      </div>
      <div class="info-row">
        <span class="info-label">Adresse:</span>
        <span class="info-value" id="client-adresse"></span>
      </div>
    </div>
    
    <div class="section">
      <h2>Détails du prêt</h2>
      <div class="info-row">
        <span class="info-label">Type de prêt:</span>
        <span class="info-value" id="type-pret"></span>
      </div>
      <div class="info-row">
        <span class="info-label">Montant:</span>
        <span class="info-value" id="montant"></span>
      </div>
      <div class="info-row">
        <span class="info-label">Taux d'intérêt:</span>
        <span class="info-value" id="taux-interet"></span>
      </div>
      <div class="info-row">
        <span class="info-label">Nombre de mensualités:</span>
        <span class="info-value" id="nombre-mensualites"></span>
      </div>
      <div class="info-row">
        <span class="info-label">Mensualité:</span>
        <span class="info-value" id="mensualite"></span>
      </div>
    </div>
    
    <div class="actions">
      <button class="btn" onclick="telechargerPDF()">📄 Télécharger le contrat PDF</button>
      <a href="/prets/validation" class="btn btn-secondary">← Retour à la liste</a>
    </div>
  </div>
</div>

<script>
const apiBase = "http://localhost<?= Flight::request()->base ?>";
const pretId = <?= $_GET['id'] ?? 'null' ?>;

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

function formatMontant(montant) {
  return new Intl.NumberFormat('fr-FR').format(montant) + ' Ar';
}

function formatDate(dateString) {
  return new Date(dateString).toLocaleDateString('fr-FR');
}

function calculerMensualite(montant, tauxInteret, nombreMensualites) {
  const tauxMensuel = tauxInteret / 100 / 12;
  const mensualite = montant * (tauxMensuel * Math.pow(1 + tauxMensuel, nombreMensualites)) / (Math.pow(1 + tauxMensuel, nombreMensualites) - 1);
  return formatMontant(mensualite);
}

function chargerDetailsPret() {
  if (!pretId) {
    document.getElementById('loading').innerHTML = 'ID du prêt non spécifié';
    return;
  }
  
  ajax("GET", "/prets/" + pretId, null, (data) => {
    document.getElementById('loading').style.display = 'none';
    document.getElementById('pret-details').style.display = 'block';
    
    // Remplir les informations
    document.getElementById('numero-contrat').textContent = 'PRET-' + String(data.id).padStart(6, '0');
    document.getElementById('date-creation').textContent = formatDate(data.date);
    document.getElementById('libelle').textContent = data.libelle;
    document.getElementById('montant').textContent = formatMontant(data.montant);
    document.getElementById('nombre-mensualites').textContent = data.nombre_mensualite + ' mois';
    
    // Charger les détails complets pour avoir les infos client et type de prêt
    ajax("GET", "/prets/" + pretId + "/details", null, (details) => {
      document.getElementById('client-nom').textContent = details.client_nom + ' ' + details.client_prenom;
      document.getElementById('client-email').textContent = details.client_email;
      document.getElementById('client-telephone').textContent = details.client_telephone;
      document.getElementById('client-adresse').textContent = details.client_adresse;
      document.getElementById('type-pret').textContent = details.type_pret_libelle;
      document.getElementById('taux-interet').textContent = details.taux_interet + '%';
      document.getElementById('mensualite').textContent = calculerMensualite(data.montant, details.taux_interet, data.nombre_mensualite);
    });
  });
}

function telechargerPDF() {
  window.open(apiBase + "/prets/" + pretId + "/pdf", "_blank");
}

chargerDetailsPret();
</script>

</body>
</html> 