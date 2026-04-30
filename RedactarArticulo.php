<?php
session_start();
require_once("controllers/RedactarArticuloController.php");

$controlador = new RedactarArticuloController();
$controlador->mostrar();
?>
