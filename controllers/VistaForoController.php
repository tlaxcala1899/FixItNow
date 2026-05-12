<?php
require_once 'models/Foro.php';

class VistaForoController {
    private $foroModel;

    public function __construct() {
        $this->foroModel = new Foro();
    }

    public function mostrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'reportar_respuesta') {
            
            $rolUsuario = strtolower($_SESSION['usuario_rol'] ?? '');
            
            if ($rolUsuario === 'colaborador') {
                require_once("models/Reporte.php");
                $modeloReporte = new Reporte();

                $colaborador_id = $_SESSION['usuario_id'];
                $respuesta_id = (int)$_POST['respuesta_id'];
                $pregunta_id = (int)$_POST['pregunta_id']; // Para saber a dónde redirigir
                $titulo = trim($_POST['titulo_reporte']);
                $descripcion = trim($_POST['descripcion_reporte']);

                if (!empty($titulo) && !empty($descripcion)) {
                    $modeloReporte->crearReporteRespuesta($colaborador_id, $respuesta_id, $titulo, $descripcion);
                    
                    header("Location: ForoVista.php?id=" . $pregunta_id . "&msg=reporte_exito");
                    exit();
                }
            }
        }
        if (!isset($_GET['id'])) {
            header('Location: ListadoForos.php');
            exit;
        }
        $questionId = $_GET['id'];

        $question = $this->foroModel->getQuestionById($questionId);
        $answers = $this->foroModel->getAnswersForQuestion($questionId);

        if (!$question) {
            header('Location: ListadoForos.php');
            exit;
        }

        $canReply = false;
        if (isset($_SESSION['usuario_id'])) {
            $userRole = $_SESSION['usuario_rol'];
            if ($userRole == 'colaborador' || $userRole == 'profesional') {
                $canReply = true;
            }
        }

        include 'views/ForoVista_view.php';
    }

    public function addAnswer() {
        
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: login.php');
            exit;
        }

        $userRole = $_SESSION['usuario_rol'];
        if ($userRole != 'colaborador' && $userRole != 'profesional') {
            echo "No autorizado para responder.";
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pregunta_id']) && isset($_POST['respuesta_content'])) {
            $preguntaId = $_POST['pregunta_id'];
            $userId = $_SESSION['usuario_id'];
            $content = $_POST['respuesta_content'];

            if (empty($content)) {
                header('Location: ForoVista.php?id=' . $preguntaId . '&error=empty');
                exit;
            }

            if ($this->foroModel->createAnswer($preguntaId, $userId, $content)) {
                header('Location: ForoVista.php?id=' . $preguntaId);
                exit;
            } else {
                header('Location: ForoVista.php?id=' . $preguntaId . '&error=db');
                exit;
            }
        }
    }
}
?>