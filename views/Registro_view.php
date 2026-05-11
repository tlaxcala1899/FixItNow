<?php

if (isset($_SESSION['usuario_id'])) {
    header("Location: inicioCliente.php");
    exit();
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'] ?? '';
    $apellido_paterno = $_POST['apellido_paterno'] ?? '';
    $apellido_materno = $_POST['apellido_materno'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    if (!empty($nombre) && !empty($correo) && !empty($contrasena)) {
        
        $mensaje = "<p style='color: green; font-size: 14px;'>Procesando registro...</p>";
        $resultado = $this->procesarRegistro($nombre, $apellido_paterno, $apellido_materno, $correo, $contrasena);
        if($resultado == true){
            $mensaje= "<p style='color: green; font-size: 14px;'>Registro exitoso</p>";
            $x = new LoginController();
            $x->procesarLogin($correo,$contrasena);
            header("Location: inicio.php");
            exit();
        }
        else{
            $mensaje="<p style='color: red; font-size: 14px;'>Error al crear la cuenta, puede que el correo ya este en uso</p>";
        }
    } else {
        $mensaje = "<p style='color: red; font-size: 14px;'>Por favor, llena todos los campos.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta - FixItNow</title>
    <style>
        
        body {
            background-color: #cecece; 
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column; 
            font-family: Arial, sans-serif;
            color: #000;
        }

        .login-container {
            flex-grow: 1; 
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px; 
        }

        .login-box {
            background-color: #adadad; 
            padding: 40px 50px;
            width: 320px;
            text-align: center;
        }

        .login-box h1 {
            font-size: 32px;
            margin-top: 0;
            margin-bottom: 25px;
        }

        .input-group {
            margin-bottom: 12px;
        }

        .input-group input {
            width: 100%;
            padding: 8px;
            border: none;
            background-color: #ffffff;
            box-sizing: border-box;
            text-align: center; 
            font-size: 15px;
            color: #666;
        }

        .btn-submit {
            width: 100%;
            padding: 10px;
            background-color: #757575; 
            color: #000;
            border: none;
            font-size: 16px;
            cursor: pointer;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .btn-submit:hover {
            background-color: #5c5c5c;
        }

        .register-text {
            font-size: 12px;
            line-height: 1.5;
            margin: 0;
            color: #333;
        }

        .register-text a {
            color: #333;
            text-decoration: none;
        }
        
        .register-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <?php include 'header_view.php'; ?>
    </header>

    <main class="login-container">
        <div class="login-box">
            <h1>Crear cuenta</h1>
            
            <?php echo $mensaje; ?>

            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                
                <div class="input-group">
                    <input type="text" name="nombre" placeholder="Nombre" required>
                </div>
                <div class="input-group">
                    <input type="text" name="apellido_paterno" placeholder="Apellido paterno" required>
                </div>
                <div class="input-group">
                    <input type="text" name="apellido_materno" placeholder="Apellido materno" required>
                </div>
                <div class="input-group">
                    <input type="email" name="correo" placeholder="Correo" required>
                </div>
                <div class="input-group">
                    <input type="password" name="contrasena" placeholder="Contraseña" required>
                </div>
                
                <button type="submit" name="btn_registrar" class="btn-submit">Registrarse</button>
            </form>

            <p class="register-text">
                ¿Ya tienes una cuenta?<br>
                <a href="login.php">Inicia sesión aquí</a>
            </p>
        </div>
    </main>
</body>
</html>