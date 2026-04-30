<?php
session_start();
require_once("controllers/PerfilController.php");

$controlador = new PerfilController();
$controlador->mostrar();
?>
