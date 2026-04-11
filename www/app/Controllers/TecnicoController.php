<?php
require_once BASE_PATH . '/app/Models/Tecnico.php';
require_once BASE_PATH . '/app/Models/TipoServicio.php';

class TecnicoController {

    // Panel del técnico: ver su agenda de avisos asignados
    public function agenda(): void {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'tecnico') {
            header('Location: index.php?action=login');
            exit;
        }

        // Buscar el técnico por email del usuario logueado
        $stmt = $GLOBALS['pdo']->prepare(
            "SELECT * FROM tecnicos WHERE email = ? AND activo = 1 LIMIT 1"
        );
        $stmt->execute([$_SESSION['usuario']['email']]);
        $tecnico = $stmt->fetch();

        $avisos = [];
        if ($tecnico) {
            $avisos = Tecnico::getAvisosDelTecnico($tecnico['id']);
        }

        require BASE_PATH . '/app/Views/tecnico/agenda.php';
    }

    // Admin: listar todos los técnicos
    public function index(): void {
        requireAdmin();
        $tecnicos      = Tecnico::findAll();
        $tiposServicio = TipoServicio::findAll();
        require BASE_PATH . '/app/Views/admin/tecnicos.php';
    }

    // Admin: crear nuevo técnico (POST)
    public function crear(): void {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            if ($nombre === '') {
                header('Location: index.php?action=tecnicos&error=nombre_vacio');
                exit;
            }
            Tecnico::crear([
                'nombre'       => $nombre,
                'email'        => trim($_POST['email'] ?? ''),
                'especialidad' => trim($_POST['especialidad'] ?? ''),
                'telefono'     => trim($_POST['telefono'] ?? ''),
            ]);
        }
        header('Location: index.php?action=tecnicos&exito=creado');
        exit;
    }

    // Admin: editar técnico (GET muestra form, POST guarda)
    public function editar(int $id): void {
        requireAdmin();
        $tecnico = Tecnico::findById($id);
        if (!$tecnico) {
            header('Location: index.php?action=tecnicos');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            if ($nombre === '') {
                header('Location: index.php?action=editar_tecnico&id=' . $id . '&error=nombre_vacio');
                exit;
            }
            Tecnico::actualizar($id, [
                'nombre'       => $nombre,
                'email'        => trim($_POST['email'] ?? ''),
                'especialidad' => trim($_POST['especialidad'] ?? ''),
                'telefono'     => trim($_POST['telefono'] ?? ''),
            ]);
            header('Location: index.php?action=tecnicos&exito=editado');
            exit;
        }
        require BASE_PATH . '/app/Views/admin/editar_tecnico.php';
    }

    // Admin: dar de baja (soft delete) un técnico
    public function eliminar(int $id): void {
        requireAdmin();
        Tecnico::desactivar($id);
        header('Location: index.php?action=tecnicos&exito=eliminado');
        exit;
    }
}
