<?php
require_once("models/Foro.php");

class RedactarPreguntaController {
    public function mostrar() {
        $rolUsuario = strtolower($_SESSION['usuario_rol'] ?? '');
        if ($rolUsuario !== 'cliente') {
            header("Location: inicio.php");
            exit();
        }

        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'crear_pregunta') {
            $pregunta = trim($_POST['pregunta']);
            $cliente_id = $_SESSION['usuario_id'];

            if (empty($pregunta)) {
                $error = "La pregunta no puede estar vacía.";
            } else {
                $modelo = new Foro();
                
                $resultado = $modelo->crearNuevaPregunta($pregunta, $cliente_id);

                if ($resultado) {
                    header("Location: ListadoForos.php");
                    exit();
                } else {
                    $error = "Ocurrió un error al intentar publicar la pregunta.";
                }
            }
        }

        require_once("views/RedactarPregunta_view.php");
    }
}
?>
