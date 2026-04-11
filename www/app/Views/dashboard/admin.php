<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>
<div class="container">
    <h1>Panel ADMIN</h1>
    <p style="margin-bottom:20px;">Bienvenido, <?= htmlspecialchars($_SESSION['usuario']['nombre']) ?>.</p>
    <div style="display:flex; gap:15px; flex-wrap:wrap;">
        <a href="index.php?action=panel_admin" class="btn">Gestión de Avisos</a>
        <a href="index.php?action=calendario" class="btn">Calendario</a>
        <a href="index.php?action=tecnicos" class="btn">Gestión de Técnicos</a>
        <a href="index.php?action=perfil" class="btn">Editar Perfil</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</div>
<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>