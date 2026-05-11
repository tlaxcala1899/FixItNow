<?php
require_once("models/usuario.php");
require_once("controllers/LoginController.php");
class RegistroController {
    public function mostrar() {
        require_once("views/Registro_view.php");
    }
    public function procesarRegistro($nombre, $apellido_paterno, $apellido_materno, $correo, $contrasena) {
        $modelo = new Usuario();

        if ($modelo->correoExiste($correo)) {
            return false;
        }

        $contrasenaEncriptada = password_hash($contrasena, PASSWORD_DEFAULT);

        $creado = $modelo->crearUsuario($nombre, $apellido_paterno, $apellido_materno, $correo, $contrasenaEncriptada);

        if ($creado) {
            return true; 
        } else {
            return false;
        }
    }
}
?>
