<?php
class Tecnico {
    private static function db(): PDO {
        global $pdo;
        return $pdo;
    }

    public static function findAll(): array {
        return self::db()->query("SELECT * FROM tecnicos ORDER BY nombre ASC")->fetchAll();
    }

    public static function findActivos(): array {
        return self::db()->query("SELECT * FROM tecnicos WHERE activo = 1 ORDER BY nombre ASC")->fetchAll();
    }

    public static function findById(int $id): array|false {
        $stmt = self::db()->prepare("SELECT * FROM tecnicos WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function crear(array $data): void {
        $stmt = self::db()->prepare(
            "INSERT INTO tecnicos (nombre, email, especialidad, telefono, activo)
             VALUES (:nombre, :email, :especialidad, :telefono, 1)"
        );
        $stmt->execute([
            'nombre'      => $data['nombre'],
            'email'       => $data['email'] ?? '',
            'especialidad'=> $data['especialidad'] ?? '',
            'telefono'    => $data['telefono'] ?? '',
        ]);
    }

    public static function actualizar(int $id, array $data): void {
        $stmt = self::db()->prepare(
            "UPDATE tecnicos SET nombre = :nombre, email = :email,
             especialidad = :especialidad, telefono = :telefono WHERE id = :id"
        );
        $stmt->execute([
            'nombre'      => $data['nombre'],
            'email'       => $data['email'] ?? '',
            'especialidad'=> $data['especialidad'] ?? '',
            'telefono'    => $data['telefono'] ?? '',
            'id'          => $id,
        ]);
    }

    public static function desactivar(int $id): void {
        $stmt = self::db()->prepare("UPDATE tecnicos SET activo = 0 WHERE id = ?");
        $stmt->execute([$id]);
    }

    public static function getAvisosDelTecnico(int $tecnico_id): array {
        $stmt = self::db()->prepare(
            "SELECT a.*, u.nombre AS nombre_cliente
             FROM avisos a
             LEFT JOIN usuarios u ON a.usuario_id = u.id
             WHERE a.tecnico_id = ? AND a.estado != 'cancelada'
             ORDER BY a.fecha ASC"
        );
        $stmt->execute([$tecnico_id]);
        return $stmt->fetchAll();
    }
}
