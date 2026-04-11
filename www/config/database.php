<?php
class Database {
    private $host = "mysql-db-p2";
    private $db_name = "reparaya";
    private $username = "user";
    private $password = "userpass";
    public function connect() {
        try {
            $conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            echo "Error conexión: " . $e->getMessage();
        }
    }
}
?>