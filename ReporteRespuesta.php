<?php
session_start();

require_once("controllers/ReporteRespuestaController.php");
$controller = new ReporteRespuestaController();

if (isset($_POST["eliminar_respuesta"])) {
    $controller->eliminar();
} 
elseif (isset($_POST["descartar_reporte"])) {
    $controller->descartar();
} 
else {
    header("Location: ReporteRespuestas.php");
    exit();
}
?>