<?php
class Articulo {
    private $db;
    
    public function __construct() {
        require_once("config/database.php");
        $this->db = Conectar::conexion();
        
    }
    public function getArticulosMasRecientes($inicio, $cantidad, $busqueda = '', $categorias = []){
        $inicio = (int)$inicio;
        $cantidad = (int)$cantidad;
        
        $sql = "SELECT A.ID, V.ID AS version_id, A.titulo, A.categoria, 
                LEFT(V.contenido, 100) AS contenido_resumen, V.url_img_articulo, U.nombre AS editor
                FROM Articulo AS A 
                INNER JOIN Version_1 AS V ON A.ID = V.articulo 
                INNER JOIN Usuario AS U ON V.editor = U.ID_usuario 
                WHERE 1=1 "; 
        
        // Si hay búsqueda por texto
        if (!empty($busqueda)) {
            $sql .= "AND A.titulo LIKE :busqueda ";
        }
        
        // Si hay categorías seleccionadas (usamos IN)
        if (!empty($categorias) && is_array($categorias)) {
            $catParams = [];
            foreach ($categorias as $index => $cat) {
                $catParams[] = ':cat' . $index; // Genera :cat0, :cat1, etc.
            }
            $sql .= "AND A.categoria IN (" . implode(',', $catParams) . ") ";
        }
        
        $sql .= "ORDER BY V.fecha_creacion DESC LIMIT :cantidad OFFSET :inicio";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->bindParam(':inicio', $inicio, PDO::PARAM_INT);
        
        if (!empty($busqueda)) {
            $termino = '%' . $busqueda . '%';
            $stmt->bindParam(':busqueda', $termino, PDO::PARAM_STR);
        }
        
        if (!empty($categorias) && is_array($categorias)) {
            foreach ($categorias as $index => $cat) {
                $stmt->bindValue(':cat' . $index, $cat, PDO::PARAM_STR);
            }
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    public function crearNuevoArticulo($titulo, $categoria, $contenido, $editor_id) {
        $queryArticulo = "INSERT INTO Articulo (titulo, categoria,redactor) VALUES (:titulo, :categoria,:editor_id)";
        $stmtArt = $this->db->prepare($queryArticulo);
        $stmtArt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        $stmtArt->bindParam(':categoria', $categoria, PDO::PARAM_STR);
        $stmtArt->bindParam(':editor_id', $editor_id, PDO::PARAM_STR);
        if ($stmtArt->execute()) {
            $articulo_id = $this->db->lastInsertId();

            $queryVersion = "INSERT INTO Version_1 (articulo, contenido, url_img_articulo, editor, fecha_creacion) 
                             VALUES (:articulo, :contenido, 'img_articulos/-1.png', :editor, NOW())";
            $stmtVer = $this->db->prepare($queryVersion);
            $stmtVer->bindParam(':articulo', $articulo_id, PDO::PARAM_INT);
            $stmtVer->bindParam(':contenido', $contenido, PDO::PARAM_STR);
            $stmtVer->bindParam(':editor', $editor_id, PDO::PARAM_INT);
            
            if ($stmtVer->execute()) {
                $version_id = $this->db->lastInsertId();
                return ['articulo_id' => $articulo_id, 'version_id' => $version_id];
            }
        }
        return false;
    }

    public function getArticulosDelRedactor($id_redactor) {
        $sql = "SELECT A.ID AS articulo_id, V.ID AS version_id, A.titulo, A.categoria,
                LEFT(V.contenido, 100) AS extracto, V.url_img_articulo
                FROM Articulo AS A
                INNER JOIN Version_1 AS V ON A.ID = V.articulo
                WHERE A.redactor = :redactor
                ORDER BY V.fecha_creacion DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':redactor', $id_redactor, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>