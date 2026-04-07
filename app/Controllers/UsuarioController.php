<?php

session_start();

require_once __DIR__ . "/../models/Usuario.php";

class UsuarioController {

    private $usuario;

    public function __construct() {
        $this->usuario = new Usuario();
    }

    public function actualizar() {

        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php?action=login");
            exit;
        }

        if ($_POST) {

            $id = $_SESSION['usuario']['id'];

            $this->usuario->actualizar(
                $id,
                $_POST['nombre'],
                $_POST['email'],
                $_POST['password'] ?? null
            );

            // ACTUALIZAMOS LA MEMORIA DE LA SESIÓN
            $_SESSION['usuario']['nombre'] = $_POST['nombre'];
            $_SESSION['usuario']['email'] = $_POST['email'];
            

            echo "Perfil actualizado correctamente";
        }
    }
}
?>