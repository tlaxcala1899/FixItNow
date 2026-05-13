<?php

require_once("models/ReporteRespuestasM.php");

class ReporteRespuestaController {

    private $model;

    public function __construct() {

        $this->model = new ReporteRespuestasM();
    }

    public function mostrar() {
        $data["titulo"] = "Bandeja de Reportes";
        $data["reportes"] = $this->model->getReportes(); 
        require_once("views/ReporteRespuestas_view.php");
    }

    public function descartar() {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        
        $id_reporte = (int)$_POST['id_reporte'];
        $inspectorId = $_SESSION["usuario_id"] ?? null; 

        if ($id_reporte > 0 && $inspectorId) {
            $this->model->descartarReporte($id_reporte, $inspectorId);
        }
        
        header("Location: ReporteRespuestas.php");
        exit();
    }

    public function eliminar() {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        
        $id_respuesta = (int)$_POST['id_respuesta'];
        $id_reporte = (int)$_POST['id_reporte'];
        $inspectorId = $_SESSION["usuario_id"] ?? null;

        if ($id_respuesta > 0 && $inspectorId) {
            $this->model->eliminarRespuesta($id_respuesta, $inspectorId);
            $this->model->descartarReporte($id_reporte, $inspectorId);
        }
        
        header("Location: ReporteRespuestas.php");
        exit();
    }
    

}

?>