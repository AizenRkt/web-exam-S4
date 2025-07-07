<?php
require_once __DIR__ . '/../../../ws/config/config.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Inscription</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/login.css">
</head>

<body>
<div class="container-login" style="height: 700px">
    <div class="logo-box">
        <img src="<?= BASE_URL ?>/public/assets/img/Logo.png" alt="Logo" />
    </div>
    <div class="form-box ring">
        <i style="--clr:#00ff0a;"></i>
        <i style="--clr:#ff0057;"></i>
        <i style="--clr:#fffd44;"></i>

        <form id="registerForm" class="login" >
            <h2>Inscription</h2>
            <div id="erreur" style="color:red;"></div>

            <div class="inputBx">
                <input type="text" name="nom" placeholder="Nom" required>
            </div>
            <div class="inputBx">
                <input type="text" name="prenom" placeholder="Prénom" required>
            </div>
            <div class="inputBx">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="inputBx">
                <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
            </div>
            <div class="inputBx">
                <input type="text" name="telephone" placeholder="Téléphone">
            </div>
            <div class="inputBx">
                <input type="text" name="adresse" placeholder="Adresse">
            </div>
            <div class="inputBx">
                <select name="id_role" required>
                    <option value="">-- Choisir un rôle --</option>
                    <option value="1">Directeur</option>
                    <option value="2">Employé</option>
                </select>
            </div>
            <div class="inputBx">
                <input type="submit" value="S'inscrire">
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById("registerForm").addEventListener("submit", function(e) {
    e.preventDefault();

    const form = e.target;
    const data = {
        nom: form.nom.value,
        prenom: form.prenom.value,
        email: form.email.value,
        mot_de_passe: form.mot_de_passe.value,
        telephone: form.telephone.value,
        adresse: form.adresse.value,
        id_role: form.id_role.value
    };

    console.log("Données envoyées :", data);

    fetch("<?= BASE_URL ?>/signin", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(response => {
        console.log("Réponse :", response);
        if (response.success) {
            alert("Inscription réussie !");
            window.location.href = "<?= BASE_URL ?>/login";
        } else {
            document.getElementById("erreur").textContent = response.message;
        }
    })
    .catch(error => {
        console.error("Erreur serveur :", error);
        document.getElementById("erreur").textContent = "Erreur serveur.";
    });
});
</script>
</body>

</html>