<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Avisos — ReparaYa</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f0f2f5;
            padding: 2rem;
        }

        .container { max-width: 800px; margin: 0 auto; }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        h1 { font-size: 1.4rem; color: #1a1a2e; }

        .btn-nueva {
            background: #4f46e5;
            color: white;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .btn-nueva:hover { background: #4338ca; }

        .btn-dashboard {
            background: #6b7280;
            color: white;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .btn-dashboard:hover { background: #4b5563; }

        .botones {
            display: flex;
            gap: 0.5rem;
        }

        .alerta {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 1.2rem;
            font-size: 0.9rem;
        }

        .alerta.exito { background: #f0fdf4; border: 1px solid #86efac; color: #166534; }
        .alerta.error { background: #fef2f2; border: 1px solid #fca5a5; color: #991b1b; }

        .vacia {
            background: white;
            border-radius: 12px;
            padding: 3rem;
            text-align: center;
            color: #9ca3af;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .vacia p { margin-top: 0.5rem; font-size: 0.9rem; }

        .aviso-card {
            background: white;
            border-radius: 12px;
            padding: 1.2rem 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
        }

        .aviso-info { flex: 1; }

        .aviso-codigo {
            font-size: 0.75rem;
            font-weight: 700;
            color: #6b7280;
            letter-spacing: 0.05em;
            margin-bottom: 0.3rem;
        }

        .aviso-descripcion {
            font-size: 0.95rem;
            color: #1a1a2e;
            margin-bottom: 0.5rem;
        }

        .aviso-meta {
            font-size: 0.8rem;
            color: #9ca3af;
        }

        .badges { display: flex; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 0.5rem; }

        .badge {
            padding: 0.2rem 0.6rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-urgente   { background: #fef2f2; color: #dc2626; }
        .badge-estandar  { background: #eff6ff; color: #2563eb; }
        .badge-pendiente { background: #fefce8; color: #ca8a04; }
        .badge-asignada  { background: #f0fdf4; color: #16a34a; }
        .badge-cancelada { background: #f3f4f6; color: #6b7280; }
        .badge-completada{ background: #f0fdf4; color: #15803d; }
        .badge-en_proceso{ background: #eff6ff; color: #1d4ed8; }

        .btn-cancelar {
            background: none;
            border: 1px solid #fca5a5;
            color: #dc2626;
            padding: 0.4rem 0.9rem;
            border-radius: 8px;
            font-size: 0.8rem;
            cursor: pointer;
            white-space: nowrap;
        }

        .btn-cancelar:hover { background: #fef2f2; }
    </style>
</head>
<body>
<div class="container">

    <div class="header">
        <h1>📋 Mis Avisos</h1>
        <div class="botones">
            <a href="index.php?action=dashboard" class="btn-dashboard">← Dashboard</a>
            <a href="index.php?action=nueva_solicitud" class="btn-nueva">+ Nueva solicitud</a>
        </div>
    </div>

    <?php if (isset($_GET['exito'])): ?>
        <?php if ($_GET['exito'] === '1'): ?>
            <div class="alerta exito">✅ Solicitud enviada correctamente.</div>
        <?php elseif ($_GET['exito'] === 'cancelada'): ?>
            <div class="alerta exito">✅ Incidencia cancelada correctamente.</div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <?php if ($_GET['error'] === '48h'): ?>
            <div class="alerta error">❌ No se puede cancelar con menos de 48h de antelación.</div>
        <?php elseif ($_GET['error'] === 'no_autorizado'): ?>
            <div class="alerta error">❌ No tienes permiso para cancelar esta incidencia.</div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (empty($incidencias)): ?>
        <div class="vacia">
            🔧
            <p>No tienes ninguna solicitud todavía.</p>
        </div>
    <?php else: ?>
        <?php foreach ($incidencias as $inc): ?>
            <div class="aviso-card">
                <div class="aviso-info">
                    <div class="aviso-codigo"><?= htmlspecialchars($inc['codigo']) ?></div>
                    <div class="aviso-descripcion"><?= htmlspecialchars($inc['descripcion']) ?></div>
                    <div class="badges">
                        <span class="badge badge-<?= $inc['tipo_servicio'] ?>">
                            <?= $inc['tipo_servicio'] === 'urgente' ? '🚨 Urgente' : '📅 Estándar' ?>
                        </span>
                        <span class="badge badge-<?= $inc['estado'] ?>">
                            <?= ucfirst($inc['estado']) ?>
                        </span>
                    </div>
                    <div class="aviso-meta">
                        Servicio: <?= date('d/m/Y H:i', strtotime($inc['fecha_servicio'])) ?>
                        · Creado: <?= date('d/m/Y', strtotime($inc['fecha_creacion'])) ?>
                    </div>
                </div>

                <?php if (in_array($inc['estado'], ['pendiente', 'asignada'])): ?>
                    <form method="POST" action="index.php?action=cancelar_incidencia"
                          onsubmit="return confirm('¿Seguro que quieres cancelar esta solicitud?')">
                        <input type="hidden" name="id" value="<?= $inc['id'] ?>">
                        <button type="submit" class="btn-cancelar">Cancelar</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</div>
</body>
</html>