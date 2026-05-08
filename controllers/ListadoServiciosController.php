<?php
require_once("models/Servicio.php");

class ListadoServiciosController {
    
    public function mostrar() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $modelo = new Servicio();
        
        $busqueda = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';
        $servicios = $modelo->getServicios($busqueda);

        $rolUsuario = strtolower($_SESSION['usuario_rol'] ?? '');
        $esCliente = ($rolUsuario === 'cliente');
        $tieneMetodoPago = false;

        if ($esCliente && isset($_SESSION['usuario_id'])) {
            $tieneMetodoPago = $modelo->tieneMetodoPago($_SESSION['usuario_id']);
        }

        $mensaje = $_GET['msg'] ?? null;
        $error = $_GET['error'] ?? null;

        require_once("views/ListadoServicios_view.php");
    }

    public function contratar() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'contratar') {
            $rolUsuario = strtolower($_SESSION['usuario_rol'] ?? '');
            
            if ($rolUsuario !== 'cliente') {
                header("Location: ListadoServicios.php?error=No_autorizado");
                exit();
            }

            $cliente_id = $_SESSION['usuario_id'];
            $servicio_id = (int)$_POST['servicio_id'];
            $profesional_id = (int)$_POST['profesional_id'];

            $modelo = new Servicio();
            
            if (!$modelo->tieneMetodoPago($cliente_id)) {
                header("Location: ListadoServicios.php?error=Sin_metodo_pago");
                exit();
            }

            if ($modelo->contratarServicio($cliente_id, $profesional_id, $servicio_id)) {
                header("Location: ListadoServicios.php?msg=Servicio_contratado");
                exit();
            } else {
                header("Location: ListadoServicios.php?error=Error_al_contratar");
                exit();
            }
        }
    }
}
?>