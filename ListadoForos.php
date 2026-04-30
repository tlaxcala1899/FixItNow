<?php
session_start();
require_once("controllers/ListadoForosController.php");

$controlador = new ListadoForosController();
$controlador->mostrar();
?>
