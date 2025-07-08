<?php

class AuthController {
    public static function login() {
        include __DIR__ . '/../../views/template/auth/login.php';

    }

    public static function signin() {
        include __DIR__ . '/../../views/template/auth/sigin.php';
    }
}