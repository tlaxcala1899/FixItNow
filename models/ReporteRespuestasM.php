<?php

class ReporteRespuestasM {

    private $db;

    public function __construct() {
        require_once("config/database.php");
        $this->db = Conectar::conexion();
    }

    public function getReportes($inspectorId = null) {
        $sql = "SELECT 
                    r.ID,
                    r.titulo,
                    LEFT(r.descripcion, 100) AS extracto,
                    r.respuesta,
                    r.fecha_creacion
                FROM reporte_respuesta AS r";
        if ($inspectorId != null) {
            $sql .= " WHERE r.inspector = :inspector";
        }
        $sql .= " ORDER BY r.fecha_creacion DESC";
        $stmt = $this->db->prepare($sql);
        if ($inspectorId != null) {
            $stmt->bindParam(':inspector', $inspectorId, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReportePorId($id) {
        $sql = "SELECT 
                    r.*,
                    re.ID_respuesta,
                    re.contenido,
                    p.ID_pregunta,
                    p.pregunta
                FROM reporte_respuesta AS r
                INNER JOIN respuesta AS re
                    ON r.respuesta = re.ID_respuesta
                INNER JOIN pregunta AS p
                    ON re.id_pregunta = p.ID_pregunta
                WHERE r.ID = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function eliminarRespuesta($idRespuesta) {
        $sql = "DELETE FROM respuesta WHERE ID_respuesta = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $idRespuesta, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

?>