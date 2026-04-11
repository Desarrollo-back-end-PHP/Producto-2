<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>
<div class="container">
    <h1>Editar Técnico</h1>

    <?php if (isset($_GET['error'])): ?>
        <p class="error">El nombre del técnico es obligatorio.</p>
    <?php endif; ?>

    <form method="POST" action="/index.php?action=editar_tecnico&id=<?= $tecnico['id'] ?>">
        <label>Nombre *</label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($tecnico['nombre']) ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($tecnico['email'] ?? '') ?>">

        <label>Especialidad</label>
        <input type="text" name="especialidad" value="<?= htmlspecialchars($tecnico['especialidad'] ?? '') ?>">

        <label>Teléfono</label>
        <input type="tel" name="telefono" value="<?= htmlspecialchars($tecnico['telefono'] ?? '') ?>">

        <button type="submit">Guardar cambios</button>
        <a href="/index.php?action=tecnicos" class="btn btn-danger" style="margin-left:10px;">Cancelar</a>
    </form>
</div>
<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>
