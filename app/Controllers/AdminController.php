<?php
require_once BASE_PATH . '/app/Models/Aviso.php';

class AdminController {

    public function index(): void {
        requireAdmin();
        $avisos   = Aviso::findAll();
        $tecnicos = [];
        require BASE_PATH . '/app/Views/admin/panel.php';
    }

    public function calendario(): void {
        requireAdmin();
        $avisos = Aviso::findAll();
        require BASE_PATH . '/app/Views/admin/calendario.php';
    }

    public function detalle($id): void {
        requireAdmin();
        $aviso = Aviso::findById((int)$id);
        if (!$aviso) { header('Location: /index.php?url=admin/index'); exit; }
        require BASE_PATH . '/app/Views/admin/detalle_aviso.php';
    }

    public function crear(): void {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $codigo = 'AV-' . strtoupper(uniqid());
            Aviso::crear([
                'codigo'        => $codigo,
                'tipo_servicio' => $_POST['tipo_servicio'] ?? '',
                'urgencia'      => $_POST['urgencia'] ?? 'estandar',
                'fecha'         => $_POST['fecha'] ?? '',
                'franja'        => $_POST['franja'] ?? '',
                'descripcion'   => trim($_POST['descripcion'] ?? ''),
                'direccion'     => trim($_POST['direccion'] ?? ''),
                'telefono'      => trim($_POST['telefono'] ?? ''),
                'estado'        => 'pendiente',
                'tecnico_id'    => null,
            ]);
            header('Location: /index.php?url=admin/index');
            exit;
        }
        require BASE_PATH . '/app/Views/admin/panel.php';
    }

    public function editar($id): void {
        requireAdmin();
        $aviso = Aviso::findById((int)$id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Aviso::actualizar((int)$id, [
                'tipo_servicio' => $_POST['tipo_servicio'] ?? $aviso['tipo_servicio'],
                'urgencia'      => $_POST['urgencia'] ?? $aviso['urgencia'],
                'fecha'         => $_POST['fecha'] ?? $aviso['fecha'],
                'franja'        => $_POST['franja'] ?? $aviso['franja'],
                'descripcion'   => trim($_POST['descripcion'] ?? $aviso['descripcion']),
                'direccion'     => trim($_POST['direccion'] ?? $aviso['direccion']),
                'telefono'      => trim($_POST['telefono'] ?? $aviso['telefono']),
            ]);
            header('Location: /index.php?url=admin/index');
            exit;
        }
        require BASE_PATH . '/app/Views/admin/detalle_aviso.php';
    }

    public function cancelar($id): void {
        requireAdmin();
        Aviso::cancelar((int)$id);
        header('Location: /index.php?url=admin/index');
        exit;
    }

    public function asignarTecnico(): void {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Aviso::actualizar((int)$_POST['aviso_id'], [
                'tecnico_id' => $_POST['tecnico_id']
            ]);
        }
        header('Location: /index.php?url=admin/index');
        exit;
    }
}
