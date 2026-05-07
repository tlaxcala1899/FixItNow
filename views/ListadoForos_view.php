<?php
require_once("controllers/ListadoForosController.php");

$controlador = new ListadoForosController();

$pagina_actual = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
$foros_por_pagina = 5; 

$foros = $controlador->obtenerForosPaginados($pagina_actual, $foros_por_pagina);
$hay_mas_foros = count($foros) === $foros_por_pagina;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foros - FixItNow</title>
    <style>
        body {
            background-color: #cecece; 
            margin: 0;
            font-family: Arial, sans-serif;
            color: #000;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .main-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            width: 100%;
            box-sizing: border-box;
        }

        h1.page-title {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .search-bar-container {
            background-color: #b5b5b5; 
            padding: 10px;
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            position: relative; 
        }

        .btn-icon {
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px 10px;
        }

        .btn-icon svg {
            width: 24px;
            height: 24px;
            fill: #000;
        }

        .search-input {
            flex-grow: 1;
            padding: 10px;
            border: none;
            margin: 0 10px;
            font-size: 16px;
        }

        .foro-btn {
            display: flex;
            background-color: #b5b5b5;
            text-decoration: none;
            color: #000;
            margin-bottom: 15px;
            min-height: 100px;
            transition: background-color 0.2s;
            border: none;
            padding: 0;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .foro-btn:hover {
            background-color: #a0a0a0;
        }

        .foro-img-box {
            background-color: #ffffff;
            width: 100px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-shrink: 0;
        }

        .foro-img-box img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
        }

        .foro-info-box {
            padding: 15px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .foro-usuario {
            font-size: 16px;
            font-weight: normal;
            margin: 0 0 4px 0;
        }

        .foro-pregunta {
            font-size: 15px;
            font-weight: normal;
            margin: 0 0 4px 0;
            color: #111;
        }

        .foro-extracto {
            font-size: 13px;
            margin: 0;
            color: #333;
        }

        /* PAGINACIÓN */
        .pagination-container {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 30px;
        }

        .btn-page {
            background-color: #222;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: bold;
        }

        .btn-page.disabled {
            background-color: #777;
            pointer-events: none;
        }
    </style>
</head>
<body>

    <header>
        <?php include 'header_view.php'; ?>
    </header>

    <main class="main-container">
        <h1 class="page-title">Foros</h1>

        <div class="search-bar-container">
            <button class="btn-icon" title="Filtrar">
                <svg viewBox="0 0 24 24"><path d="M10 18h4v-2h-4v2zM3 6v2h18V6H3zm3 7h12v-2H6v2z"/></svg>
            </button>

            <input type="text" class="search-input" placeholder="buscar">
            
            <button class="btn-icon" title="Buscar">
                <svg viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
            </button>
        </div>

        <div class="foros-lista">
            <?php if (empty($foros)): ?>
                <p style="text-align: center;">No hay foros disponibles en este momento.</p>
            <?php else: ?>
                
                <?php foreach ($foros as $foro): 
                    $imgUrl = !empty($foro['usuario_foto']) ? $foro['usuario_foto'] : 'img/default-avatar.png';
                    
                    $extracto = !empty($foro['extracto_respuesta']) ? trim($foro['extracto_respuesta']) . '...' : 'Aún no hay respuestas. ¡Sé el primero en ayudar!';
                ?>
                    
                    <a href="ForoRespuesta.php?id=<?php echo $foro['ID_pregunta']; ?>" class="foro-btn">
                        <div class="foro-img-box">
                            <img src="<?php echo htmlspecialchars($imgUrl); ?>" alt="Foto de perfil">
                        </div>
                        
                        <div class="foro-info-box">
                            <span class="foro-usuario"><?php echo htmlspecialchars($foro['usuario_nombre']); ?></span>
                            <span class="foro-pregunta"><?php echo htmlspecialchars($foro['pregunta']); ?></span>
                            <span class="foro-extracto"><?php echo htmlspecialchars($extracto); ?></span>
                        </div>
                    </a>

                <?php endforeach; ?>

            <?php endif; ?>
        </div>

        <div class="pagination-container">
            <a href="?pagina=<?php echo $pagina_actual - 1; ?>" class="btn-page <?php echo ($pagina_actual <= 1) ? 'disabled' : ''; ?>">
                Anterior
            </a>
            <a href="?pagina=<?php echo $pagina_actual + 1; ?>" class="btn-page <?php echo (!$hay_mas_foros) ? 'disabled' : ''; ?>">
                Siguiente
            </a>
        </div>

    </main>
</body>
</html>
</html>
