<?php
require_once("models/Articulo.php");
class ArticuloClienteController {
    public function mostrar() {
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $modelo = new Articulo();
            
            $articulo = $modelo->getArticuloIndividual($id); 
        } else {
            $articulo = null;
        }
        require_once("views/ArticuloCliente_view.php");
    }
}
?>
