<?php
session_start();
require_once("controllers/EditarArticuloController.php");

$controlador = new EditarArticuloController();
$controlador->mostrar();
?>
