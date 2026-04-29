<?php
require_once("models/Usuario.php");

class InicioController {
    public function mostrarInicio() {
        $usuarioModel = new Usuario();
        $datos = $usuarioModel->getUsuarios();
        
        // El controlador invoca a la vista y le pasa los $datos
        require_once("views/inicioCliente_view.php");
    }
}
?>