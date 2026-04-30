<?php
session_start();
require_once("controllers/RegistroController.php");

$controlador = new RegistroController();
$controlador->mostrar();
?>
