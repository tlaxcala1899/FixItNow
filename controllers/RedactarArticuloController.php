<?php
require_once("models/Articulo.php");

class RedactarArticuloController {
    
    public function mostrar() {

        $rolUsuario = strtolower($_SESSION['usuario_rol'] ?? '');
        if ($rolUsuario !== 'profesional') {
            header("Location: inicio.php");
            exit();
        }

        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'crear_articulo') {
            $titulo = trim($_POST['titulo']);
            $categoria = trim($_POST['categoria']);
            $contenido = trim($_POST['contenido']);
            $editor_id = $_SESSION['usuario_id'];

            if (empty($titulo) || empty($categoria) || empty($contenido)) {
                $error = "El título, la categoría y el contenido son obligatorios.";
            } else {
                $modelo = new Articulo();
                
                $resultado = $modelo->crearNuevoArticulo($titulo, $categoria, $contenido, $editor_id);

                if ($resultado) {
                    $articulo_id = $resultado['articulo_id'];
                    $version_id = $resultado['version_id'];

                    if (isset($_FILES['imagen_articulo']) && $_FILES['imagen_articulo']['error'] === UPLOAD_ERR_OK) {
                        if (!is_dir('img_articulos')) {
                            mkdir('img_articulos', 0777, true);
                        }
                        
                        $ext = pathinfo($_FILES['imagen_articulo']['name'], PATHINFO_EXTENSION);
                        $ruta_destino = 'img_articulos/' . $version_id . '.' . $ext;

                        if (move_uploaded_file($_FILES['imagen_articulo']['tmp_name'], $ruta_destino)) {
                            $modelo->actualizarImagenVersion($version_id, $ruta_destino);
                        }
                    }

                    header("Location: ArticuloCliente.php?id=" . $version_id);
                    exit();
                } else {
                    $error = "Ocurrió un error al intentar guardar el artículo.";
                }
            }
        }

        require_once("views/RedactarArticulo_view.php");
    }
}
?>
