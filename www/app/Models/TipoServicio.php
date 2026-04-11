<?php
class TipoServicio {
    private static function db(): PDO {
        global $pdo;
        return $pdo;
    }

    public static function findAll(): array {
        return self::db()->query("SELECT * FROM tipos_servicio ORDER BY nombre ASC")->fetchAll();
    }

    public static function findById(int $id): array|false {
        $stmt = self::db()->prepare("SELECT * FROM tipos_servicio WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function crear(array $data): void {
        $stmt = self::db()->prepare(
            "INSERT INTO tipos_servicio (nombre, descripcion) VALUES (:nombre, :descripcion)"
        );
        $stmt->execute([
            'nombre'      => $data['nombre'],
            'descripcion' => $data['descripcion'] ?? '',
        ]);
    }

    public static function actualizar(int $id, array $data): void {
        $stmt = self::db()->prepare(
            "UPDATE tipos_servicio SET nombre = :nombre, descripcion = :descripcion WHERE id = :id"
        );
        $stmt->execute([
            'nombre'      => $data['nombre'],
            'descripcion' => $data['descripcion'] ?? '',
            'id'          => $id,
        ]);
    }

    public static function eliminar(int $id): void {
        $stmt = self::db()->prepare("DELETE FROM tipos_servicio WHERE id = ?");
        $stmt->execute([$id]);
    }
}
