<?php
require_once("models/Articulo.php");
class ArticuloClienteController {
    public function mostrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'reportar_articulo') {
            
            $rolUsuario = strtolower($_SESSION['usuario_rol'] ?? '');
            
            if ($rolUsuario === 'colaborador') {
                require_once("models/Reporte.php");
                $modeloReporte = new Reporte();

                $colaborador_id = $_SESSION['usuario_id'];
                $titulo = trim($_POST['titulo_reporte']);
                $descripcion = trim($_POST['descripcion_reporte']);
                
                // ¡LA SOLUCIÓN ESTÁ AQUÍ!
                // Ignoramos el $_POST['id_version'] del formulario HTML.
                // Tomamos el ID de la versión de manera segura directo desde la URL:
                $version_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

                if (!empty($titulo) && !empty($descripcion) && $version_id > 0) {
                    $modeloReporte->crearReporteArticulo($colaborador_id, $version_id, $titulo, $descripcion);
                    
                    // Redirigimos usando el mismo version_id
                    header("Location: ArticuloCliente.php?id=" . $version_id . "&msg=reporte_exito");
                    exit();
                }
            }
        }

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
