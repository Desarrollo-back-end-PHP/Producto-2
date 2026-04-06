<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>
<div class="container">
    <h1>Panel de Administracion</h1>

    <!-- Formulario nuevo aviso -->
    <div class="card">
        <h2>Nuevo Aviso</h2>
        <form method="POST" action="/index.php?url=admin/crear">
            <input type="text"   name="tipo_servicio" placeholder="Tipo de servicio" required>
            <select name="urgencia">
                <option value="estandar">Estandar</option>
                <option value="urgente">Urgente (24h)</option>
            </select>
            <input type="datetime-local" name="fecha" required>
            <input type="text" name="franja" placeholder="Franja horaria">
            <textarea name="descripcion" placeholder="Descripcion de la averia" required></textarea>
            <input type="text" name="direccion" placeholder="Direccion" required>
            <input type="tel"  name="telefono"  placeholder="Telefono" required>
            <button type="submit">Crear Aviso</button>
        </form>
    </div>

    <!-- Listado de avisos -->
    <div class="card">
        <h2>Avisos</h2>
        <a href="/index.php?url=admin/calendario">Ver Calendario</a>
        <table>
            <thead>
                <tr>
                    <th>Codigo</th><th>Tipo</th><th>Urgencia</th>
                    <th>Fecha</th><th>Estado</th><th>Tecnico</th><th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($avisos as $aviso): ?>
                <tr class="<?= $aviso['urgencia'] === 'urgente' ? 'urgente' : 'estandar' ?>">
                    <td><?= htmlspecialchars($aviso['codigo']) ?></td>
                    <td><?= htmlspecialchars($aviso['tipo_servicio']) ?></td>
                    <td><?= htmlspecialchars($aviso['urgencia']) ?></td>
                    <td><?= htmlspecialchars($aviso['fecha']) ?></td>
                    <td><?= htmlspecialchars($aviso['estado']) ?></td>
                    <td>
                        <form method="POST" action="/index.php?url=admin/asignarTecnico">
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
                    <td>
                        <a href="/index.php?url=admin/detalle/<?= $aviso['id'] ?>">Ver</a>
                        <a href="/index.php?url=admin/editar/<?= $aviso['id'] ?>">Editar</a>
                        <a href="/index.php?url=admin/cancelar/<?= $aviso['id'] ?>"
                           onclick="return confirm('Cancelar este aviso?')">Cancelar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>
