<?php
require_once("models/usuario.php");
class LoginController {
    public function mostrarLogin($mensajeError = null) {
        require_once("views/inicioSesion_view.php");
    }

    public function procesarLogin($correo,$contrasena){
        $modelo = new Usuario();
        $usuario = $modelo->verificarCredenciales($correo, $contrasena);
        if ($usuario) {
            $_SESSION['usuario_id'] = $usuario['ID_usuario'];
            $_SESSION['usuario_correo'] = $usuario['correo'];
            $_SESSION['usuario_nombreCompleto'] = $usuario['nombreCompleto'];
            $_SESSION['usuario_nombre']= $usuario['nombre'];
            $_SESSION['usuario_apellido_paterno']= $usuario['apellido_paterno'];
            $_SESSION['usuario_apellido_materno']= $usuario['apellido_materno'];
            $_SESSION['usuario_foto_perfil']= $usuario['url_foto_perfil'];
            $_SESSION['usuario_rol']= $usuario['rol'];
            
            if ($usuario['rol'] === 'profesional' || $usuario['rol'] === 'inspector') {
                require_once("models/Servicio.php");
                $pagoModel = new Servicio();
                $pagoModel->verificarYGenerarPagoMensual($usuario['ID_usuario'], 10000.00);
            }


            header("Location: inicio.php");
            exit();
        } else {
            
            $this->mostrarLogin("Correo o contraseña incorrectos.");
        }
    }

    public function cerrarSesion(){
        session_unset();
        header("Location: inicio.php");
        exit();
    }
}
?>