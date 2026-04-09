<?php
require_once __DIR__ . '/../Models/Incidencia.php';

class IncidenciaController {

    private Incidencia $model;
    private int $usuario_id;

    public function __construct(PDO $db) {
        $this->model = new Incidencia($db);

        // Mientras Persona 1 termina el login, usamos usuario hardcodeado
        $this->usuario_id = $_SESSION['usuario_id'] ?? 1;
    }

    // GET — mostrar formulario nueva solicitud
    public function nueva(): void {
        require_once __DIR__ . '/../Views/nueva_solicitud.php';
    }

    // POST — procesar nueva solicitud
    public function crear(): void {
        $descripcion    = trim($_POST['descripcion'] ?? '');
        $tipo_servicio  = $_POST['tipo_servicio'] ?? 'estandar';
        $fecha_servicio = $_POST['fecha_servicio'] ?? '';

        $errores = [];

        // Validar campos vacíos
        if (empty($descripcion)) {
            $errores[] = 'La descripción es obligatoria.';
        }
        if (empty($fecha_servicio)) {
            $errores[] = 'La fecha de servicio es obligatoria.';
        }

        // Validar regla de las 48h para servicios estándar
        if ($tipo_servicio === 'estandar' && !empty($fecha_servicio)) {
            $ahora = new DateTime();
            $fechaSolicitada = new DateTime($fecha_servicio);
            $horasTotales = ($fechaSolicitada->getTimestamp() - $ahora->getTimestamp()) / 3600;

            if ($fechaSolicitada <= $ahora) {
                $errores[] = 'La fecha de servicio debe ser futura.';
            } elseif ($horasTotales < 48) {
                $errores[] = 'Los servicios estándar requieren al menos 48h de antelación.';
            }
        }

        // Si hay errores, volver al formulario con los mensajes
        if (!empty($errores)) {
            require_once __DIR__ . '/../Views/nueva_solicitud.php';
            return;
        }

        // Crear la incidencia
        $resultado = $this->model->crear([
            'usuario_id'    => $this->usuario_id,
            'descripcion'   => $descripcion,
            'tipo_servicio' => $tipo_servicio,
            'fecha_servicio'=> $fecha_servicio,
        ]);

        if ($resultado) {
            header('Location: ?action=mis_avisos&exito=1');
        } else {
            $errores[] = 'Error al guardar la solicitud. Inténtalo de nuevo.';
            require_once __DIR__ . '/../Views/nueva_solicitud.php';
        }
    }

    // GET — listar incidencias del cliente
    public function misAvisos(): void {
        $incidencias = $this->model->obtenerPorUsuario($this->usuario_id);
        require_once __DIR__ . '/../Views/mis_avisos.php';
    }

    // POST — cancelar incidencia
    public function cancelar(): void {
        $id = (int)($_POST['id'] ?? 0);

        if ($id <= 0) {
            header('Location: ?action=mis_avisos&error=id_invalido');
            return;
        }

        // Verificar que la incidencia pertenece al usuario
        $incidencia = $this->model->obtenerPorId($id);
        if (!$incidencia || $incidencia['usuario_id'] !== $this->usuario_id) {
            header('Location: ?action=mis_avisos&error=no_autorizado');
            return;
        }

        $resultado = $this->model->cancelar($id);

        if ($resultado) {
            header('Location: ?action=mis_avisos&exito=cancelada');
        } else {
            header('Location: ?action=mis_avisos&error=48h');
        }
    }
}