<?php
class Reporte {
    private $db;
    
    public function __construct() {
        require_once("config/database.php");
        $this->db = Conectar::conexion();
        
    }

    public function crearReporteArticulo($colaborador_id, $articulo_id, $titulo, $descripcion) {
        $sql = "INSERT INTO reporte_articulo (colaborador, articulo, titulo, descripcion, atendido) 
                VALUES (:colaborador, :articulo, :titulo, :descripcion, FALSE)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':colaborador', $colaborador_id, PDO::PARAM_INT);
        $stmt->bindParam(':articulo', $articulo_id, PDO::PARAM_INT);
        $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        
        return $stmt->execute();
    }

}
?>