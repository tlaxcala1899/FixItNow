<?php
session_start();
require_once("controllers/MisRespuestasController.php");

$controlador = new MisRespuestasController();
$controlador->mostrar();
?>
