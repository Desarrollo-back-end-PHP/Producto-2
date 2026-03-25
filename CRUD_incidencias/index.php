<?php
session_start();

// Conexión a la base de datos
$db = new PDO(
    'mysql:host=mysql-db-p2;dbname=reparaya;charset=utf8mb4',
    'user',
    'userpass',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

require_once __DIR__ . '/Controllers/IncidenciaController.php';

$controller = new IncidenciaController($db);
$action = $_GET['action'] ?? 'mis_avisos';

switch ($action) {
    case 'nueva':
        $controller->nueva();
        break;
    case 'crear':
        $controller->crear();
        break;
    case 'cancelar':
        $controller->cancelar();
        break;
    case 'mis_avisos':
    default:
        $controller->misAvisos();
        break;
}