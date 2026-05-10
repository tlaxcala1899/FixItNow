<?php
require_once("models/Servicio.php");

class MetodoPagoController {
    
    public function gestionar() {
        
        $rolUsuario = strtolower($_SESSION['usuario_rol'] ?? '');
        if ($rolUsuario !== 'cliente') {
            header("Location: inicio.php");
            exit();
        }

        $cliente_id = $_SESSION['usuario_id'];
        $modelo = new Servicio();
        $mensaje = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'guardar_pago') {
            $titular = trim($_POST['nombre_titular']);
            $numero = trim($_POST['numero_tarjeta']);
            $proveedor = trim($_POST['proveedor_tarjeta']);
            $vencimiento = trim($_POST['fecha_vencimiento']);

            if (!empty($titular) && !empty($numero) && !empty($proveedor) && !empty($vencimiento)) {
                if ($modelo->guardarMetodoPago($cliente_id, $numero, $proveedor, $titular, $vencimiento)) {
                    $mensaje = "exito";
                } else {
                    $mensaje = "error";
                }
            } else {
                $mensaje = "incompleto";
            }
        }
        
        $metodoActual = $modelo->getMetodoPago($cliente_id);

        require_once("views/MetodoPago_view.php");
    }
}
?>