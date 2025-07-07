<?php
function getDB() {
    $host = 'localhost';
    $dbname = 'db_s2_ETU003263';
    $username = 'root';
    $password = 'mitia';

    try {
        return new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    } catch (PDOException $e) {
        die(json_encode(['error' => $e->getMessage()]));
    }
}
