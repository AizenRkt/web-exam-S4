<?php
require 'vendor/autoload.php';
require 'db.php';

Flight::set('flight.base_url', 'web-exam-S4/ws');

// menu 
Flight::map('menu', function () {
    Flight::render('template/menu/adminSidebar.php');
});

require 'routes/routes.php';

Flight::start();