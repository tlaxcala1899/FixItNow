<?php
require_once('models/usuario.php');
class PerfilController {
    public function mostrar() {
        require_once("views/Perfil_view.php");
    }
    public function actualizarPerfil($datos) {
        $modelo = new Usuario();
        
        $id = $_SESSION['usuario_id'];
        $nombre = trim($datos['nombre']);
        $apellido_paterno = trim($datos['apellido_paterno']);
        $apellido_materno = trim($datos['apellido_materno']);
        $correo = trim($datos['correo']);
        
        $cedula = $_SESSION['usuario_cedula'] ?? null;
        $rolMinuscula = strtolower($_SESSION['usuario_rol'] ?? '');
        
        if (($rolMinuscula === 'profesional' || $rolMinuscula === 'inspector') && isset($datos['cedula'])) {
            $cedula = trim($datos['cedula']);
        }

        $actualizado = $modelo->actualizarUsuario($id, $nombre, $apellido_paterno, $apellido_materno, $correo, $cedula);

        if ($actualizado) {
            $_SESSION['usuario_nombre'] = $nombre;
            $_SESSION['usuario_apellido_paterno'] = $apellido_paterno;
            $_SESSION['usuario_apellido_materno'] = $apellido_materno;
            $_SESSION['usuario_correo'] = $correo;
            $_SESSION['usuario_cedula'] = $cedula;
        }

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>
