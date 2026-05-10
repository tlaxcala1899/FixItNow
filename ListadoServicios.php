<?php
require_once("controllers/ListadoServiciosController.php");
$controlador = new ListadoServiciosController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controlador->contratar();
} else {
    $controlador->mostrar();
}
?>