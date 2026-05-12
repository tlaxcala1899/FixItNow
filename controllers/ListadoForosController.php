<?php
require_once("models/Foro.php");
class ListadoForosController {
    public function mostrar() {
        require_once("views/ListadoForos_view.php");
    }
    public function obtenerForosPaginados($paginaActual, $forosPorPagina, $busqueda = '') {
        require_once("models/Foro.php");
        $modelo = new Foro();
        
        $inicio = ($paginaActual - 1) * $forosPorPagina;
        
        // Llamamos a la función en el modelo que ya usabas (adapta el nombre si es diferente)
        return $modelo->obtenerForosPaginados($inicio, $forosPorPagina, $busqueda);
    }
}
?>
