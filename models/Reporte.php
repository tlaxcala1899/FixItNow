<?php
class Reporte {
    private $db;

    public function __construct() {
        require_once("config/database.php");
        $this->db = Conectar::conexion();
    }

    public function getReportes($inspectorId = null) {
        $sql = "SELECT r.ID, r.titulo, LEFT(r.descripcion, 100) AS extracto, r.articulo, r.fecha_creacion
                FROM reporte_articulo AS r";
        if ($inspectorId !== null) {
            $sql .= " WHERE r.inspector = :inspector";
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
        $sql = "SELECT r.*, a.ID AS articulo_id, v.ID AS version_id, v.titulo AS titulo_articulo
                FROM reporte_articulo AS r
                JOIN articulo AS a ON r.articulo = a.ID
                LEFT JOIN version_1 AS v ON a.ID = v.articulo
                WHERE r.ID = :id
                ORDER BY v.fecha_creacion DESC
                LIMIT 1"; // Tomamos la última versión para el enlace
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>