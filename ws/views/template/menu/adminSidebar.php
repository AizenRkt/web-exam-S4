<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href="<?= Flight::get('flight.base_url') ?>/"><img style="width: 250px; height:auto" src="<?= Flight::get('flight.base_url') ?>/public/img/logo.png" alt="logo" srcset=""></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu"> 
                <li class="sidebar-title">Pret</li>
                    <li class="sidebar-item">
                        <a href="<?= Flight::get('flight.base_url') ?>/graphBenefice" class='sidebar-link'>
                            <i class="bi bi-bar-chart-line"></i>
                            <span>graphiques des intérêts</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="<?= Flight::get('flight.base_url') ?>/demande-pret" class='sidebar-link'>
                            <i class="bi bi-person-lines-fill"></i>
                            <span>Demande</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="<?= Flight::get('flight.base_url') ?>/prets/validation" class='sidebar-link'>
                            <i class="bi bi-hourglass-split"></i>
                            <span>Non traités</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="<?= Flight::get('flight.base_url') ?>/listePret" class='sidebar-link'>
                            <i class="bi bi-file-earmark-check"></i>
                            <span>Prêts validés</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="<?= Flight::get('flight.base_url') ?>/creationTypePret" class='sidebar-link'>
                            <i class="bi bi-ui-checks"></i>
                            <span>Créer des Types à intérêt variables</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="<?= Flight::get('flight.base_url') ?>/creationTypePret" class='sidebar-link'>
                            <i class="bi bi-calculator"></i>
                            <span>simulation de prêt</span>
                        </a>
                    </li>

                <li class="sidebar-title">Fond</li>
                    <li class="sidebar-item">
                        <a href="<?= Flight::get('flight.base_url') ?>/typeinvestissement/add" class='sidebar-link'>
                            <i class="bi bi-bank"></i>
                            <span>Ajouter type de fond</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a href="<?= Flight::get('flight.base_url') ?>/investissement/add" class='sidebar-link'>
                            <i class="bi bi-wallet2"></i>
                            <span>Ajouter dans le solde</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a href="<?= Flight::get('flight.base_url') ?>/investissement/list" class='sidebar-link'>
                            <i class="bi bi-journal-text"></i>
                            <span>Liste des transactions</span>
                        </a>
                    </li>


                <li class="sidebar-title">Client</li>
                    <li class="sidebar-item">
                        <a href="<?= Flight::get('flight.base_url') ?>/typeclients/add" class='sidebar-link'>
                            <i class="bi bi-person-badge"></i>
                            <span>Ajouter type de client</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a href="<?= Flight::get('flight.base_url') ?>/client/add" class='sidebar-link'>
                            <i class="bi bi-person-plus"></i>
                            <span>Ajouter client</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a href="<?= Flight::get('flight.base_url') ?>/client/list" class='sidebar-link'>
                            <i class="bi bi-people"></i>
                            <span>Liste des clients</span>
                        </a>
                    </li> 

                <li class="sidebar-title">paramètre</li> 
                    <li class="sidebar-item">
                        <a href="<?= Flight::get('flight.base_url') ?>/" class='sidebar-link'>
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Déconnexion</span>
                        </a>
                    </li>

            </ul>
        </div>
    </div>
</div>