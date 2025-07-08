<?php
require_once __DIR__ . '/../../models/auth/Role.php';
class RoleController {
    public static function getAll() {
        $roles =Role::getAll();
        Flight::json($roles);
    }
} 