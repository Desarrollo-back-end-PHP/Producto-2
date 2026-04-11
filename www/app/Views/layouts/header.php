<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReparaYa</title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>
<nav>
    <a href="/index.php">ReparaYa</a>
    <?php if (isLoggedIn()): ?>
        <?php if (isAdmin()): ?>
            <a href="/index.php?action=panel_admin">Panel Admin</a>
            <a href="/index.php?action=calendario">Calendario</a>
            <a href="/index.php?action=tecnicos">Tecnicos</a>
        <?php elseif (isTecnico()): ?>
            <a href="/index.php?action=agenda">Mi Agenda</a>
        <?php else: ?>
            <a href="/index.php?action=mis_avisos">Mis Avisos</a>
            <a href="/index.php?action=nueva_solicitud">Nueva Solicitud</a>
        <?php endif; ?>
        <a href="/index.php?action=perfil">Mi Perfil</a>
        <a href="/logout.php">Cerrar sesion</a>
    <?php else: ?>
        <a href="/index.php?action=login">Login</a>
        <a href="/index.php?action=registro">Registro</a>
    <?php endif; ?>
</nav>