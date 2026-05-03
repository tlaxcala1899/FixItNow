<?php
require_once("models/Articulo.php");
class ListadoArticulosController {
    public function mostrar() {
        require_once("views/ListadoArticulos_view.php");
    }
    public function obtenerArticulosPaginados($paginaActual, $articulosPorPagina = 5) {
        $modelo = new Articulo(); 
        
        $inicio = ($paginaActual - 1) * $articulosPorPagina;
        
        return $modelo->getArticulosMasRecientes($inicio, $articulosPorPagina);
    }
}
?>
