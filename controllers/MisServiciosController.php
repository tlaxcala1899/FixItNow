<?php
require_once("models/Servicio.php");
class MisServiciosController {
    
    public function mostrar() {

        $rolUsuario = strtolower($_SESSION['usuario_rol'] ?? '');
        if ($rolUsuario !== 'profesional') {
            header("Location: inicio.php");
            exit();
        }

        $profesional_id = $_SESSION['usuario_id'];
        $modelo = new Servicio();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['accion'])) {
                
                if ($_POST['accion'] === 'añadir') {
                    $nombre = trim($_POST['nombre_servicio']);
                    $costo = floatval($_POST['costo']);
                    
                    if (!empty($nombre) && $costo >= 0) {
                        $modelo->addServicio($nombre, $profesional_id, $costo);
                    }
                    
                } elseif ($_POST['accion'] === 'toggle') {
                    $servicio_id = (int)$_POST['servicio_id'];
                    $modelo->toggleDisponibilidad($servicio_id, $profesional_id);
                }
            }
            header("Location: MisServicios.php");
            exit();
        }
        $servicios = $modelo->getServiciosPorProfesional($profesional_id);

        require_once("views/MisServicios_view.php");
    }

    
}
?>