<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>
<div class="container">
    <h1>Tipos de Servicio</h1>

    <?php if (isset($_GET['exito'])): ?>
        <p class="success">
            <?php if ($_GET['exito'] === 'creado') echo 'Tipo de servicio añadido correctamente.'; ?>
            <?php if ($_GET['exito'] === 'editado') echo 'Tipo de servicio actualizado correctamente.'; ?>
            <?php if ($_GET['exito'] === 'eliminado') echo 'Tipo de servicio eliminado correctamente.'; ?>
        </p>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <p class="error">El nombre del tipo de servicio es obligatorio.</p>
    <?php endif; ?>

    <!-- Formulario nuevo tipo de servicio -->
    <div style="background:#f9f9f9; padding:20px; border-radius:8px; margin-bottom:30px;">
        <h2>Añadir Tipo de Servicio</h2>
        <form method="POST" action="/index.php?action=crear_tipo_servicio">
            <input type="text" name="nombre" placeholder="Nombre del servicio (ej: Fontanería) *" required>
            <textarea name="descripcion" placeholder="Descripción (opcional)"></textarea>
            <button type="submit">Añadir</button>
        </form>
    </div>

    <!-- Listado -->
    <div>
        <h2>Servicios disponibles</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($tiposServicio)): ?>
                <tr><td colspan="3" style="text-align:center;">No hay tipos de servicio registrados</td></tr>
            <?php else: ?>
                <?php foreach ($tiposServicio as $ts): ?>
                <tr>
                    <td><?= htmlspecialchars($ts['nombre']) ?></td>
                    <td><?= htmlspecialchars($ts['descripcion'] ?? '-') ?></td>
                    <td style="display:flex; gap:5px;">
                        <a href="/index.php?action=editar_tipo_servicio&id=<?= $ts['id'] ?>" class="btn">Editar</a>
                        <a href="/index.php?action=eliminar_tipo_servicio&id=<?= $ts['id'] ?>"
                           class="btn btn-danger"
                           onclick="return confirm('¿Eliminar este tipo de servicio?')">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px;">
        <a href="/index.php?action=tecnicos" class="btn">Gestionar Técnicos</a>
        <a href="/index.php?action=panel_admin" class="btn" style="margin-left:10px;">Volver al Panel</a>
    </div>
</div>
<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>
