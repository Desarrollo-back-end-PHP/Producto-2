<?php
class Aviso {
    private static function db(): PDO {
        global $pdo;
        return $pdo;
    }

    public static function findAll(): array {
        return self::db()->query("SELECT * FROM avisos ORDER BY fecha DESC")->fetchAll();
    }

    public static function findById(int $id): array|false {
        $stmt = self::db()->prepare("SELECT * FROM avisos WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function crear(array $data): void {
        $fields  = implode(', ', array_keys($data));
        $holders = implode(', ', array_map(fn($k) => ":$k", array_keys($data)));
        $stmt = self::db()->prepare("INSERT INTO avisos ($fields) VALUES ($holders)");
        $stmt->execute($data);
    }

    public static function actualizar(int $id, array $data): void {
        $fields = implode(', ', array_map(fn($k) => "$k = :$k", array_keys($data)));
        $stmt = self::db()->prepare("UPDATE avisos SET $fields WHERE id = :id");
        $data['id'] = $id;
        $stmt->execute($data);
    }

    public static function cancelar(int $id): void {
        $stmt = self::db()->prepare("UPDATE avisos SET estado = 'cancelada' WHERE id = ?");
        $stmt->execute([$id]);
    }
}
