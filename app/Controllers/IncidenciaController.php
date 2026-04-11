<?php
require_once __DIR__ . "/../Models/Incidencia.php";

class IncidenciaController {

    private Incidencia $model;
    private int $usuario_id;

    public function __construct() {
        $this->model = new Incidencia();
        $this->usuario_id = $_SESSION['usuario']['id'] ?? 1;
    }

    // GET — mostrar formulario nueva solicitud
    public function nueva(): void {
        require_once __DIR__ . "/../Views/cliente/nueva_solicitud.php";
    }

    // POST — procesar nueva solicitud
    public function crear(): void {
        $descripcion    = trim($_POST['descripcion'] ?? '');
        $tipo_servicio  = $_POST['tipo_servicio'] ?? 'estandar';
        $fecha_servicio = $_POST['fecha_servicio'] ?? '';

        $errores = [];

        if (empty($descripcion)) {
            $errores[] = 'La descripción es obligatoria.';
        }
        if (empty($fecha_servicio)) {
            $errores[] = 'La fecha de servicio es obligatoria.';
        }

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

        if (!empty($errores)) {
            require_once __DIR__ . "/../Views/cliente/nueva_solicitud.php";
            return;
        }

        $resultado = $this->model->crear([
            'usuario_id'    => $this->usuario_id,
            'descripcion'   => $descripcion,
            'tipo_servicio' => $tipo_servicio,
            'fecha_servicio'=> $fecha_servicio,
        ]);

        if ($resultado) {
            header('Location: index.php?action=mis_avisos&exito=1');
        } else {
            $errores[] = 'Error al guardar la solicitud. Inténtalo de nuevo.';
            require_once __DIR__ . "/../Views/cliente/nueva_solicitud.php";
        }
    }

    // GET — listar incidencias del cliente
    public function misAvisos(): void {
        $incidencias = $this->model->obtenerPorUsuario($this->usuario_id);
        require_once __DIR__ . "/../Views/cliente/mis_avisos.php";
    }

    // POST — cancelar incidencia
    public function cancelar(): void {
        $id = (int)($_POST['id'] ?? 0);

        if ($id <= 0) {
            header('Location: index.php?action=mis_avisos&error=id_invalido');
            return;
        }

        $incidencia = $this->model->obtenerPorId($id);
        if (!$incidencia || $incidencia['usuario_id'] !== $this->usuario_id) {
            header('Location: index.php?action=mis_avisos&error=no_autorizado');
            return;
        }

        $resultado = $this->model->cancelar($id);

        if ($resultado) {
            header('Location: index.php?action=mis_avisos&exito=cancelada');
        } else {
            header('Location: index.php?action=mis_avisos&error=48h');
        }
    }
}
