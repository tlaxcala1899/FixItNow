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
                INNER JOIN Usuario u ON s.profesional_oferta = u.ID_usuario 
                WHERE s.disponible = TRUE ";
        
        if (!empty($busqueda)) {
            $sql .= "AND s.nombre_servicio LIKE :busqueda "; 
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

    public function getServiciosPorProfesional($profesional_id) {
        $sql = "SELECT s.ID, s.nombre_servicio, s.costo, s.disponible, u.nombre AS profesional_nombre 
                FROM servicios s
                INNER JOIN Usuario u ON s.profesional_oferta = u.ID_usuario
                WHERE s.profesional_oferta = :id
                ORDER BY s.ID DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $profesional_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function addServicio($nombre, $profesional_id, $costo) {
        $sql = "INSERT INTO servicios (nombre_servicio, profesional_oferta, costo, disponible) 
                VALUES (:nombre, :profesional, :costo, TRUE)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':profesional', $profesional_id, PDO::PARAM_INT);
        $stmt->bindParam(':costo', $costo, PDO::PARAM_STR);
        return $stmt->execute();
    }
 
    public function toggleDisponibilidad($servicio_id, $profesional_id) {
        $sql = "UPDATE servicios SET disponible = NOT disponible 
                WHERE ID = :id AND profesional_oferta = :profesional";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $servicio_id, PDO::PARAM_INT);
        $stmt->bindParam(':profesional', $profesional_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function getIngresosPorProfesional($profesional_id, $limite = null) {
        $sql = "SELECT ic.ID, u.nombre AS cliente_nombre, ic.fecha_creacion, s.costo, s.nombre_servicio 
                FROM ingresos_cliente ic
                INNER JOIN Usuario u ON ic.cliente = u.ID_usuario
                INNER JOIN servicios s ON ic.servicio = s.ID
                WHERE ic.profesional = :prof_id
                ORDER BY ic.fecha_creacion DESC";
        
        if ($limite !== null) {
            $sql .= " LIMIT :limite";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':prof_id', $profesional_id, PDO::PARAM_INT);
        
        if ($limite !== null) {
            $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMetodoPago($cliente_id) {
        $sql = "SELECT * FROM metodo_pago WHERE cliente = :cliente";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':cliente', $cliente_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function guardarMetodoPago($cliente_id, $numero, $proveedor, $titular, $vencimiento) {
        $metodoActual = $this->getMetodoPago($cliente_id);

        if ($metodoActual) {
            $sql = "UPDATE metodo_pago 
                    SET Numero_tarjeta = :numero, Proveedor_tarjeta = :proveedor, 
                        nombre_titular = :titular, Fecha_vencimiento = :vencimiento 
                    WHERE cliente = :cliente";
        } else {
            $sql = "INSERT INTO metodo_pago (Numero_tarjeta, Proveedor_tarjeta, nombre_titular, Fecha_vencimiento, cliente) 
                    VALUES (:numero, :proveedor, :titular, :vencimiento, :cliente)";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':numero', $numero, PDO::PARAM_STR);
        $stmt->bindParam(':proveedor', $proveedor, PDO::PARAM_STR);
        $stmt->bindParam(':titular', $titular, PDO::PARAM_STR);
        $stmt->bindParam(':vencimiento', $vencimiento, PDO::PARAM_STR);
        $stmt->bindParam(':cliente', $cliente_id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    public function getServiciosContratadosPorCliente($cliente_id, $limite = null) {
        $sql = "SELECT ic.ID, u.nombre AS profesional_nombre, ic.fecha_creacion, s.costo, s.nombre_servicio 
                FROM ingresos_cliente ic
                INNER JOIN Usuario u ON ic.profesional = u.ID_usuario
                INNER JOIN servicios s ON ic.servicio = s.ID
                WHERE ic.cliente = :cli_id
                ORDER BY ic.fecha_creacion DESC";
        
        if ($limite !== null) { $sql .= " LIMIT :limite"; }

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':cli_id', $cliente_id, PDO::PARAM_INT);
        if ($limite !== null) { $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT); }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>