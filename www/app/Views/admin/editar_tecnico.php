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
        <select name="especialidad">
            <option value="">-- Seleccionar especialidad --</option>
            <?php foreach ($tiposServicio as $ts): ?>
                <option value="<?= htmlspecialchars($ts['nombre']) ?>"
                    <?= ($tecnico['especialidad'] === $ts['nombre']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($ts['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Teléfono</label>
        <input type="tel" name="telefono" value="<?= htmlspecialchars($tecnico['telefono'] ?? '') ?>">

        <label>Nueva contraseña de acceso (dejar en blanco para no cambiar)</label>
        <input type="password" name="password" placeholder="Nueva contraseña">

        <button type="submit">Guardar cambios</button>
        <a href="/index.php?action=tecnicos" class="btn btn-danger" style="margin-left:10px;">Cancelar</a>
    </form>
</div>
<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>
