<?php
// Lógica básica de PHP para procesar el formulario
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    // Aquí normalmente validarías contra una base de datos
    if (!empty($correo) && !empty($contrasena)) {
        // Simulación de inicio de sesión exitoso
        $mensaje = "<p style='color: green;'>Procesando inicio de sesión para: " . htmlspecialchars($correo) . "</p>";
    } else {
        $mensaje = "<p style='color: red;'>Por favor, llena todos los campos.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión - FixItNow</title>
    <style>
        /* Estilos generales del fondo */
        body {
            background-color: #cecece; 
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column; /* Esto es la magia: apila el header arriba y el main abajo */
            font-family: Arial, sans-serif;
            color: #000;
        }
        .login-container {
            flex-grow: 1; /* Hace que este contenedor tome todo el espacio libre debajo del header */
            display: flex;
            justify-content: center;
            align-items: center;
        }
        /* Contenedor central del login */
        .login-box {
            background-color: #adadad; /* Gris medio del recuadro */
            padding: 40px 50px;
            width: 320px;
            text-align: center;
        }

        .login-box h1 {
            font-size: 32px;
            margin-top: 0;
            margin-bottom: 30px;
        }

        /* Estilos de los inputs (Correo y Contraseña) */
        .input-group {
            margin-bottom: 15px;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #ffffff;
            box-sizing: border-box;
            text-align: center; /* Centra el texto del placeholder */
            font-size: 16px;
            color: #666;
        }

        /* Estilo del botón de Iniciar sesión */
        .btn-submit {
            width: 100%;
            padding: 10px;
            background-color: #757575; /* Gris oscuro */
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

        /* Texto de registro */
        .register-text {
            font-size: 12px;
            line-height: 1.5;
            margin: 0;
        }

        .register-text a {
            color: #000;
            text-decoration: none;
        }
        
        .register-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <header>
<?php
    include 'header_view.php'
    ?>
</header>
    <main class="login-container">
        <div class="login-box">
            <h1>Inicio de sesión</h1>
            
            <?php echo $mensaje; ?>

            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="input-group">
                    <input type="email" name="correo" placeholder="Correo" required>
                </div>
                
                <div class="input-group">
                    <input type="password" name="contrasena" placeholder="Contraseña" required>
                </div>
                
                <button type="submit" class="btn-submit">Iniciar sesión</button>
            </form>

            <p class="register-text">
                ¿No tienes una cuenta?<br>
                <a href="registro.php">Regístrate aquí</a>
            </p>
        </div>
    </main>
</body>
</html>