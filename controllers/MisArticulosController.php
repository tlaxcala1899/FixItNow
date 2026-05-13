<?php
class MisArticulosController {
    public function mostrar() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: login.php');
            exit;
        }

        require_once("models/Articulo.php");
        $articuloModel = new Articulo();
        $misArticulos = $articuloModel->getArticulosDelRedactor($_SESSION['usuario_id']);

        require_once("views/MisArticulos_view.php");
    }
}
?>
