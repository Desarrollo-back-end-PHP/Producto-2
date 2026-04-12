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
            $nombre   = trim($_POST['nombre'] ?? '');
            $email    = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if ($nombre === '') {
                header('Location: index.php?action=tecnicos&error=nombre_vacio');
                exit;
            }

            // Crear registro en tabla tecnicos
            Tecnico::crear([
                'nombre'       => $nombre,
                'email'        => $email,
                'especialidad' => trim($_POST['especialidad'] ?? ''),
                'telefono'     => trim($_POST['telefono'] ?? ''),
            ]);

            // Si tiene email y contraseña, crear también el usuario para que pueda loguearse
            if ($email !== '' && $password !== '') {
                global $pdo;
                // Solo si no existe ya ese email en usuarios
                $check = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
                $check->execute([$email]);
                if (!$check->fetch()) {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare(
                        "INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, 'tecnico')"
                    );
                    $stmt->execute([$nombre, $email, $hash]);
                }
            }
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
        $tiposServicio = TipoServicio::findAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre   = trim($_POST['nombre'] ?? '');
            $email    = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if ($nombre === '') {
                header('Location: index.php?action=editar_tecnico&id=' . $id . '&error=nombre_vacio');
                exit;
            }
            Tecnico::actualizar($id, [
                'nombre'       => $nombre,
                'email'        => $email,
                'especialidad' => trim($_POST['especialidad'] ?? ''),
                'telefono'     => trim($_POST['telefono'] ?? ''),
            ]);

            // Si se ha puesto contraseña, actualizar o crear el usuario de acceso
            if ($email !== '' && $password !== '') {
                global $pdo;
                $check = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
                $check->execute([$email]);
                $usuarioExistente = $check->fetch();
                $hash = password_hash($password, PASSWORD_DEFAULT);

                if ($usuarioExistente) {
                    // Actualizar contraseña del usuario existente
                    $stmt = $pdo->prepare("UPDATE usuarios SET password = ?, nombre = ? WHERE email = ?");
                    $stmt->execute([$hash, $nombre, $email]);
                } else {
                    // Crear usuario nuevo con rol técnico
                    $stmt = $pdo->prepare(
                        "INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, 'tecnico')"
                    );
                    $stmt->execute([$nombre, $email, $hash]);
                }
            }

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
