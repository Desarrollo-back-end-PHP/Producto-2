<?php

require_once "config/database.php";

class Usuario {

    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // Registro 
    public function registrar($nombre, $email, $password, $rol) {

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nombre, email, password, rol)
                VALUES (:nombre, :email, :password, :rol)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':nombre' => $nombre,
            ':email' => $email,
            ':password' => $hash,
            ':rol' => $rol
        ]);
    }

    // Login 
    public function login($email, $password) {

        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':email' => $email]);

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Compara la contraseña que metes en el login con la encriptada de la base de datos
        if ($usuario && password_verify($password, $usuario['password'])) {
            return $usuario;
        }

        return false;
    }

    // Actualizar Perfil 
    public function actualizar($id, $nombre, $email, $password = null) {

        if ($password) {
            // Si el usuario pone una contraseña nueva, la encriptamos y la guardamos
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $sql = "UPDATE usuarios 
                    SET nombre=:nombre, email=:email, password=:password 
                    WHERE id=:id";

            $params = [
                ':nombre' => $nombre,
                ':email' => $email,
                ':password' => $hash,
                ':id' => $id
            ];

        } else {
            // Si deja la contraseña en blanco, solo actualizamos nombre y email
            $sql = "UPDATE usuarios 
                    SET nombre=:nombre, email=:email 
                    WHERE id=:id";

            $params = [
                ':nombre' => $nombre,
                ':email' => $email,
                ':id' => $id
            ];
        }

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

    // comprobación de existencia de email
    public function existeEmail($email) {
        $sql = "SELECT id FROM usuarios WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':email' => $email]);

        return $stmt->fetch() ? true : false;
    }

}
?>