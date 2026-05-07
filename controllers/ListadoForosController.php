<?php
require_once("models/Foro.php");
class ListadoForosController {
    public function mostrar() {
        require_once("views/ListadoForos_view.php");
    }
    public function obtenerForosPaginados($paginaActual, $forosPorPagina = 10) {
        $modelo = new Foro();
        
        $inicio = ($paginaActual - 1) * $forosPorPagina;
        
        return $modelo->getForosConRespuestas($inicio, $forosPorPagina);
    }
}
?>
