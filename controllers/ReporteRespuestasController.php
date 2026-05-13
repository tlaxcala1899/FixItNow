<?php

require_once("models/ReporteRespuestasM.php");

class ReporteRespuestasController {
    private $model;

    public function __construct() {
        $this->model = new ReporteRespuestasM();
    }

    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['descartar_reporte'])) {
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $id_reporte = (int)$_POST['id_reporte'];
            $inspectorId = $_SESSION["ID"] ?? null; 

            if ($id_reporte > 0 && $inspectorId) {
                $this->model->descartarReporte($id_reporte, $inspectorId);
                header("Location: ReporteRespuesta.php");
                exit();
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_respuesta'])) {
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $id_respuesta = (int)$_POST['id_respuesta'];
            $id_reporte = (int)$_POST['id_reporte'];
            $inspectorId = $_SESSION["ID"] ?? null;

            if ($id_respuesta > 0 && $inspectorId) {
                $this->model->eliminarRespuesta($id_respuesta, $inspectorId);
                $this->model->descartarReporte($id_reporte, $inspectorId);
                
                header("Location: ReporteRespuesta.php");
                exit();
            }
        }
        $inspectorId = null;

        if (isset($_SESSION["ID"])) {
            $inspectorId = $_SESSION["ID"];
        }

        $data["titulo"] = "Reportes respuestas";
        $data["reportes"] = $this->model->getReportes(); 

        require_once("views/ReporteRespuestas_view.php");
    }

    public function verDetalle() {
        $id_reporte = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if ($id_reporte > 0) {
            $reporte = $this->model->getReportePorId($id_reporte);
            
            if ($reporte) {
                require_once("views/ReporteRespuestas_view.php"); 
            } else {
                echo "El reporte no existe.";
            }
        } else {
            echo "ID de reporte inválido.";
        }
    }
}

?>