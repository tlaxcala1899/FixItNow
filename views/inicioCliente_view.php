<?php
    require_once("controllers/ListadoArticulosController.php");
    $listadoController = new ListadoArticulosController();
    $articulosDestacados = $listadoController->obtenerArticulosPaginados(1, 5);
    require_once("controllers/ListadoForosController.php");
    $forosController = new ListadoForosController();
    $forosDestacados = $forosController->obtenerForosPaginados(1, 5);


    $rolLogueado = strtolower($_SESSION['usuario_rol'] ?? '');
    $idLogueado = $_SESSION['usuario_id'] ?? null;
    $serviciosUsuario = [];

    if ($idLogueado) {
        require_once("models/Servicio.php");
        $modeloServicio = new Servicio();
        
        if ($rolLogueado === 'cliente') {
            $serviciosUsuario = $modeloServicio->getServiciosContratadosPorCliente($idLogueado, 3);
        } elseif ($rolLogueado === 'profesional') {
            $serviciosUsuario = $modeloServicio->getIngresosPorProfesional($idLogueado, 3);
        }
    }
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    
</head>

<?php
    include 'header_view.php'
?>
<body>
    <link rel="stylesheet" href="css/inicioCliente.css">
  <main class="main-content">
    <section class="intro-section">
        <h1>FixItNow</h1>
        <p>
            En FixItNow creemos que la tecnología no tiene que ser un dolor de cabeza, por lo que somos una comunidad creada para ayudarte a que aprendas a solucionar problemas por tu cuenta con nuestro foro colaborativo, y el sitio donde también puedes contratar a un experto certificado que solucione el problema por ti.
        </p>
    </section>

    <h2 class="section-title">Artículos destacados</h2>
    <section class="content-box">
      
        
        <?php if (!empty($articulosDestacados)): ?>
            <?php foreach ($articulosDestacados as $articulo): 
                $imgUrl =  $articulo['url_img_articulo'];
            ?>
            <a href="ArticuloCliente.php?id=<?php echo $articulo['version_id']; ?>" style="text-decoration: none; color: inherit;">
                <div class="article-card">
                    <div class="icon-box">
                        <img src="<?php echo htmlspecialchars($imgUrl); ?>" alt="Imagen artículo" class="placeholder-icon" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="text-box">
                        <span class="card-title"><?php echo htmlspecialchars($articulo['titulo']); ?></span>
                        <span class="card-excerpt"><?php echo htmlspecialchars(trim($articulo['contenido_resumen'])) . '...'; ?></span>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align: center;">No hay artículos destacados en este momento.</p>
        <?php endif; ?>

        <div style="text-align: center; margin-top: 25px;">
            <a href="ListadoArticulos.php" style="background-color: #222; color: white; padding: 10px 25px; text-decoration: none; border-radius: 50px; font-weight: bold; font-size: 14px;">Ver más artículos</a>
        </div>
    </section>

    <h2 class="section-title">Foros destacados</h2>
    <section class="content-box">

        <?php if (!empty($forosDestacados)): ?>
            <?php foreach ($forosDestacados as $foro): 
                $extracto = !empty($foro['extracto_respuesta']) ? trim($foro['extracto_respuesta']) . '...' : 'Aún no hay respuestas.';
            ?>
            <a href="ForoVista.php?id=<?php echo $foro['ID_pregunta']; ?>" style="text-decoration: none; color: inherit; display: block; margin-bottom: 15px;">
                <div class="forum-card" style="background-color: #b5b5b5; padding: 15px; border-radius: 4px; display: flex; flex-direction: column; justify-content: space-between; min-height: 80px;">
                    <div class="forum-text">
                        <span class="card-title" style="font-weight: bold; font-size: 18px; color: #000; display: block; margin-bottom: 5px;">
                            <?php echo htmlspecialchars($foro['pregunta']); ?>
                        </span>
                        <span class="card-excerpt" style="font-size: 14px; color: #333; display: block;">
                            <?php echo htmlspecialchars($extracto); ?>
                        </span>
                    </div>
                    <span class="user-label" style="text-align: right; font-size: 12px; color: #111; margin-top: 15px;">
                        <?php echo htmlspecialchars($foro['usuario_nombre']); ?>
                    </span>
                </div>
            </a>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align: center;">No hay foros destacados en este momento.</p>
        <?php endif; ?>

        <div style="text-align: center; margin-top: 25px;">
            <a href="ListadoForos.php" style="background-color: #222; color: white; padding: 10px 25px; text-decoration: none; border-radius: 50px; font-weight: bold; font-size: 14px; display: inline-block;">Ver más foros</a>
        </div>
    </section>
    <?php if ($rolLogueado === 'cliente'): ?>
        <h2 class="section-title">Mis contrataciones recientes</h2>
        <section class="content-box">
            <p class="subtitle">Servicios que has solicitado a nuestros profesionales</p>
            
            <?php if (empty($serviciosUsuario)): ?>
                <p style="text-align: center; color: #555;">Aún no has contratado ningún servicio.</p>
            <?php else: foreach ($serviciosUsuario as $s): ?>
                <div class="article-card" style="background-color: #b5b5b5; margin-bottom: 10px; padding: 15px; display: flex; justify-content: space-between;">
                    <div>
                        <span style="display: block; font-weight: bold; font-size: 16px;"><?php echo htmlspecialchars($s['nombre_servicio']); ?></span>
                        <span style="font-size: 13px; color: #333;">Atendido por: <?php echo htmlspecialchars($s['profesional_nombre']); ?></span>
                    </div>
                    <div style="text-align: right;">
                        <span style="display: block; font-weight: bold;">$<?php echo number_format($s['costo'], 2); ?></span>
                        <span style="font-size: 11px;"><?php echo date('d/m/Y', strtotime($s['fecha_creacion'])); ?></span>
                    </div>
                </div>
            <?php endforeach; endif; ?>
            
            <div style="text-align: center; margin-top: 20px;">
                <a href="ListadoServicios.php" style="background-color: #222; color: white; padding: 8px 20px; text-decoration: none; border-radius: 50px; font-size: 13px;">Contratar más servicios</a>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($rolLogueado === 'profesional'): ?>
        <h2 class="section-title">Resumen de servicios dados</h2>
        <section class="content-box">
            <p class="subtitle">Últimos servicios que has brindado a la comunidad</p>
            
            <?php if (empty($serviciosUsuario)): ?>
                <p style="text-align: center; color: #555;">No hay ventas registradas recientemente.</p>
            <?php else: foreach ($serviciosUsuario as $s): ?>
                <div class="article-card" style="background-color: #b5b5b5; margin-bottom: 10px; padding: 15px; display: flex; justify-content: space-between;">
                    <div>
                        <span style="display: block; font-weight: bold; font-size: 16px;"><?php echo htmlspecialchars($s['nombre_servicio']); ?></span>
                        <span style="font-size: 13px; color: #333;">Cliente: <?php echo htmlspecialchars($s['cliente_nombre']); ?></span>
                    </div>
                    <div style="text-align: right;">
                        <span style="display: block; font-weight: bold; color: #1a4d1a;">+$<?php echo number_format($s['costo'], 2); ?></span>
                        <span style="font-size: 11px;"><?php echo date('d/m/Y', strtotime($s['fecha_creacion'])); ?></span>
                    </div>
                </div>
            <?php endforeach; endif; ?>

            <div style="text-align: center; margin-top: 20px;">
                <a href="IngresosCliente.php" style="background-color: #222; color: white; padding: 8px 20px; text-decoration: none; border-radius: 50px; font-size: 13px;">Ver historial completo</a>
            </div>
        </section>
    <?php endif; ?>
    <?php if (isset($_SESSION['usuario_rol']) && strtolower($_SESSION['usuario_rol']) === 'cliente'): ?>
        <h2 class="section-title">Nuestros servicios</h2>
        <section class="content-box services-box">
            
            <div class="service-card">
                <div class="service-image">
                    <img src="img/software.png" alt="Software">
                </div>
                <div class="service-label">Software</div>
            </div>

            <div class="service-card">
                <div class="service-image">
                    <img src="img/hardware.png" alt="Hardware">
                </div>
                <div class="service-label">Hardware</div>
            </div>
            
    <?php endif; ?>
    </section>
</main>
</body>
</html>