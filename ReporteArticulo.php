<?php
session_start();

require_once("controllers/ReporteArticuloController.php");
$controller = new ReporteArticuloController();

if (isset($_POST["eliminar_version"])) {
    $controller->eliminar();
} 
elseif (isset($_POST["descartar_reporte"])) {
    $controller->descartar();
} 
else {
    $controller->mostrar();
}
?>