<?php

class ReporteRespuestasM {

    private $db;

    public function __construct() {
        require_once("config/database.php");
        $this->db = Conectar::conexion();
    }

    public function descartarReporte($idReporte, $idInspector) {
        $sql = "UPDATE reporte_respuesta SET atendido = TRUE, inspector = :inspector WHERE ID = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':inspector', $idInspector, PDO::PARAM_INT);
        $stmt->bindParam(':id', $idReporte, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getReportes() {
        $sql = "SELECT 
                    r.ID,
                    r.titulo,
                    LEFT(r.descripcion, 100) AS extracto,
                    r.respuesta,
                    r.fecha_creacion,
                    re.id_pregunta 
                FROM reporte_respuesta AS r
                INNER JOIN respuesta AS re ON r.respuesta = re.ID_respuesta
                WHERE r.atendido = FALSE 
                ORDER BY r.fecha_creacion DESC";
                
        $stmt = $this->db->prepare($sql);
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

    public function eliminarRespuesta($idRespuesta,$idInspector) {
        
        $sqlUpdate = "UPDATE reporte_respuesta SET respuesta = NULL WHERE respuesta = :id";
        $stmtUpdate = $this->db->prepare($sqlUpdate);
        $stmtUpdate->bindParam(':id', $idRespuesta, PDO::PARAM_INT);
        $stmtUpdate->execute();

        $sqlInspector = "SET @inspector_actual = :inspector";
        $stmtInspector = $this->db->prepare($sqlInspector);
        $stmtInspector->bindParam(':inspector', $idInspector, PDO::PARAM_INT);
        $stmtInspector->execute();

        $sqlDelete = "DELETE FROM respuesta WHERE ID_respuesta = :id";
        $stmtDelete = $this->db->prepare($sqlDelete);
        $stmtDelete->bindParam(':id', $idRespuesta, PDO::PARAM_INT);
        return $stmtDelete->execute();
    }
    public function crearReporteRespuesta($colaborador_id, $respuesta_id, $titulo, $descripcion) {
        $sql = "INSERT INTO reporte_respuesta (colaborador, respuesta, titulo, descripcion, atendido) 
                VALUES (:colaborador, :respuesta, :titulo, :descripcion, FALSE)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':colaborador', $colaborador_id, PDO::PARAM_INT);
        $stmt->bindParam(':respuesta', $respuesta_id, PDO::PARAM_INT);
        $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        
        return $stmt->execute();
    }
}

?>