<?php
require_once("models/Reporte.php");
class ReporteArticuloController {
    
    public function mostrar() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] != 'inspector') {
            header('Location: login.php');
            exit;
        }

        if (!isset($_GET['id']) || empty($_GET['id'])) {
            die("ID de reporte no especificado.");
        }

        $reporteModel = new Reporte();
        $reporte = $reporteModel->getReportePorId((int)$_GET['id']);

        if (!$reporte) {
            die("Reporte no encontrado.");
        }

        require_once("views/ReporteArticulo_view.php");
    }

    public function descartar() {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        
        $id_reporte = (int)$_POST['id_reporte'];
        $inspectorId = $_SESSION["usuario_id"] ?? null; 

        if ($id_reporte > 0 && $inspectorId) {
            $reporteModel = new Reporte();
            $reporteModel->descartarReporte($id_reporte, $inspectorId);
        }
        
        header("Location: ReporteArticulos.php"); 
        exit();
    }

    public function eliminar() {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        
        $id_version = (int)$_POST['id_version'];
        $id_reporte = (int)$_POST['id_reporte'];
        $inspectorId = $_SESSION["usuario_id"] ?? null;

        if ($id_version > 0 && $inspectorId) {
            $reporteModel = new Reporte();
            $reporteModel->eliminarVersion($id_version, $id_reporte,$inspectorId);
            $reporteModel->descartarReporte($id_reporte, $inspectorId);
        }
        
        header("Location: ReporteArticulos.php"); 
        exit();
    }
}
?>