<?php
class Usuario {
    private $db;
    private $usuarios;

    public function __construct() {
        require_once("config/database.php");
        $this->db = Conectar::conexion();
        $this->usuarios = array();
    }

    public function getUsuarios() {
        $consulta = $this->db->query("SELECT * FROM usuario");
        while ($filas = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $this->usuario[] = $filas;
        }
        return $this->usuario;
    }
    public function getUsuario($id){
        $consulta = $this->db->query("SELECT * FROM usuario where id =",$id);
        while ($filas = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $this->usuario[] = $filas;
        }
        return $this->usuario;
    }
}
?>