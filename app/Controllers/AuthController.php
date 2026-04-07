<?php



require_once __DIR__ . "/../models/Usuario.php";

class AuthController {

    private $usuario;

    public function __construct() {
        $this->usuario = new Usuario();
    }

    // REGISTRO
    public function registro() {

        if ($_POST) {

            // Validaciones de seguridad
            if (empty($_POST['nombre']) || empty($_POST['email']) || empty($_POST['password'])) {
                echo "Todos los campos son obligatorios";
                return; 
            }

            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                echo "Email no válido";
                return; 
            }
            
            // Comprobar que el email
            if ($this->usuario->existeEmail($_POST['email'])) {
                echo "El email ya está registrado";
                return; 
            }
            
            $ok = $this->usuario->registrar(
                $_POST['nombre'],
                $_POST['email'],
                $_POST['password'],
                $_POST['rol']
            );

            if ($ok) {
                header("Location: index.php?action=login");
exit;
            } else {
                echo "Error al registrar";
            }
        }
    }

    // LOGIN 
    public function login() {

        if ($_POST) {

            $user = $this->usuario->login(
                $_POST['email'],
                $_POST['password']
            );

            if ($user) {
                
                // Si el login es correcto, guardamos sus datos en la "memoria" de la sesión
                $_SESSION['usuario'] = $user;
                
                // Y lo mandamos al panel de control (dashboard)
                header("Location: index.php?action=dashboard");
                exit;

            } else {
                
                return "Email o contraseña incorrectos";
            }
        }
        return null; // Si no hay POST, no devuelve error
    }

} 
?>