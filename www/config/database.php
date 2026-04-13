<?php
class Database {
    private $host = "mysql-db-p2";
    private $db_name = "reparaya";
    private $username = "user";
    private $password = "userpass";
    public function connect() {
        try {
            $conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4",
                $this->username,
                $this->password
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $conn;
        } catch (PDOException $e) {
            die("Error conexión: " . $e->getMessage());
        }
    }
}

// También creamos $pdo global para los modelos que lo usan
$database = new Database();
$pdo = $database->connect();