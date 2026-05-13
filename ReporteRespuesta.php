<?php
session_start();
include 'views/header_view.php';

require_once("controllers/ReporteRespuestaController.php");
$controller = new ReporteRespuestaController();

if (isset($_POST["eliminar_respuesta"])) {
    $controller->eliminar();

} else {
    $controller->mostrar();
}
?>