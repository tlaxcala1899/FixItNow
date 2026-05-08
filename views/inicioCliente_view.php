<?php
    require_once("controllers/ListadoArticulosController.php");
    $listadoController = new ListadoArticulosController();
    $articulosDestacados = $listadoController->obtenerArticulosPaginados(1, 5);
    require_once("controllers/ListadoForosController.php");
    $forosController = new ListadoForosController();
    $forosDestacados = $forosController->obtenerForosPaginados(1, 4);
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
        <p class="subtitle">Consulta los foros destacados de la semana</p>

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