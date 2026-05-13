<?php
class ReporteArticuloController {
    public function mostrar() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] != 'inspector') {
            header('Location: login.php');
            exit;
        }

        if (!isset($_GET['id']) || empty($_GET['id'])) {
            die("ID de reporte no especificado.");
        }

        require_once("models/Reporte.php");
        $reporteModel = new Reporte();
        $reporte = $reporteModel->getReportePorId((int)$_GET['id']);

        if (!$reporte) {
            die("Reporte no encontrado.");
        }

        require_once("views/ReporteArticulo_view.php");
    }
}
?>