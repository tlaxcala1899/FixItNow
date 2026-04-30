<?php
session_start();
require_once("controllers/ArticuloClienteController.php");

$controlador = new ArticuloClienteController();
$controlador->mostrar();
?>
