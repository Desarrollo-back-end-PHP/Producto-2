<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>
<div class="container">
    <h1>Mi Agenda</h1>

    <?php if (!$tecnico): ?>
        <p class="error">No se encontró un perfil de técnico asociado a tu cuenta. Contacta con el administrador.</p>
    <?php else: ?>
        <p style="margin-bottom:20px;">
            Bienvenido, <strong><?= htmlspecialchars($tecnico['nombre']) ?></strong>.
            Especialidad: <?= htmlspecialchars($tecnico['especialidad'] ?? 'No especificada') ?>
        </p>

        <?php if (empty($avisos)): ?>
            <p>No tienes avisos asignados actualmente.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Tipo</th>
                        <th>Urgencia</th>
                        <th>Fecha</th>
                        <th>Franja</th>
                        <th>Dirección</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Cliente</th>
                    </tr>
                </thead>
                <tbody>
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
                    <td><?= htmlspecialchars($aviso['franja'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($aviso['direccion']) ?></td>
                    <td><?= htmlspecialchars($aviso['descripcion']) ?></td>
                    <td><?= htmlspecialchars($aviso['estado']) ?></td>
                    <td><?= htmlspecialchars($aviso['nombre_cliente'] ?? '-') ?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>
