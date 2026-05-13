<?php
class ReporteArticulosController {
    public function mostrar() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] != 'inspector') {
            header('Location: login.php');
            exit;
        }

        require_once("models/Reporte.php");
        $reporteModel = new Reporte();
        $reportes = $reporteModel->getReportes($_SESSION['usuario_id']);

        require_once("views/ReporteArticulos_view.php");
    }
}
?>