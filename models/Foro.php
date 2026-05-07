<?php
class Foro {
    private $db;
    
    public function __construct() {
        require_once("config/database.php");
        $this->db = Conectar::conexion();
        
    }
    public function getForosConRespuestas($inicio, $cantidad) {
        $inicio = (int)$inicio;
        $cantidad = (int)$cantidad;
        $query = $this->db->prepare("SELECT 
                p.ID_pregunta, 
                p.pregunta, 
                u.nombre AS usuario_nombre, 
                u.url_foto_perfil AS usuario_foto,
                (SELECT LEFT(r.contenido, 100) FROM respuesta r 
                WHERE r.id_pregunta = p.ID_pregunta 
                ORDER BY r.fecha_publicacion ASC LIMIT 1) AS extracto_respuesta
            FROM pregunta p
            INNER JOIN Usuario u ON p.cliente = u.ID_usuario
            ORDER BY p.fecha_publicacion DESC
            LIMIT :cantidad OFFSET :inicio");
        
        $query->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $query->bindParam(':inicio', $inicio, PDO::PARAM_INT);
        $query->execute();
        
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>