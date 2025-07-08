<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Intérêts Gagnés - Établissement Financier</title>
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/compiled/css/app.css">
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/compiled/css/iconly.css">
</head>
<body>
    <div id="app">
        <?php Flight::render('template/menu/adminSidebar'); ?>
        <div id="main" class="p-4">
            <h3>Intérêts Gagnés (par Mois)</h3>

            <form id="filtre-form" class="mb-4">
                <label>Mois/Année début :</label>
                <input type="month" name="debut" required>
                <label>Mois/Année fin :</label>
                <input type="month" name="fin" required>
                <button type="submit" class="btn btn-primary btn-sm">Filtrer</button>
            </form>

            <table id="table-interets" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Mois</th>
                        <th>Intérêt total</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

            <canvas id="graph-interets" width="600" height="300"></canvas>
        </div>
    </div>

    <script src="<?= Flight::get('flight.base_url') ?>/public/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?= Flight::get('flight.base_url') ?>/public/assets/compiled/js/app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.getElementById('filtre-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const debut = this.debut.value + "-01";
            const fin = this.fin.value + "-31";

            const res = await fetch("<?= Flight::get('flight.base_url') ?>/ws/interets?debut=" + debut + "&fin=" + fin);
            const data = await res.json();

            const tbody = document.querySelector("#table-interets tbody");
            tbody.innerHTML = "";

            const labels = [], values = [];
            data.forEach(row => {
                labels.push(row.mois_annee);
                values.push(parseFloat(row.total_interet).toFixed(2));
                tbody.innerHTML += `
                    <tr>
                        <td>${row.mois_annee}</td>
                        <td>${parseFloat(row.total_interet).toLocaleString('fr-FR')} Ar</td>
                    </tr>
                `;
            });

            const ctx = document.getElementById('graph-interets').getContext('2d');
            if (window.interetChart) window.interetChart.destroy(); // éviter superposition

            window.interetChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels,
                    datasets: [{
                        label: 'Intérêts gagnés',
                        data: values,
                        backgroundColor: 'rgba(75, 192, 192, 0.7)'
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
