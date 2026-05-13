<?php
session_start();
require_once("controllers/ReporteArticuloController.php");

include 'views/header_view.php';

$controlador = new ReporteArticuloController();
$controlador->mostrar();
?>