<?php
session_start();
require_once("controllers/VistaForoController.php");
$controlador = new VistaForoController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'agregar_respuesta') {
    $controlador->addAnswer();
} else {
    $controlador->mostrar();
}
?>