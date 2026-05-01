<?php
class Conectar {
    public static function conexion() {
        try {
            
            if(!isset($_SESSION['usuario_id'])){
                $conexion = new PDO('mysql:host=127.0.0.1;port=3307;dbname=fixitnowdb;charset=utf8', 'sin_sesion', '12345678');
                return $conexion;
                }
            else if($_SESSION['usuario_rol']== 'cliente'){
                $conexion = new PDO('mysql:host=127.0.0.1;port=3307;dbname=fixitnowdb;charset=utf8', 'cliente', '12345678');
                return $conexion;
            }
            else if($_SESSION['usuario_rol']== 'profesional'){
                $conexion = new PDO('mysql:host=127.0.0.1;port=3307;dbname=fixitnowdb;charset=utf8', 'profesional', '12345678');
                return $conexion;
            }
            else if($_SESSION['usuario_rol']== 'colaborador'){
                $conexion = new PDO('mysql:host=127.0.0.1;port=3307;dbname=fixitnowdb;charset=utf8', 'colaborador', '12345678');
                return $conexion;
            }
            else if($_SESSION['usuario_rol']== 'inspector'){
                $conexion = new PDO('mysql:host=127.0.0.1;port=3307;dbname=fixitnowdb;charset=utf8', 'inspector', '12345678');
                return $conexion;
            }
            return null;
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
?>