<?php
$host = $_ENV['DB_HOST'] ?? 'db';
$db   = $_ENV['DB_NAME'] ?? 'reparaya';
$user = $_ENV['DB_USER'] ?? 'user';
$pass = $_ENV['DB_PASS'] ?? 'pass';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    die('Error de conexion: ' . $e->getMessage());
}
