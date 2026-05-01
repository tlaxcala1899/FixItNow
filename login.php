<?php
session_start();

if (isset($_SESSION['usuario_id'])) {
    header("Location: inicio.php"); 
    exit();
}

require_once("controllers/LoginController.php");

$controlador = new LoginController();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';
    $controlador->procesarLogin($correo, $contrasena);
} else {
    $controlador->mostrarLogin();
}
?>