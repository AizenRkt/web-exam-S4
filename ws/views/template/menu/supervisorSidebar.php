<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href="<?= Flight::base() ?>/"><img style="width: 250px; height:auto" src="<?= Flight::base() ?>/public/img/logo.png" alt="logo" srcset=""></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu"> 
                <li class="sidebar-item">
                    <a href="<?= Flight::base() ?>/materiel-salle" class='sidebar-link'>
                        <i class="bi bi-box-seam"></i>
                        <span>suivi matériel et salle</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="<?= Flight::base() ?>/declaration-accident" class='sidebar-link'>
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <span>déclaration accident</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="<?= Flight::base() ?>/pointage-professeur" class='sidebar-link'>
                        <i class="bi bi-fingerprint"></i>
                        <span>pointage professeur</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="<?= Flight::base() ?>/inscription-eleve" class='sidebar-link'>
                        <i class="bi bi-person-plus-fill"></i>
                        <span>inscription élève</span>
                    </a>
                </li>

                <!-- <li class="sidebar-item  has-sub">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-table"></i>
                        <span>Table des suivis</span>
                    </a>
                
                    <ul class="submenu submenu-closed" style="--submenu-height: 86px;">
                        <li class="submenu-item  ">
                            <a href="<?= Flight::base() ?>/liste/District" class="submenu-link">districtes</a>
                        </li>
                        <li class="submenu-item  ">
                            <a href="<?= Flight::base() ?>/liste/Commune" class="submenu-link">communes</a>
                        </li>
                    </ul>
                </li>   -->
            </ul>
        </div>
    </div>
</div>
