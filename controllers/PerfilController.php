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
        
        if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
            $directorio = 'fotos_perfil/';    
            if (!is_dir($directorio)) {
                mkdir($directorio, 0777, true);
            }
            $archivos_viejos = glob($directorio . $id . '.*');
            foreach ($archivos_viejos as $archivo) {
                if (is_file($archivo)) {
                    unlink($archivo);
                }
            }

            $ext = pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION);
            $ruta_destino = $directorio . $id . '.' . $ext;

            if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $ruta_destino)) {
                $modelo->actualizarFotoPerfil($id, $ruta_destino);
                $_SESSION['usuario_foto_perfil'] = $ruta_destino;
            }
        }
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
