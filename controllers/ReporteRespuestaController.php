<?php

require_once("models/ReporteRespuestasM.php");

class ReporteRespuestaController {

    private $model;

    public function __construct() {

        $this->model = new ReporteRespuestasM();
    }

    public function mostrar() {

        $id = $_GET["id"];

        $data["titulo"] = "Reporte respuesta";
        $data["reporte"] = $this->model->getReportePorId($id);

        require_once("views/ReporteRespuesta_view.php");
    }

    public function eliminar() {

        $idRespuesta = $_POST["id_respuesta"];

        $this->model->eliminarRespuesta($idRespuesta);

        header("Location: ReporteRespuestas.php");
    }
}

?>