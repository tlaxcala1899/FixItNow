<?php


if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'cerrar_sesion') {
    require_once("controllers/LoginController.php"); 
    $controlador = new LoginController();
    $controlador->cerrarSesion();
}

$nombreCompleto = $_SESSION['usuario_nombreCompleto'];
$correo = $_SESSION['usuario_correo'];
$rol = ucfirst($_SESSION['usuario_rol']);
$foto = !empty($_SESSION['usuario_foto_perfil']) ? $_SESSION['usuario_foto_perfil'] : 'img/default-avatar.png';
$cedula = !empty($_SESSION['usuario_cedula']) ? $_SESSION['usuario_cedula'] : 'No registrada';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - FixItNow</title>
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

        .profile-box {
            background-color: #adadad; 
            padding: 40px 50px;
            width: 400px;
            text-align: center;
            border-radius: 8px;
        }

        .profile-box h1 {
            font-size: 32px;
            margin-top: 0;
            margin-bottom: 20px;
        }

        .big-profile-pic {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #222;
            margin-bottom: 20px;
        }
        .info-group {
            background-color: #ffffff;
            margin-bottom: 12px;
            padding: 10px;
            text-align: left;
            font-size: 15px;
            color: #333;
        }

        .info-label {
            font-weight: bold;
            display: block;
            margin-bottom: 4px;
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
        }
/
        .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
            gap: 15px;
        }

        .btn-edit {
            flex: 1;
            background-color: white;
            color: black;
            text-decoration: none;
            padding: 10px;
            border-radius: 50px;
            font-weight: bold;
            border: 2px solid black;
            font-size: 14px;
            transition: 0.3s;
        }

        .btn-edit:hover {
            background-color: #f0f0f0;
        }

        
        .btn-logout {
            flex: 1;
            background-color: #222;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 50px;
            font-size: 14px;
            cursor: pointer;
            transition: 0.3s;
            font-weight: bold;
        }

        .btn-logout:hover {
            background-color: #444;
        }

        
        .logout-form {
            flex: 1;
            display: flex;
            margin: 0;
        }
    </style>
</head>
<body>

    <header>
        <?php include 'header_view.php'; ?>
    </header>

    <main class="login-container">
        <div class="profile-box">
            <h1>Mi Perfil</h1>
            
            <img src="<?php echo htmlspecialchars($foto); ?>" alt="Foto de perfil" class="big-profile-pic">

            <div class="info-group">
                <span class="info-label">Nombre completo</span>
                <?php echo htmlspecialchars($nombreCompleto); ?>
            </div>

            <div class="info-group">
                <span class="info-label">Correo electrónico</span>
                <?php echo htmlspecialchars($correo); ?>
            </div>

            <div class="info-group">
                <span class="info-label">Rol en la plataforma</span>
                <?php echo htmlspecialchars($rol); ?>
            </div>

            <div class="info-group">
                <span class="info-label">Cédula Profesional</span>
                <?php echo htmlspecialchars($cedula); ?>
            </div>

            <div class="action-buttons">
                <a href="editar_perfil_view.php" class="btn-edit">Editar perfil</a>
                
                <form method="POST" class="logout-form">
                    <input type="hidden" name="accion" value="cerrar_sesion">
                    <button type="submit" class="btn-logout">Cerrar sesión</button>
                </form>
            </div>
            
        </div>
    </main>

</body>
</html>