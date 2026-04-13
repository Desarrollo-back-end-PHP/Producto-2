<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>
<div class="container">
    <h1>Bienvenido, <?= htmlspecialchars($_SESSION['usuario']['nombre']) ?></h1>
    <p style="margin-bottom:30px; color:#666;">Gestiona tus solicitudes de reparación desde aquí.</p>

    <div style="display:flex; gap:20px; flex-wrap:wrap;">
        <a href="index.php?action=nueva_solicitud" class="btn btn-success" style="padding:20px 30px; font-size:16px;">
            Nueva Solicitud
        </a>
        <a href="index.php?action=mis_avisos" class="btn" style="padding:20px 30px; font-size:16px;">
            Mis Avisos
        </a>
        <a href="index.php?action=perfil" class="btn" style="padding:20px 30px; font-size:16px;">
            Editar Perfil
        </a>
        <a href="logout.php" class="btn btn-danger" style="padding:20px 30px; font-size:16px;">
            Cerrar Sesión
        </a>
    </div>
</div>
<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>