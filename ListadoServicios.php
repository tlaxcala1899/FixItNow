<?php
session_start();
require_once("controllers/ListadoServiciosController.php");

$controlador = new ListadoServiciosController();
$controlador->mostrar();
?>