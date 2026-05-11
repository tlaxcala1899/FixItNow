<?php
require_once("models/Servicio.php");

class IngresosPlataformaController {
    
    public function mostrar() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $rol = strtolower($_SESSION['usuario_rol'] ?? '');
        
        if ($rol !== 'profesional' && $rol !== 'inspector') {
            header("Location: inicio.php");
            exit();
        }

        $usuario_id = $_SESSION['usuario_id'];
        $modelo = new Servicio();
        $pagos = $modelo->getPagosPlataforma($usuario_id);

        require_once("views/IngresosPlataforma_view.php");
    }
}
?>
