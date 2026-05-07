<?php
class Foro {
    private $db;
    
    public function __construct() {
        require_once("config/database.php");
        $this->db = Conectar::conexion();
        
    }

}

?>