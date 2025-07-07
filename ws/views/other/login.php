<?php
require_once __DIR__ . '/../../../ws/config/config.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/login.css">
</head>
<body>
    <div class="container-login">
        <div class="logo-box">
            <img src="<?= BASE_URL ?>/public/assets/img/Logo.png" alt="Logo" />
        </div>

        <div class="form-box ring">
            <i style="--clr:#00ff0a;"></i>
            <i style="--clr:#ff0057;"></i>
            <i style="--clr:#fffd44;"></i>

            <form id="loginForm" class="login">
                <h2>Login</h2>

                <!-- Champ caché pour indiquer le rôle -->
                <input type="hidden" id="roleInput" name="role" value="employe">

                <div class="inputBx">
                    <input type="text" name="email" placeholder="Email" required>
                </div>

                <div class="inputBx">
                    <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
                </div>

                <div class="inputBx">
                    <input type="submit" value="Se connecter">
                </div>

                <div class="links">
                    <a href="#" id="switchRoleLink">en tant que directeur ?</a>
                    <a href="<?= BASE_URL ?>/signin">S'inscrire</a>
                </div>
                <div id="erreur" style="color:red;"></div>
            </form>
        </div>
    </div>
    <!-- Script de bascule entre dg et employe -->
    <script>
        const roleInput = document.getElementById("roleInput");
        const switchLink = document.getElementById("switchRoleLink");

        switchLink.addEventListener("click", function(e) {
            e.preventDefault();
            if (roleInput.value === "employe") {
                roleInput.value = "dg";
                switchLink.textContent = "en tant qu'employé ?";
            } else {
                roleInput.value = "employe";
                switchLink.textContent = "en tant que directeur ?";
            }
        });
    </script>
    <script>
        document.getElementById('loginForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const form = e.target;
            const data = {
                email: form.email.value.trim(),
                mot_de_passe: form.mot_de_passe.value.trim(),
                role: form.role.value.trim()
            };

            console.log("Données envoyées :", data);

            fetch("<?= BASE_URL ?>/login", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
            .then(res => {
                if (!res.ok) {
                    throw new Error("Réponse HTTP non valide");
                }
                return res.json();
            })
            .then(data => {
                console.log("✅ Réponse du serveur :", data);
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    document.getElementById("erreur").textContent = "❌ " + data.message;
                }
            })
            .catch(error => {
                console.error("❌ Erreur :", error);
                document.getElementById("erreur").textContent = "❌ Erreur de serveur.";
            });


        });
    </script>
</body>
</html>