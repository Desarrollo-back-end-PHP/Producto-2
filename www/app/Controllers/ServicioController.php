<?php
require_once BASE_PATH . '/app/Models/TipoServicio.php';

class ServicioController {

    // Admin: listar tipos de servicio
    public function index(): void {
        requireAdmin();
        $tiposServicio = TipoServicio::findAll();
        require BASE_PATH . '/app/Views/admin/tipos_servicio.php';
    }

    // Admin: crear tipo de servicio (POST)
    public function crear(): void {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            if ($nombre === '') {
                header('Location: index.php?action=tipos_servicio&error=nombre_vacio');
                exit;
            }
            TipoServicio::crear([
                'nombre'      => $nombre,
                'descripcion' => trim($_POST['descripcion'] ?? ''),
            ]);
        }
        header('Location: index.php?action=tipos_servicio&exito=creado');
        exit;
    }

    // Admin: editar tipo de servicio
    public function editar(int $id): void {
        requireAdmin();
        $tipo = TipoServicio::findById($id);
        if (!$tipo) {
            header('Location: index.php?action=tipos_servicio');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            if ($nombre === '') {
                header('Location: index.php?action=editar_tipo_servicio&id=' . $id . '&error=nombre_vacio');
                exit;
            }
            TipoServicio::actualizar($id, [
                'nombre'      => $nombre,
                'descripcion' => trim($_POST['descripcion'] ?? ''),
            ]);
            header('Location: index.php?action=tipos_servicio&exito=editado');
            exit;
        }
        require BASE_PATH . '/app/Views/admin/editar_tipo_servicio.php';
    }

    // Admin: eliminar tipo de servicio
    public function eliminar(int $id): void {
        requireAdmin();
        TipoServicio::eliminar($id);
        header('Location: index.php?action=tipos_servicio&exito=eliminado');
        exit;
    }
}
