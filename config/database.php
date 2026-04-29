<?php
class Conectar {
    public static function conexion() {
        try {
            
            $conexion = new PDO('mysql:host=127.0.0.1;port=3307;dbname=fixitnowdb;charset=utf8', 'root', '12345678');
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conexion;
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
?>