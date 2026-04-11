<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>
<div class="container">
    <h1>Editar Tipo de Servicio</h1>

    <?php if (isset($_GET['error'])): ?>
        <p class="error">El nombre es obligatorio.</p>
    <?php endif; ?>

    <form method="POST" action="/index.php?action=editar_tipo_servicio&id=<?= $tipo['id'] ?>">
        <label>Nombre *</label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($tipo['nombre']) ?>" required>

        <label>Descripción</label>
        <textarea name="descripcion"><?= htmlspecialchars($tipo['descripcion'] ?? '') ?></textarea>

        <button type="submit">Guardar cambios</button>
        <a href="/index.php?action=tipos_servicio" class="btn btn-danger" style="margin-left:10px;">Cancelar</a>
    </form>
</div>
<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>
