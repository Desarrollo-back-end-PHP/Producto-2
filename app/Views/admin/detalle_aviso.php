<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>
<div class="container">
    <h1>Detalle del Aviso</h1>
    <div class="card">
        <p><strong>Codigo:</strong> <?= htmlspecialchars($aviso['codigo']) ?></p>
        <p><strong>Tipo:</strong> <?= htmlspecialchars($aviso['tipo_servicio']) ?></p>
        <p><strong>Urgencia:</strong> <?= htmlspecialchars($aviso['urgencia']) ?></p>
        <p><strong>Fecha:</strong> <?= htmlspecialchars($aviso['fecha']) ?></p>
        <p><strong>Franja:</strong> <?= htmlspecialchars($aviso['franja']) ?></p>
        <p><strong>Descripcion:</strong> <?= htmlspecialchars($aviso['descripcion']) ?></p>
        <p><strong>Direccion:</strong> <?= htmlspecialchars($aviso['direccion']) ?></p>
        <p><strong>Telefono:</strong> <?= htmlspecialchars($aviso['telefono']) ?></p>
        <p><strong>Estado:</strong> <?= htmlspecialchars($aviso['estado']) ?></p>
    </div>

    <!-- Formulario editar -->
    <div class="card">
        <h2>Editar Aviso</h2>
        <form method="POST" action="/index.php?url=admin/editar/<?= $aviso['id'] ?>">
            <input type="text" name="tipo_servicio" value="<?= htmlspecialchars($aviso['tipo_servicio']) ?>" required>
            <select name="urgencia">
                <option value="estandar" <?= $aviso['urgencia']==='estandar'?'selected':'' ?>>Estandar</option>
                <option value="urgente"  <?= $aviso['urgencia']==='urgente' ?'selected':'' ?>>Urgente</option>
            </select>
            <input type="datetime-local" name="fecha" value="<?= htmlspecialchars($aviso['fecha']) ?>" required>
            <input type="text" name="franja"    value="<?= htmlspecialchars($aviso['franja']) ?>">
            <textarea name="descripcion"><?= htmlspecialchars($aviso['descripcion']) ?></textarea>
            <input type="text" name="direccion" value="<?= htmlspecialchars($aviso['direccion']) ?>" required>
            <input type="tel"  name="telefono"  value="<?= htmlspecialchars($aviso['telefono']) ?>" required>
            <button type="submit">Guardar cambios</button>
        </form>
    </div>
    <a href="/index.php?url=admin/index">Volver al panel</a>
</div>
<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>
