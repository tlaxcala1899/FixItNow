<?php
session_start();
include 'views/header_view.php';

require_once("controllers/ReporteRespuestasController.php");
$controller = new ReporteRespuestasController();

$controller->index();
?>