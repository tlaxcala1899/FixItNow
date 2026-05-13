<?php
session_start();
require_once 'controllers/SobreNosotrosController.php';

$controller = new SobreNosotrosController();
$controller->mostrarVista();
?>