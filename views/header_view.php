<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/header.css">
</head>
<body>
    <header class="main-header">
        <div class="logo-container">
            <a href="inicio.php">
                <img src="img/fixitnow_blanco_chico.png" alt="FixItNow Logo" class="logo-img">
            </a>
        </div>

        <nav class="nav-menu">
            <a href="#" class="nav-link">Articulos</a>
            <a href="#" class="nav-link">Foros</a>
            <a href="#" class="nav-link">Servicios</a>
            <a href="#" class="nav-link">Sobre nosotros</a>

            <?php 
            
            if (isset($_SESSION['usuario_id'])): 
                
                
                $rutaFoto = !empty($_SESSION['usuario_foto_perfil']) ? $_SESSION['usuario_foto_perfil'] : 'img/Nophoto.png';
            ?>
                
                <a href="perfil.php" class="profile-button">
                    <img src="<?php echo htmlspecialchars($rutaFoto); ?>" alt="Mi Perfil" style="width: 45px; height: 45px; border-radius: 50%; object-fit: cover; border: 2px solid #222;">
                </a>

            <?php else: ?>
               
                <div class="auth-buttons">
                    <a href="Registro.php" class="btn-register">Registrarse</a>
                    <a href="login.php" class="btn-login">Iniciar sesión</a>
                </div>
            <?php endif; ?>
            
        </nav>
    </header>
</body>
</html>