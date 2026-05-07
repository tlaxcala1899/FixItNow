<?php
class Usuario {
    private $db;
    private $usuarios;

    public function __construct() {
        require_once("config/database.php");
        $this->db = Conectar::conexion();
        
    }

    public function getUsuarios() {
        $consulta = $this->db->query("SELECT * FROM usuario LIMIT 10");
        while ($filas = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $this->usuarios[] = $filas;
        }
        return $this->usuarios;
    }
    public function getUsuario($id){
        $consulta = $this->db->query("SELECT * FROM usuario where ID_usuario =".$id);
        while ($filas = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $this->usuario[] = $filas;
        }
        return $this->usuario;
    }
    public function verificarCredenciales($correo,$contrasena_ingresada){
        $query = "SELECT * FROM usuario WHERE correo = :correo LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($usuario) {
            if (password_verify($contrasena_ingresada, $usuario['contrasena'])) {
                return $usuario;
            }
        }
        

        return false;
    }
    public function correoExiste($correo) {
        $query = "SELECT ID_usuario FROM usuario WHERE correo = :correo";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
    public function actualizarFotoPerfil($id, $ruta_foto) {
        $query = "UPDATE Usuario SET url_foto_perfil = :ruta_foto WHERE ID_usuario = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':ruta_foto', $ruta_foto, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function crearUsuario($nombre, $apellido_paterno, $apellido_materno, $correo, $contrasenaEncriptada) {
        
        
        $query = "INSERT INTO usuario (nombre, apellido_paterno, apellido_materno, correo, contrasena,rol) 
                  VALUES (:nombre, :apellido_paterno, :apellido_materno, :correo, :contrasena, 'cliente')";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido_paterno', $apellido_paterno);
        $stmt->bindParam(':apellido_materno', $apellido_materno);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':contrasena', $contrasenaEncriptada);

        return $stmt->execute();
    }
    public function actualizarUsuario($id, $nombre, $apellido_paterno, $apellido_materno, $correo, $cedula) {
        $query = "UPDATE Usuario SET 
                    nombre = :nombre, 
                    apellido_paterno = :apellido_paterno, 
                    apellido_materno = :apellido_materno, 
                    correo = :correo, 
                    cedula = :cedula 
                  WHERE ID_usuario = :id";
        
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido_paterno', $apellido_paterno);
        $stmt->bindParam(':apellido_materno', $apellido_materno);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':cedula', $cedula);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
}
?>