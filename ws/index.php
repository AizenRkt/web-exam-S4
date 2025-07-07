<?php
require 'vendor/autoload.php';
require 'db.php';

Flight::set('flight.base_url', '/S4/examenS4/web-exam-S4/ws');

require 'routes/routes.php';

Flight::start();