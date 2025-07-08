<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="shortcut icon" href="<?= Flight::request()->base ?>/public/assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="<?= Flight::request()->base ?>/public/assets/compiled/css/app.css">
    <link rel="stylesheet" href="<?= Flight::request()->base ?>/public/assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="<?= Flight::request()->base ?>/public/assets/compiled/css/auth.css">
</head>

<body>
    <div id="auth">        
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="index.html"><img src="<?= Flight::request()->base ?>/public/assets/compiled/svg/logo.svg" alt="Logo"></a>
                    </div>
                    <h1 class="auth-title">Connexion</h1>
                    <p class="auth-subtitle mb-5">Veuillez saisir vos identifiants</p>

                    <form id="login-form">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="email" class="form-control form-control-xl" id="email" name="email" placeholder="Email" required>
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" id="mot_de_passe" name="mot_de_passe" placeholder="Mot de passe" required>
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <div class="form-check form-check-lg d-flex align-items-end">
                            <input class="form-check-input me-2" type="checkbox" id="rememberMe">
                            <label class="form-check-label text-gray-600" for="rememberMe">
                                Se souvenir de moi
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Se connecter</button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p class="text-gray-600">Pas encore de compte ? <a href="<?= Flight::request()->base ?>/inscription" class="font-bold">S'inscrire</a></p>
                        <p><a class="font-bold" href="/mot-de-passe-oublie">Mot de passe oublié ?</a></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">
                    <!-- Image ou contenu de droite -->
                </div>
            </div>
        </div>
    </div>

    <!-- Message d'erreur/succès -->
    <div id="message-toast" class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Notification</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="toast-message"></div>
        </div>
    </div>

    <script>
    document.getElementById('login-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const email = document.getElementById('email').value.trim();
        const mot_de_passe = document.getElementById('mot_de_passe').value;
        const rememberMe = document.getElementById('rememberMe').checked;
        const toast = new bootstrap.Toast(document.getElementById('liveToast'));
        const toastMessage = document.getElementById('toast-message');

        // Réinitialisation des états
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        toastMessage.textContent = '';
        
        // Validation côté client
        if (!email) {
            document.getElementById('email').classList.add('is-invalid');
            showToast('L\'email est requis', 'danger');
            return;
        }
        if (!mot_de_passe) {
            document.getElementById('mot_de_passe').classList.add('is-invalid');
            showToast('Le mot de passe est requis', 'danger');
            return;
        }

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '<?= BASE_URL ?? '' ?>/connexion', true);
        xhr.setRequestHeader('Content-Type', 'application/json');

        xhr.onload = function() {
            try {
                const response = JSON.parse(xhr.responseText);
                
                if (xhr.status >= 200 && xhr.status < 300) {
                    if (response.success) {
                        showToast('Connexion réussie !', 'success');
                        setTimeout(() => {
                            window.location.href = response.redirect || '/acceuil';
                        }, 1500);
                    } else {
                        showToast(response.message, 'danger');
                    }
                } else {
                    showToast(response.message || 'Erreur serveur', 'danger');
                }
            } catch (e) {
                console.error('Erreur:', e, 'Réponse:', xhr.responseText);
                showToast('Erreur de traitement de la réponse', 'danger');
            }
        };

        xhr.onerror = function() {
            showToast('Erreur réseau', 'danger');
        };

        xhr.send(JSON.stringify({
            email: email,
            mot_de_passe: mot_de_passe,
            remember_me: rememberMe
        }));
    });

    function showToast(message, type = 'info') {
        const toast = document.getElementById('liveToast');
        const toastMessage = document.getElementById('toast-message');
        
        // Changer la couleur selon le type
        toast.querySelector('.toast-header').className = `toast-header text-bg-${type}`;
        toastMessage.textContent = message;
        
        // Afficher le toast
        new bootstrap.Toast(toast).show();
    }
    </script>
    
    <!-- Scripts Bootstrap -->
    <script src="<?= Flight::request()->base ?>/public/assets/compiled/js/app.js"></script>
    <script src="<?= Flight::request()->base ?>/public/assets/compiled/js/bootstrap.js"></script>
</body>
</html>