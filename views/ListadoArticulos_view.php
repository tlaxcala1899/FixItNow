<?php

require_once("controllers/ListadoArticulosController.php");

$controlador = new ListadoArticulosController();


$pagina_actual = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
$articulos_por_pagina = 10; 

$articulos = $controlador->obtenerArticulosPaginados($pagina_actual, $articulos_por_pagina);

$hay_mas_articulos = count($articulos) === $articulos_por_pagina;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artículos - FixItNow</title>
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

        .filter-dropdown {
            display: none; 
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            padding: 10px;
            width: 200px;
            z-index: 10;
        }

        .filter-dropdown.show {
            display: block;
        }

        .articulo-btn {
            display: flex;
            background-color: #b5b5b5;
            text-decoration: none;
            color: #000;
            margin-bottom: 15px;
            height: 100px;
            transition: background-color 0.2s;
            border: none;
            padding: 0;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .articulo-btn:hover {
            background-color: #a0a0a0;
        }

        .art-img-box {
            background-color: #ffffff;
            width: 100px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-shrink: 0;
        }

        .art-img-box img {
            width: 60px;
            height: 60px;
            object-fit: cover;
        }

        .art-info-box {
            padding: 15px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .art-titulo {
            font-size: 18px;
            font-weight: bold;
            margin: 0 0 5px 0;
        }

        .art-extracto {
            font-size: 12px;
            margin: 0;
            color: #333;
        }

        .art-categoria {
            padding: 15px;
            display: flex;
            align-items: center;
            font-size: 14px;
            color: #000;
        }

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
        <h1 class="page-title">Artículos</h1>

        <div class="search-bar-container">
            
            <button class="btn-icon" id="btn-filtro" title="Filtrar">
                <svg viewBox="0 0 24 24"><path d="M10 18h4v-2h-4v2zM3 6v2h18V6H3zm3 7h12v-2H6v2z"/></svg>
            </button>

            <div id="filtro-submenu" class="filter-dropdown">
                <h4>Filtrar por:</h4>
                <label><input type="checkbox"> Hardware</label><br>
                <label><input type="checkbox"> Software</label><br>
                <label><input type="checkbox"> Redes</label>
            </div>

            <input type="text" class="search-input" placeholder="buscar" id="input-busqueda">
            
            <button class="btn-icon" title="Buscar">
                <svg viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
            </button>
        </div>

        <div class="articulos-lista">
            <?php if (empty($articulos)): ?>
                <p style="text-align: center;">No se encontraron artículos.</p>
            <?php else: ?>
                
                <?php foreach ($articulos as $articulo): 
        
                    $imgUrl = !empty($articulo['url_img_articulo']) ? $articulo['url_img_articulo'] : 'img_articulos/-1.png';
                ?>
                    
                    <a href="ArticuloCliente.php?id=<?php echo $articulo['version_id']; ?>" class="articulo-btn">
                        
                        <div class="art-img-box">
                            <img src="<?php echo htmlspecialchars($imgUrl); ?>" alt="Imagen artículo">
                        </div>
                        
                        <div class="art-info-box">
                            <h3 class="art-titulo"><?php echo htmlspecialchars($articulo['titulo']); ?></h3>
                            <p class="art-extracto"><?php echo htmlspecialchars(trim($articulo['contenido_resumen'])) . '...'; ?></p>
                        </div>
                        
                        <div class="art-categoria">
                            <?php echo htmlspecialchars($articulo['categoria']); ?>
                        </div>
                    </a>

                <?php endforeach; ?>

            <?php endif; ?>
        </div>

        <div class="pagination-container">
            <a href="?pagina=<?php echo $pagina_actual - 1; ?>" class="btn-page <?php echo ($pagina_actual <= 1) ? 'disabled' : ''; ?>">
                Anterior
            </a>

            <a href="?pagina=<?php echo $pagina_actual + 1; ?>" class="btn-page <?php echo (!$hay_mas_articulos) ? 'disabled' : ''; ?>">
                Siguiente
            </a>
        </div>

    </main>

    <script>
        const btnFiltro = document.getElementById('btn-filtro');
        const submenuFiltro = document.getElementById('filtro-submenu');

        btnFiltro.addEventListener('click', (e) => {
            submenuFiltro.classList.toggle('show');
            e.stopPropagation(); 
        });

        document.addEventListener('click', (e) => {
            if (!submenuFiltro.contains(e.target) && e.target !== btnFiltro) {
                submenuFiltro.classList.remove('show');
            }
        });
    </script>
</body>
</html>