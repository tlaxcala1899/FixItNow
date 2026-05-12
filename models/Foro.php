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
    public function crearNuevaPregunta($pregunta, $cliente_id) {
        $query = "INSERT INTO pregunta (pregunta, cliente) VALUES (:pregunta, :cliente)";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':pregunta', $pregunta, PDO::PARAM_STR);
        $stmt->bindParam(':cliente', $cliente_id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    public function obtenerForosPaginados($inicio, $cantidad, $busqueda = '') {
        $inicio = (int)$inicio;
        $cantidad = (int)$cantidad;
        
        $sql = "SELECT p.ID_pregunta, p.pregunta, p.fecha_publicacion, 
                       u.nombre AS usuario_nombre, u.url_foto_perfil AS usuario_foto,
                       (SELECT r.contenido FROM respuesta r WHERE r.id_pregunta = p.ID_pregunta ORDER BY r.fecha_publicacion ASC LIMIT 1) AS extracto_respuesta
                FROM pregunta p
                INNER JOIN Usuario u ON p.cliente = u.ID_usuario ";
        
        if (!empty($busqueda)) {
            $sql .= "WHERE p.pregunta LIKE :busqueda ";
        }
        
        $sql .= "ORDER BY p.fecha_publicacion DESC LIMIT :cantidad OFFSET :inicio";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->bindParam(':inicio', $inicio, PDO::PARAM_INT);
        
        if (!empty($busqueda)) {
            $termino = '%' . $busqueda . '%';
            $stmt->bindParam(':busqueda', $termino, PDO::PARAM_STR);
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getQuestionById($id) {
        $query = $this->db->prepare("
            SELECT p.*, u.nombre AS autor_nombre, u.url_foto_perfil AS autor_foto
            FROM pregunta p
            INNER JOIN Usuario u ON p.cliente = u.ID_usuario
            WHERE p.ID_pregunta = :id
        ");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getAnswersForQuestion($questionId) {
        $query = $this->db->prepare("
            SELECT r.*, u.nombre AS autor_nombre, u.url_foto_perfil AS autor_foto
            FROM respuesta r
            INNER JOIN Usuario u ON r.colaborador = u.ID_usuario
            WHERE r.id_pregunta = :id
            ORDER BY r.fecha_publicacion ASC
        ");
        $query->bindParam(':id', $questionId, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createAnswer($questionId, $userId, $content) {
        $query = $this->db->prepare("
            INSERT INTO respuesta (id_pregunta, colaborador, contenido, fecha_publicacion)
            VALUES (:pregunta_id, :user_id, :content, NOW())
        ");
        $query->bindParam(':pregunta_id', $questionId, PDO::PARAM_INT);
        $query->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $query->bindParam(':content', $content, PDO::PARAM_STR);
        return $query->execute();
    }
}

?>