<?php
session_start();
require_once("controllers/IngresosClienteController.php");

$controlador = new IngresosClienteController();
$controlador->mostrar();
?>
