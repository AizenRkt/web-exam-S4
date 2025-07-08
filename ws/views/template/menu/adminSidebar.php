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
                        <a href="<?= Flight::get('flight.base_url') ?>/demande-pret" class='sidebar-link'>
                            <i class="bi bi-person-lines-fill"></i> <!-- Plus adapté pour une demande de prêt individuelle -->
                            <span>Demande de prêt</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="<?= Flight::get('flight.base_url') ?>/prets/validation" class='sidebar-link'>
                            <i class="bi bi-hourglass-split"></i> <!-- Pour représenter un traitement en attente -->
                            <span>Prêts non traités</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="<?= Flight::get('flight.base_url') ?>/creationTypePret" class='sidebar-link'>
                            <i class="bi bi-ui-checks"></i> <!-- Pour la création/gestion de types de prêt -->
                            <span>Créer des types de prêt</span>
                        </a>
                    </li>

                <li class="sidebar-title">Fond</li>
                <li class="sidebar-item  has-sub">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-building"></i>
                        <span>salle</span>
                    </a>
                
                    <ul class="submenu submenu-closed" style="--submenu-height: 86px;">
                        <li class="submenu-item  ">
                            <a href="<?= Flight::get('flight.base_url') ?>/dashboard" class="submenu-link">dashboard</a>
                        </li>
                        <li class="submenu-item  ">
                            <a href="<?= Flight::get('flight.base_url') ?>/materiel" class="submenu-link">matériel</a>
                        </li>
                        <li class="submenu-item  ">
                            <a href="<?= Flight::get('flight.base_url') ?>/stock" class="submenu-link">stock matériel</a>
                        </li>
                        <li class="submenu-item  ">
                            <a href="<?= Flight::get('flight.base_url') ?>/suivi-salle" class="submenu-link">suivi salle</a>
                        </li>
                        <li class="submenu-item  ">
                            <a href="<?= Flight::get('flight.base_url') ?>/facturation/liste" class="submenu-link">facturation</a>
                        </li>
                    </ul>
                </li>  
            </ul>
        </div>
    </div>
</div>