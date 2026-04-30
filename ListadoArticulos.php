<?php
session_start();
require_once("controllers/ListadoArticulosController.php");

$controlador = new ListadoArticulosController();
$controlador->mostrar();
?>
