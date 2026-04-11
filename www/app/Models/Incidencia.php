<?php
require_once "config/database.php";

class Incidencia {

    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // Generar código único tipo INC-20240324-0001
    private function generarCodigo(): string {
        $fecha = date('Ymd');
        $stmt = $this->conn->query("SELECT COUNT(*) FROM incidencias WHERE DATE(fecha_creacion) = CURDATE()");
        $count = (int)$stmt->fetchColumn() + 1;
        return 'INC-' . $fecha . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    // Crear nueva incidencia
    public function crear(array $datos): bool {
        $codigo = $this->generarCodigo();
        $stmt = $this->conn->prepare("
            INSERT INTO incidencias (codigo, usuario_id, descripcion, tipo_servicio, fecha_servicio)
            VALUES (:codigo, :usuario_id, :descripcion, :tipo_servicio, :fecha_servicio)
        ");
        return $stmt->execute([
            ':codigo'        => $codigo,
            ':usuario_id'    => $datos['usuario_id'],
            ':descripcion'   => $datos['descripcion'],
            ':tipo_servicio' => $datos['tipo_servicio'],
            ':fecha_servicio'=> $datos['fecha_servicio'],
        ]);
    }

    // Obtener todas las incidencias de un usuario
    public function obtenerPorUsuario(int $usuario_id): array {
        $stmt = $this->conn->prepare("
            SELECT * FROM incidencias 
            WHERE usuario_id = :usuario_id 
            ORDER BY fecha_creacion DESC
        ");
        $stmt->execute([':usuario_id' => $usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener una incidencia por ID
    public function obtenerPorId(int $id): array|false {
        $stmt = $this->conn->prepare("
            SELECT * FROM incidencias WHERE id = :id
        ");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cancelar incidencia (solo si faltan más de 48h)
    public function cancelar(int $id): bool {
        $incidencia = $this->obtenerPorId($id);
        if (!$incidencia) return false;

        $ahora = new DateTime();
        $fechaServicio = new DateTime($incidencia['fecha_servicio']);
        $horasRestantes = ($fechaServicio->getTimestamp() - $ahora->getTimestamp()) / 3600;

        if ($horasRestantes < 48) return false;

        $stmt = $this->conn->prepare("
            UPDATE incidencias SET estado = 'cancelada' WHERE id = :id
        ");
        return $stmt->execute([':id' => $id]);
    }
}