<?php


if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    if ($_POST['accion'] === 'cerrar_sesion') {
        require_once("controllers/LoginController.php"); 
        $controlador = new LoginController();
        $controlador->cerrarSesion();
    } elseif ($_POST['accion'] === 'actualizar_perfil') {
        require_once("controllers/PerfilController.php");
        $perfilControlador = new PerfilController();
        $perfilControlador->actualizarPerfil($_POST);
    }
}

$nombre = $_SESSION['usuario_nombre'] ?? '';
$apellido_paterno = $_SESSION['usuario_apellido_paterno'] ?? '';
$apellido_materno = $_SESSION['usuario_apellido_materno'] ?? '';
$correo = $_SESSION['usuario_correo'] ?? '';
$rol = $_SESSION['usuario_rol'] ?? '';
$foto = !empty($_SESSION['usuario_foto_perfil']) ? $_SESSION['usuario_foto_perfil'] : 'fotos_perfil/-1.png';
$cedula = $_SESSION['usuario_cedula'] ?? '';

$rolMinuscula = strtolower($rol);
$puedeEditarCedula = ($rolMinuscula === 'profesional' || $rolMinuscula === 'inspector');
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
        }

        .info-label {
            font-weight: bold;
            display: block;
            margin-bottom: 4px;
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
        }

        .info-input {
            width: 100%;
            border: none;
            background: transparent;
            font-size: 15px;
            color: #333;
            outline: none;
            font-family: Arial, sans-serif;
            padding: 2px 0;
        }

        .info-input.edit-mode {
            border-bottom: 2px solid #222;
            background-color: #f9f9f9;
        }

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
            padding: 10px;
            border-radius: 50px;
            font-weight: bold;
            border: 2px solid black;
            font-size: 14px;
            cursor: pointer;
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

        .btn-metodo-pago {
            display: inline-block;
            background-color: #222; 
            color: #ffffff;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 50px;
            font-family: Arial, sans-serif;
            font-size: 15px;
            font-weight: bold;
            text-align: center;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-metodo-pago:hover {
            background-color: #444; 
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

            <form method="POST" id="form-perfil" enctype="multipart/form-data">
                <input type="hidden" name="accion" id="accion-input" value="cerrar_sesion">
                
                <div class="info-group" id="grupo-foto" style="display: none;">
                    <span class="info-label">Cambiar foto de perfil</span>
                    <input type="file" name="foto_perfil" class="info-input editable-file" accept="image/*" disabled>
                </div>

                <div class="info-group">
                    <span class="info-label">Nombre</span>
                    <input type="text" name="nombre" class="info-input editable" value="<?php echo htmlspecialchars($nombre); ?>" readonly required>
                </div>

                <div class="info-group">
                    <span class="info-label">Apellido Paterno</span>
                    <input type="text" name="apellido_paterno" class="info-input editable" value="<?php echo htmlspecialchars($apellido_paterno); ?>" readonly required>
                </div>

                <div class="info-group">
                    <span class="info-label">Apellido Materno</span>
                    <input type="text" name="apellido_materno" class="info-input editable" value="<?php echo htmlspecialchars($apellido_materno); ?>" readonly required>
                </div>

                <div class="info-group">
                    <span class="info-label">Correo electrónico</span>
                    <input type="email" name="correo" class="info-input editable" value="<?php echo htmlspecialchars($correo); ?>" readonly required>
                </div>

                <div class="info-group">
                    <span class="info-label">Rol en la plataforma</span>
                    <input type="text" class="info-input" value="<?php echo htmlspecialchars(ucfirst($rol)); ?>" readonly>
                </div>

                <div class="info-group">
                    <span class="info-label">Cédula Profesional</span>
                    <input type="text" name="cedula" class="info-input <?php echo $puedeEditarCedula ? 'editable' : ''; ?>" value="<?php echo htmlspecialchars($cedula); ?>" readonly>
                </div>
                
                <?php if (isset($_SESSION['usuario_rol']) && strtolower($_SESSION['usuario_rol']) === 'cliente'): ?>
                    <a href="MetodoPago.php" class="btn-metodo-pago">Configurar método de pago</a>
                <?php endif; ?>
                <div class="action-buttons">
                    <button type="button" id="btn-editar" class="btn-edit">Editar perfil</button>
                    <button type="submit" id="btn-accion-secundaria" class="btn-logout">Cerrar sesión</button>
                </div>
            </form>
        </div>
    </main>

    <script>
        const btnEditar = document.getElementById('btn-editar');
        const btnAccionSecundaria = document.getElementById('btn-accion-secundaria');
        const inputsEditables = document.querySelectorAll('.editable');
        const inputFile = document.querySelector('.editable-file');
        const grupoFoto = document.getElementById('grupo-foto');
        const accionInput = document.getElementById('accion-input');
        const form = document.getElementById('form-perfil');

        btnEditar.addEventListener('click', (event) => {
            if (btnEditar.type === 'button') {
                event.preventDefault(); 
                
                inputsEditables.forEach(input => {
                    input.readOnly = false;
                    input.classList.add('edit-mode');
                });

                grupoFoto.style.display = 'block';
                inputFile.disabled = false;
                
                btnEditar.textContent = 'Guardar cambios';
                btnEditar.type = 'submit';
                accionInput.value = 'actualizar_perfil';

                btnAccionSecundaria.textContent = 'Cancelar';
                btnAccionSecundaria.type = 'button';
                btnAccionSecundaria.onclick = () => window.location.reload();
            }
        });
    </script>
</body>
</html>