<?php
session_start();
require_once("controllers/InicioController.php");

$controlador = new InicioController();
$controlador->mostrarInicio();
?>