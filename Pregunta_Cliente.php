<?php
session_start();
require_once("controllers/Pregunta_ClienteController.php");

$controlador = new Pregunta_ClienteController();
$controlador->mostrar();
?>
