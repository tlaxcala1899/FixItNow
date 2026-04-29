<?php
// controllers/AuthController.php

class AuthController {
    public function procesarLogin($correo, $password) {
        // ... lógica para buscar al usuario en la base de datos ...
        
        // Supongamos que la base de datos te devolvió este arreglo:
        $usuario_db = [
            'id' => 26,
            'nombre' => 'Admin de Prueba',
            'rol' => 'Administrador'
        ];

        // GUARDAMOS EN LA SESIÓN
        // $_SESSION es un arreglo. Puedes inventar los nombres de las claves.
        $_SESSION['logueado'] = true;
        $_SESSION['usuario_id'] = $usuario_db['usuario_db'];
        $_SESSION['usuario_nombre'] = $usuario_db['nombre'];
        $_SESSION['usuario_rol'] = $usuario_db['rol'];

        // Redirigir al panel principal
        header("Location: dashboard.php");
        exit();
    }
}
?>