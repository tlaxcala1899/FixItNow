<?php
session_start();
require_once("controllers/RedactarPreguntaController.php");

$controlador = new RedactarPreguntaController();
$controlador->mostrar();
?>
