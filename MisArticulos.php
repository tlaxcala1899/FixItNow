<?php
session_start();
require_once("controllers/MisArticulosController.php");

$controlador = new MisArticulosController();
$controlador->mostrar();
?>
