<?php
session_start();
require_once("controllers/Inicio_ColaboradorController.php");

$controlador = new Inicio_ColaboradorController();
$controlador->mostrar();
?>
