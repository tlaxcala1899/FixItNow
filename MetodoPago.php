<?php
session_start();
require_once("controllers/MetodoPagoController.php");
$controlador = new MetodoPagoController();
$controlador->gestionar();
?>