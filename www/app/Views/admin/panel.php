<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>
<div class="container">
    <h1>Panel de Administración</h1>

    <div style="background:#f9f9f9; padding:20px; border-radius:8px; margin-bottom:30px;">
        <h2>Nuevo Aviso</h2>
        <form method="POST" action="/index.php?action=crear_aviso">
            <input type="text" name="tipo_servicio" placeholder="Tipo de servicio (fontanería, electricidad...)" required>
            <select name="urgencia">
                <option value="estandar">Estándar</option>
                <option value="urgente">Urgente (24h)</option>
            </select>
            <input type="datetime-local" name="fecha" required>
            <input type="text" name="franja" placeholder="Franja horaria (ej: 9:00-11:00)">
            <textarea name="descripcion" placeholder="Descripción de la avería" required></textarea>
            <input type="text" name="direccion" placeholder="Dirección" required>
            <input type="tel" name="telefono" placeholder="Teléfono" required>
            <button type="submit">Crear Aviso</button>
        </form>
    </div>

    <div>
        <h2>Avisos</h2>
        <a href="/index.php?action=calendario" class="btn" style="margin-bottom:15px; display:inline-block;">Ver Calendario</a>
        <table>
            <thead>
                <tr>
                    <th>Código</th><th>Tipo</th><th>Urgencia</th>
                    <th>Fecha</th><th>Estado</th><th>Técnico</th><th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php if(empty($avisos)): ?>
                <tr><td colspan="7" style="text-align:center;">No hay avisos registrados</td></tr>
            <?php else: ?>
            <?php foreach ($avisos as $aviso): ?>
                <tr>
                    <td><?= htmlspecialchars($aviso['codigo']) ?></td>
                    <td><?= htmlspecialchars($aviso['tipo_servicio']) ?></td>
                    <td>
                        <span class="<?= $aviso['urgencia'] === 'urgente' ? 'urgente' : 'estandar' ?>">
                            <?= htmlspecialchars($aviso['urgencia']) ?>
                        </span>
                    </td>
                    <td><?= htmlspecialchars($aviso['fecha']) ?></td>
                    <td><?= htmlspecialchars($aviso['estado']) ?></td>
                    <td>
                        <form method="POST" action="/index.php?action=asignar_tecnico">
                            <input type="hidden" name="aviso_id" value="<?= $aviso['id'] ?>">
                            <select name="tecnico_id">
                                <option value="">Sin asignar</option>
                                <?php foreach ($tecnicos as $t): ?>
                                    <option value="<?= $t['id'] ?>" <?= $aviso['tecnico_id'] == $t['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($t['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit">Asignar</button>
                        </form>
                    </td>
                    <td style="display:flex; gap:5px;">
                        <a href="/index.php?action=editar_aviso&id=<?= $aviso['id'] ?>" class="btn">Ver</a>
                        <a href="/index.php?action=editar_aviso&id=<?= $aviso['id'] ?>" class="btn">Editar</a>
                        <a href="/index.php?action=cancelar_aviso&id=<?= $aviso['id'] ?>" class="btn btn-danger" onclick="return confirm('¿Cancelar este aviso?')">Cancelar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>