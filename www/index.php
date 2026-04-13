<?php
define('BASE_PATH', __DIR__);

require_once "config/database.php";
require_once "app/config/database.php";

session_start();

function requireAdmin() {
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
        header("Location: index.php?action=login");
        exit;
    }
}

function requireLogin() {
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?action=login");
        exit;
    }
}

function isLoggedIn(): bool {
    return isset($_SESSION['usuario']);
}

function isAdmin(): bool {
    return isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'admin';
}

function isTecnico(): bool {
    return isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'tecnico';
}

require_once "app/controllers/AuthController.php";
$controller = new AuthController();

$action = $_GET['action'] ?? null;

if ($action == "registro") {
    $controller->registro();
    require "app/Views/auth/registro.php";

} elseif ($action == "login") {
    $error = $controller->login();
    require "app/Views/auth/login.php";

} elseif ($action == "dashboard") {
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?action=login");
        exit;
    }
    $rol = $_SESSION['usuario']['rol'];
    if ($rol == 'admin') {
        require "app/Views/dashboard/admin.php";
    } elseif ($rol == 'tecnico') {
        require "app/Views/dashboard/tecnico.php";
    } else {
        require "app/Views/dashboard/cliente.php";
    }

} elseif ($action == "perfil") {
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?action=login");
        exit;
    }
    require_once "app/Controllers/UsuarioController.php";
    $userController = new UsuarioController();
    $userController->actualizar();
    require "app/Views/perfil/perfil.php";

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

} elseif ($action == "panel_admin") {
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?action=login");
        exit;
    }
    require_once "app/Controllers/AdminController.php";
    $adminController = new AdminController();
    $adminController->index();

} elseif ($action == "crear_aviso") {
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?action=login");
        exit;
    }
    require_once "app/Controllers/AdminController.php";
    $adminController = new AdminController();
    $adminController->crear();

} elseif ($action == "editar_aviso") {
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?action=login");
        exit;
    }
    require_once "app/Controllers/AdminController.php";
    $adminController = new AdminController();
    $adminController->editar($_GET['id'] ?? 0);

} elseif ($action == "cancelar_aviso") {
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?action=login");
        exit;
    }
    require_once "app/Controllers/AdminController.php";
    $adminController = new AdminController();
    $adminController->cancelar($_GET['id'] ?? 0);

} elseif ($action == "asignar_tecnico") {
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?action=login");
        exit;
    }
    require_once "app/Controllers/AdminController.php";
    $adminController = new AdminController();
    $adminController->asignarTecnico();

} elseif ($action == "calendario") {
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?action=login");
        exit;
    }
    require_once "app/Controllers/AdminController.php";
    $adminController = new AdminController();
    $adminController->calendario();

} elseif ($action == "tecnicos") {
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?action=login");
        exit;
    }
    require_once "app/Models/Tecnico.php";
    require_once "app/Models/TipoServicio.php";
    require_once "app/Controllers/TecnicoController.php";
    $tecnicoController = new TecnicoController();
    $tecnicoController->index();

} elseif ($action == "crear_tecnico") {
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?action=login");
        exit;
    }
    require_once "app/Models/Tecnico.php";
    require_once "app/Controllers/TecnicoController.php";
    $tecnicoController = new TecnicoController();
    $tecnicoController->crear();

} elseif ($action == "editar_tecnico") {
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?action=login");
        exit;
    }
    require_once "app/Models/Tecnico.php";
    require_once "app/Controllers/TecnicoController.php";
    $tecnicoController = new TecnicoController();
    $tecnicoController->editar((int)($_GET['id'] ?? 0));

} elseif ($action == "eliminar_tecnico") {
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?action=login");
        exit;
    }
    require_once "app/Models/Tecnico.php";
    require_once "app/Controllers/TecnicoController.php";
    $tecnicoController = new TecnicoController();
    $tecnicoController->eliminar((int)($_GET['id'] ?? 0));

} elseif ($action == "tipos_servicio") {
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?action=login");
        exit;
    }
    require_once "app/Models/TipoServicio.php";
    require_once "app/Controllers/ServicioController.php";
    $servicioController = new ServicioController();
    $servicioController->index();

} elseif ($action == "crear_tipo_servicio") {
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?action=login");
        exit;
    }
    require_once "app/Models/TipoServicio.php";
    require_once "app/Controllers/ServicioController.php";
    $servicioController = new ServicioController();
    $servicioController->crear();

} elseif ($action == "editar_tipo_servicio") {
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?action=login");
        exit;
    }
    require_once "app/Models/TipoServicio.php";
    require_once "app/Controllers/ServicioController.php";
    $servicioController = new ServicioController();
    $servicioController->editar((int)($_GET['id'] ?? 0));

} elseif ($action == "eliminar_tipo_servicio") {
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?action=login");
        exit;
    }
    require_once "app/Models/TipoServicio.php";
    require_once "app/Controllers/ServicioController.php";
    $servicioController = new ServicioController();
    $servicioController->eliminar((int)($_GET['id'] ?? 0));

} elseif ($action == "agenda") {
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?action=login");
        exit;
    }
    require_once "app/Models/Tecnico.php";
    require_once "app/Controllers/TecnicoController.php";
    $tecnicoController = new TecnicoController();
    $tecnicoController->agenda();

} else {
    if (isset($_SESSION['usuario'])) {
        header("Location: index.php?action=dashboard");
        exit;
    }
    require "app/Views/layouts/home.php";
}