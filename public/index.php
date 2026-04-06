<?php
session_start();
define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/app/config/database.php';
require_once BASE_PATH . '/app/helpers/auth.php';

$url    = $_GET['url'] ?? 'home';
$url    = rtrim($url, '/');
$parts  = explode('/', $url);

$controllerName = ucfirst($parts[0] ?? 'home') . 'Controller';
$method         = $parts[1] ?? 'index';
$param          = $parts[2] ?? null;

$controllerFile = BASE_PATH . '/app/Controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controller = new $controllerName();
    if (method_exists($controller, $method)) {
        $controller->$method($param);
    } else {
        http_response_code(404);
        echo "Metodo no encontrado";
    }
} else {
    require_once BASE_PATH . '/app/Views/layouts/home.php';
}
