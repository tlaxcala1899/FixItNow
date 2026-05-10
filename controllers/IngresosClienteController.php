<?php
require_once("models/Servicio.php");
class IngresosClienteController {
     public function mostrar() {
        

        $rolUsuario = strtolower($_SESSION['usuario_rol'] ?? '');
        if ($rolUsuario !== 'profesional') {
            header("Location: inicio.php");
            exit();
        }

        $profesional_id = $_SESSION['usuario_id'];
        $modelo = new Servicio();

        $ingresos = $modelo->getIngresosPorProfesional($profesional_id, null);
        require_once("views/IngresosCliente_view.php");
    }
    
}
?>
