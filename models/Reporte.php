<?php
class Reporte {
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
                    r.version_1, 
                    r.fecha_creacion,
                    a.ID AS articulo,
                    a.titulo AS titulo_articulo
                FROM reporte_articulo AS r
                LEFT JOIN version_1 AS v ON r.version_1 = v.ID
                LEFT JOIN articulo AS a ON v.articulo = a.ID
                WHERE r.atendido = FALSE";
                
        if ($inspectorId !== null) {
            $sql .= " AND r.inspector = :inspector";
        }
        $sql .= " ORDER BY r.fecha_creacion DESC";

        $stmt = $this->db->prepare($sql);
        
        if ($inspectorId !== null) {
            $stmt->bindParam(':inspector', $inspectorId, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReportePorId($id) {
        $sql = "SELECT r.*, a.ID AS articulo_id, v.ID AS version_id, a.titulo AS titulo_articulo
                FROM reporte_articulo AS r
                LEFT JOIN version_1 AS v ON r.version_1 = v.ID
                LEFT JOIN articulo AS a ON v.articulo = a.ID
                WHERE r.ID = :id
                LIMIT 1"; 
                
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crearReporteArticulo($colaborador_id, $version_id, $titulo, $descripcion) {
        $sql = "INSERT INTO reporte_articulo (colaborador, version_1, titulo, descripcion, atendido) 
                VALUES (:colaborador, :version, :titulo, :descripcion, FALSE)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':colaborador', $colaborador_id, PDO::PARAM_INT);
        $stmt->bindParam(':version', $version_id, PDO::PARAM_INT);
        $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        
        return $stmt->execute();
    }

    public function descartarReporte($idReporte, $idInspector) {
        $sql = "UPDATE reporte_articulo SET atendido = TRUE, inspector = :inspector WHERE ID = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':inspector', $idInspector, PDO::PARAM_INT);
        $stmt->bindParam(':id', $idReporte, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function eliminarVersion($idVersion, $idReporte, $idInspector) {
        $sqlInspector = "SET @inspector_actual = :inspector";
        $stmtInspector = $this->db->prepare($sqlInspector);
        $stmtInspector->bindParam(':inspector', $idInspector, PDO::PARAM_INT);
        $stmtInspector->execute();

        $sqlUpdate = "UPDATE reporte_articulo SET version_1 = NULL WHERE ID = :id_reporte";
        $stmtUpdate = $this->db->prepare($sqlUpdate);
        $stmtUpdate->bindParam(':id_reporte', $idReporte, PDO::PARAM_INT);
        $stmtUpdate->execute();

        $sqlDelete = "DELETE FROM version_1 WHERE ID = :id_version";
        $stmtDelete = $this->db->prepare($sqlDelete);
        $stmtDelete->bindParam(':id_version', $idVersion, PDO::PARAM_INT);
        return $stmtDelete->execute();
    }
}
?>