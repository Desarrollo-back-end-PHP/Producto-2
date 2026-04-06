<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReparaYa</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/calendario.css">
</head>
<body>
<nav>
    <a href="/index.php">ReparaYa</a>
    <?php if (isLoggedIn()): ?>
        <?php if (isAdmin()): ?>
            <a href="/index.php?url=admin/index">Panel Admin</a>
            <a href="/index.php?url=admin/calendario">Calendario</a>
        <?php elseif (isTecnico()): ?>
            <a href="/index.php?url=tecnico/agenda">Mi Agenda</a>
        <?php else: ?>
            <a href="/index.php?url=incidencia/avisos">Mis Avisos</a>
            <a href="/index.php?url=incidencia/nueva">Nueva Solicitud</a>
        <?php endif; ?>
        <a href="/index.php?url=perfil/index">Mi Perfil</a>
        <a href="/index.php?url=auth/logout">Cerrar sesion</a>
    <?php else: ?>
        <a href="/index.php?url=auth/login">Login</a>
        <a href="/index.php?url=auth/registro">Registro</a>
    <?php endif; ?>
</nav>
