<?php
session_start();
require_once("controllers/ReporteArticulosController.php");

include 'views/header_view.php';

$controlador = new ReporteArticulosController();
$controlador->mostrar();
?>