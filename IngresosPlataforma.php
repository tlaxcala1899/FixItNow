<?php
session_start();
require_once("controllers/IngresosPlataformaController.php");

$controlador = new IngresosPlataformaController();
$controlador->mostrar();
?>
