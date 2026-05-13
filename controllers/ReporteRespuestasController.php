<?php

require_once("models/ReporteRespuestasM.php");

class ReporteRespuestasController {
    private $model;

    public function __construct() {
        $this->model = new ReporteRespuestasM();
    }

    public function index() {
        $inspectorId = null;

        if (isset($_SESSION["ID"])) {
            $inspectorId = $_SESSION["ID"];
        }

        $data["titulo"] = "Reportes respuestas";
        $data["reportes"] = $this->model->getReportes($inspectorId);

        require_once("views/ReporteRespuestas_view.php");
    }
}

?>