<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Solicitud — ReparaYa</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            width: 100%;
            max-width: 520px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        h1 {
            font-size: 1.4rem;
            color: #1a1a2e;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.2rem;
        }

        label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #444;
            margin-bottom: 0.4rem;
        }

        input, select, textarea {
            width: 100%;
            padding: 0.65rem 0.9rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: border-color 0.2s;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #4f46e5;
        }

        textarea { resize: vertical; min-height: 100px; }

        .aviso-48h {
            background: #fffbeb;
            border: 1px solid #fcd34d;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.83rem;
            color: #92400e;
            margin-bottom: 1.2rem;
            display: none;
        }

        .aviso-48h.visible { display: block; }

        .errores {
            background: #fef2f2;
            border: 1px solid #fca5a5;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            margin-bottom: 1.2rem;
        }

        .errores p {
            color: #991b1b;
            font-size: 0.85rem;
            margin-bottom: 0.2rem;
        }

        .btn {
            width: 100%;
            padding: 0.75rem;
            background: #4f46e5;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn:hover { background: #4338ca; }

        .link-volver {
            display: block;
            text-align: center;
            margin-top: 1rem;
            font-size: 0.85rem;
            color: #6b7280;
            text-decoration: none;
        }

        .link-volver:hover { color: #4f46e5; }
    </style>
</head>
<body>
<div class="card">
    <h1>🔧 Nueva Solicitud de Avería</h1>

    <?php if (!empty($errores)): ?>
        <div class="errores">
            <?php foreach ($errores as $error): ?>
                <p>⚠️ <?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="index.php?action=crear_incidencia">

        <div class="form-group">
            <label for="tipo_servicio">Tipo de servicio</label>
            <select name="tipo_servicio" id="tipo_servicio">
                <option value="estandar" <?= ($_POST['tipo_servicio'] ?? '') === 'estandar' ? 'selected' : '' ?>>
                    Estándar
                </option>
                <option value="urgente" <?= ($_POST['tipo_servicio'] ?? '') === 'urgente' ? 'selected' : '' ?>>
                    Urgente
                </option>
            </select>
        </div>

        <div class="aviso-48h" id="aviso48h">
            ⏰ Los servicios estándar requieren al menos <strong>48 horas de antelación</strong>.
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción de la avería</label>
            <textarea name="descripcion" id="descripcion" placeholder="Describe el problema con detalle..."><?= htmlspecialchars($_POST['descripcion'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
            <label for="fecha_servicio">Fecha y hora del servicio</label>
            <input
                type="datetime-local"
                name="fecha_servicio"
                id="fecha_servicio"
                value="<?= htmlspecialchars($_POST['fecha_servicio'] ?? '') ?>"
            >
        </div>

        <button type="submit" class="btn">Enviar solicitud</button>
    </form>

    <a href="index.php?action=mis_avisos" class="link-volver">← Volver a Mis Avisos</a>
</div>

<script>
    const select = document.getElementById('tipo_servicio');
    const aviso = document.getElementById('aviso48h');

    function actualizarAviso() {
        aviso.classList.toggle('visible', select.value === 'estandar');
    }

    select.addEventListener('change', actualizarAviso);
    actualizarAviso(); 
</script>
</body>
</html>