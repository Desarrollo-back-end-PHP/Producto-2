<?php

class Database {
    private $host = "127.0.0.1";
    private $db_name = "reparaya";
    private $username = "root";
    private $password = "";

    public function connect() {
        try {
            
            $conn = new PDO(
                "mysql:host=" . $this->host . ";port=3307;dbname=" . $this->db_name,
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