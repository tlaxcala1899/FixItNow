<?php
require_once("models/Articulo.php");
class EditarArticuloController {
    public function mostrar1() {
        require_once("views/EditarArticulo_view.php");
    }

    public function mostrar() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $rolUsuario = strtolower($_SESSION['usuario_rol'] ?? '');
        if ($rolUsuario !== 'profesional') {
            header("Location: inicio.php");
            exit();
        }

        $modelo = new Articulo();

        $version_id = isset($_GET['version']) ? (int)$_GET['version'] : 0;
        $articulo = $version_id ? $modelo->getArticuloIndividual($version_id) : null;

        if (empty($articulo)) {
            echo "<div style='text-align:center; margin-top:50px;'>
                    <h2>Error: No se encontró la información del artículo.</h2>
                    <a href='inicio.php'>Volver al inicio</a>
                  </div>";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['accion'] ?? '') === 'guardar_version') {
            $articulo_id = (int)($_POST['articulo_id'] ?? 0);
            $contenido = $_POST['contenido'] ?? '';
            $editor_id = (int)($_SESSION['usuario_id'] ?? 0);

            $nueva_version_id = $modelo->crearNuevaVersion($articulo_id, $contenido, $editor_id);

            if ($nueva_version_id) {
                if (isset($_FILES['imagen_articulo']) && $_FILES['imagen_articulo']['error'] === UPLOAD_ERR_OK) {
                    if (!is_dir('img_articulos')) {
                        mkdir('img_articulos', 0777, true);
                    }

                    $ext = pathinfo($_FILES['imagen_articulo']['name'], PATHINFO_EXTENSION);
                    $ruta_destino = 'img_articulos/' . $nueva_version_id . '.' . $ext;

                    if (move_uploaded_file($_FILES['imagen_articulo']['tmp_name'], $ruta_destino)) {
                        $modelo->actualizarImagenVersion($nueva_version_id, $ruta_destino);
                    }
                }
                else {
                    $modelo->actualizarImagenVersion($nueva_version_id, 'img_articulos/-1.png');
                }

                header("Location: ArticuloCliente.php?id=" . $nueva_version_id);
                exit();
            } else {
                $error = "Ocurrió un error al intentar guardar la nueva versión.";
            }
        }

        require_once("views/EditarArticulo_view.php");
    }
}
?>
