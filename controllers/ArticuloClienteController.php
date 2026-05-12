<?php
require_once("models/Articulo.php");
class ArticuloClienteController {
    public function mostrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'reportar_articulo') {
            
            $rolUsuario = strtolower($_SESSION['usuario_rol'] ?? '');
            
            // Validación de seguridad por si intentan inyectar datos desde otro rol
            if ($rolUsuario === 'colaborador') {
                require_once("models/Reporte.php");
                $modeloReporte = new Reporte();

                $colaborador_id = $_SESSION['usuario_id'];
                $articulo_id = (int)$_POST['articulo_id'];
                $titulo = trim($_POST['titulo_reporte']);
                $descripcion = trim($_POST['descripcion_reporte']);

                if (!empty($titulo) && !empty($descripcion)) {
                    $modeloReporte->crearReporteArticulo($colaborador_id, $articulo_id, $titulo, $descripcion);
                    
                    // Recargamos la misma página pasando un mensaje de éxito por URL
                    $version_id = $_GET['id'] ?? ''; // Mantener el ID de la URL original
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
