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
        
        $query = $this->db->query("SELECT A.ID,V.ID AS version_id, A.titulo,  A.categoria, 
            LEFT(V.contenido, 100) AS contenido_resumen,V.url_img_articulo,  U.nombre AS editor
            FROM Articulo AS A 
            INNER JOIN Version_1 AS V ON A.ID = V.articulo 
            INNER JOIN Usuario AS U ON V.editor = U.ID_usuario
            ORDER BY V.fecha_creacion desc
            LIMIT ".$cantidad." OFFSET ".$inicio.";");  
        
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getArticuloIndividual($version_ID){
    $query = $this->db->prepare("SELECT A.ID, V.ID AS version_id, A.titulo,  A.categoria, 
        V.contenido,V.url_img_articulo,  U.nombre AS editor
        FROM Articulo AS A 
        INNER JOIN Version_1 AS V ON A.ID = V.articulo 
        INNER JOIN Usuario AS U ON V.editor = U.ID_usuario
        WHERE V.ID = :id");
    
    $query->bindParam(':id', $version_ID, PDO::PARAM_INT);
    $query->execute();
    
    return $query->fetch(PDO::FETCH_ASSOC); 
    }
    public function crearNuevaVersion($articulo_id, $contenido, $editor_id) {
        $query = "INSERT INTO Version_1 (articulo, contenido, url_img_articulo, editor, fecha_creacion) 
                  VALUES (:articulo, :contenido, '-1.png', :editor, NOW())";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':articulo', $articulo_id, PDO::PARAM_INT);
        $stmt->bindParam(':contenido', $contenido, PDO::PARAM_STR);
        $stmt->bindParam(':editor', $editor_id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function actualizarImagenVersion($version_id, $ruta_imagen) {
        $query = "UPDATE Version_1 SET url_img_articulo = :ruta WHERE ID = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':ruta', $ruta_imagen, PDO::PARAM_STR);
        $stmt->bindParam(':id', $version_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>