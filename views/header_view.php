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
            <?php 
            $rolHeader = isset($_SESSION['usuario_rol']) ? strtolower($_SESSION['usuario_rol']) : 'sinsesion';

            if ($rolHeader === 'cliente'): ?>
                <a href="ListadoArticulos.php" class="nav-link">Artículos</a>
                <a href="ListadoForos.php" class="nav-link">Foros</a>
                <a href="ListadoServicios.php" class="nav-link">Servicios</a>
                <a href="SobreNosotros.php" class="nav-link">Sobre nosotros</a>
            <?php elseif ($rolHeader === 'profesional'): ?>
                <a href="MisArticulos.php" class="nav-link">Mis artículos</a>
                <a href="ListadoArticulos.php" class="nav-link">Artículos</a>
                <a href="RedactarArticulo.php" class="nav-link">Redactar</a>
                <a href="ListadoForos.php" class="nav-link">Foros</a>
                <a href="MisServicios.php" class="nav-link">Mis servicios</a>
                <a href="IngresosCliente.php" class="nav-link">Ingresos cliente</a>
                <a href="IngresosPlataforma.php" class="nav-link">Pago plataforma</a>
            <?php elseif ($rolHeader === 'colaborador'): ?>
                <a href="ListadoArticulos.php" class="nav-link">Artículos</a>
                <a href="ListadoForos.php" class="nav-link">Foros</a>
                <a href="#" class="nav-link">Mis respuestas</a>
                <a href="SobreNosotros.php" class="nav-link">Sobre nosotros</a>
            <?php elseif ($rolHeader === 'inspector'): ?>
                <a href="ListadoArticulos.php" class="nav-link">Artículos</a>
                <a href="ReporteArticulos.php" class="nav-link">Reporte artículos</a>
                <a href="ReporteRespuestas.php" class="nav-link">Reporte respuestas</a>
                <a href="IngresosPlataforma.php" class="nav-link">Pago plataforma</a>
            <?php else: // sinsesion ?>
                <a href="ListadoArticulos.php" class="nav-link">Artículos</a>
                <a href="ListadoForos.php" class="nav-link">Foros</a>
                <a href="SobreNosotros.php" class="nav-link">Sobre nosotros</a>
            <?php endif; ?>

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