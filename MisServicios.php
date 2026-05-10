<?php
session_start();
require_once("controllers/MisServiciosController.php");

$controlador = new MisServiciosController;
$controlador->mostrar();
?>