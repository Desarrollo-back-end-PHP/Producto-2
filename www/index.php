<?php

// Arrancamos las sesiones (necesario si queremos que el usuario se mantenga logueado)
session_start();

require_once "app/controllers/AuthController.php";

$controller = new AuthController();

// Leemos qué acción quiere hacer el usuario (por defecto será null si acaba de entrar)
$action = $_GET['action'] ?? null;

if ($action == "registro") {

    $controller->registro();
    require "app/views/auth/registro.php";

} elseif ($action == "login") {

    // GUARDAMOS EL ERROR EN ESTA VARIABLE
    $error = $controller->login();
    
    require "app/views/auth/login.php";

} elseif ($action == "dashboard") {

    // Si intenta entrar al dashboard sin estar logueado, lo pateamos al login
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?action=login");
        exit;
    }

    // Si está logueado, miramos qué rol tiene y le mostramos su vista
    $rol = $_SESSION['usuario']['rol'];

    if ($rol == 'admin') {
        require "app/views/dashboard/admin.php";
    } elseif ($rol == 'tecnico') {
        require "app/views/dashboard/tecnico.php";
    } else {
        require "app/views/dashboard/cliente.php";
    }

} elseif ($action == "perfil") {

    // PROTECCIÓN: Si no ha iniciado sesión, lo mandamos al login
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?action=login");
        exit;
    }

    require_once "app/controllers/UsuarioController.php";

    $userController = new UsuarioController();
    $userController->actualizar();

    require "app/views/perfil/perfil.php";

} elseif ($action == "nueva_solicitud") {

    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?action=login");
        exit;
    }
    require_once "app/Controllers/IncidenciaController.php";
    $incidenciaController = new IncidenciaController();
    $incidenciaController->nueva();

} elseif ($action == "crear_incidencia") {

    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?action=login");
        exit;
    }
    require_once "app/Controllers/IncidenciaController.php";
    $incidenciaController = new IncidenciaController();
    $incidenciaController->crear();

} elseif ($action == "mis_avisos") {

    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?action=login");
        exit;
    }
    require_once "app/Controllers/IncidenciaController.php";
    $incidenciaController = new IncidenciaController();
    $incidenciaController->misAvisos();

} elseif ($action == "cancelar_incidencia") {

    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?action=login");
        exit;
    }
    require_once "app/Controllers/IncidenciaController.php";
    $incidenciaController = new IncidenciaController();
    $incidenciaController->cancelar();

} else {
    // ESTA ES LA PÁGINA DE INICIO 
    echo "<h1>Bienvenido a ReparaYa</h1>";
    echo "<p>Tu sistema de gestión de incidencias.</p>";
    echo "<a href='?action=login'>Iniciar Sesión</a> | ";
    echo "<a href='?action=registro'>Crear Cuenta</a>";
}