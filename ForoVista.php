<?php
session_start();
require_once("controllers/VistaForoController.php");

$controlador = new VistaForoController();
$controlador->mostrar();
?>