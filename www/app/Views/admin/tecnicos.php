<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>
<div class="container">
    <h1>Gestión de Técnicos</h1>

    <?php if (isset($_GET['exito'])): ?>
        <p class="success">
            <?php if ($_GET['exito'] === 'creado') echo 'Técnico añadido correctamente.'; ?>
            <?php if ($_GET['exito'] === 'editado') echo 'Técnico actualizado correctamente.'; ?>
            <?php if ($_GET['exito'] === 'eliminado') echo 'Técnico dado de baja correctamente.'; ?>
        </p>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <p class="error">El nombre del técnico es obligatorio.</p>
    <?php endif; ?>

    <!-- Formulario alta de técnico -->
    <div style="background:#f9f9f9; padding:20px; border-radius:8px; margin-bottom:30px;">
        <h2>Añadir Técnico</h2>
        <form method="POST" action="/index.php?action=crear_tecnico">
            <input type="text" name="nombre" placeholder="Nombre completo *" required>
            <input type="email" name="email" placeholder="Email">
            <select name="especialidad">
                <option value="">-- Seleccionar especialidad --</option>
                <?php foreach ($tiposServicio as $ts): ?>
                    <option value="<?= htmlspecialchars($ts['nombre']) ?>"><?= htmlspecialchars($ts['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
            <input type="tel" name="telefono" placeholder="Teléfono">
            <input type="password" name="password" placeholder="Contraseña de acceso (para que pueda loguearse)">
            <button type="submit">Añadir Técnico</button>
        </form>
    </div>

    <!-- Listado de técnicos -->
    <div>
        <h2>Técnicos registrados</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Especialidad</th>
                    <th>Teléfono</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($tecnicos)): ?>
                <tr><td colspan="6" style="text-align:center;">No hay técnicos registrados</td></tr>
            <?php else: ?>
                <?php foreach ($tecnicos as $t): ?>
                <tr>
                    <td><?= htmlspecialchars($t['nombre']) ?></td>
                    <td><?= htmlspecialchars($t['email'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($t['especialidad'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($t['telefono'] ?? '-') ?></td>
                    <td>
                        <?php if ($t['activo']): ?>
                            <span class="estandar">Activo</span>
                        <?php else: ?>
                            <span class="urgente">Baja</span>
                        <?php endif; ?>
                    </td>
                    <td style="display:flex; gap:5px;">
                        <a href="/index.php?action=editar_tecnico&id=<?= $t['id'] ?>" class="btn">Editar</a>
                        <?php if ($t['activo']): ?>
                        <a href="/index.php?action=eliminar_tecnico&id=<?= $t['id'] ?>"
                           class="btn btn-danger"
                           onclick="return confirm('¿Dar de baja a este técnico?')">Baja</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px;">
        <a href="/index.php?action=tipos_servicio" class="btn btn-success">Gestionar Tipos de Servicio</a>
        <a href="/index.php?action=panel_admin" class="btn" style="margin-left:10px;">Volver al Panel</a>
    </div>
</div>
<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>
