<?php
class Servicio {
    private $db;
    
    public function __construct() {
        require_once("config/database.php");
        $this->db = Conectar::conexion();
        
    }
    public function getServicios($busqueda = '') {
        $sql = "SELECT s.ID, s.nombre_servicio, s.costo, s.profesional_oferta, u.nombre AS profesional_nombre 
                FROM servicios s
                INNER JOIN Usuario u ON s.profesional_oferta = u.ID_usuario ";
        
        if (!empty($busqueda)) {
            $sql .= "WHERE s.nombre_servicio LIKE :busqueda ";
        }
        
        $sql .= "ORDER BY s.nombre_servicio ASC";

        $stmt = $this->db->prepare($sql);

        if (!empty($busqueda)) {
            $termino = '%' . $busqueda . '%';
            $stmt->bindParam(':busqueda', $termino, PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function tieneMetodoPago($cliente_id) {
        $sql = "SELECT COUNT(*) as total FROM metodo_pago 
                WHERE cliente = :cliente_id 
                AND Numero_tarjeta != '' 
                AND Proveedor_tarjeta != '' 
                AND nombre_titular != '' 
                AND Fecha_vencimiento != ''";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row['total'] > 0;
    }

    public function contratarServicio($cliente_id, $profesional_id, $servicio_id) {
        $sql = "INSERT INTO ingresos_cliente (cliente, profesional, servicio, fecha_creacion) 
                VALUES (:cliente, :profesional, :servicio, NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':cliente', $cliente_id, PDO::PARAM_INT);
        $stmt->bindParam(':profesional', $profesional_id, PDO::PARAM_INT);
        $stmt->bindParam(':servicio', $servicio_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

}

?>