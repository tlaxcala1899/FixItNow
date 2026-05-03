<?php
class Articulo {
    private $db;
    
    public function __construct() {
        require_once("config/database.php");
        $this->db = Conectar::conexion();
        
    }
    public function getArticulosMasRecientes($inicio, $cantidad){
        $inicio = (int)$inicio;
        $cantidad = (int)$cantidad;
        
        $query = $this->db->query("SELECT A.ID, A.titulo,  A.categoria, 
            LEFT(V.contenido, 100) AS contenido_resumen,V.url_img_articulo,  U.nombre AS editor
            FROM Articulo AS A 
            INNER JOIN Version_1 AS V ON A.ID = V.articulo 
            INNER JOIN Usuario AS U ON V.editor = U.ID_usuario
            ORDER BY V.fecha_creacion 
            LIMIT ".$cantidad." OFFSET ".$inicio.";");  
        
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>