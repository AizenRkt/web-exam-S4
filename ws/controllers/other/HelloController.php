<?php
class HelloController {
    public static function afficher() {
        $message = "Bonjour depuis HelloController en PHP !";
        include __DIR__ . '/../../views/other/hello.php';
    }

}
