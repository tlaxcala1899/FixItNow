<?php


$rolUsuario = strtolower($_SESSION['usuario_rol'] ?? '');
$esProfesional = ($rolUsuario === 'profesional');

$imgUrl = (!empty($articulo['url_img_articulo'])) ? $articulo['url_img_articulo'] : 'img/default-camera.png';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($articulo['titulo'] ?? 'Artículo'); ?> - FixItNow</title>
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

        .main-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
            width: 100%;
            box-sizing: border-box;
            flex-grow: 1;
        }

        .article-box {
            background-color: #adadad;
            padding: 30px;
            border-radius: 8px;
        }

        .article-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .article-title {
            font-size: 32px;
            margin: 0;
            color: #000;
            flex-grow: 1;
        }
0
        .btn-edit-article {
            background-color: #222;
            color: white;
            text-decoration: none;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: bold;
            transition: background-color 0.3s;
            white-space: nowrap;
            margin-left: 20px;
            border: none;
            cursor: pointer;
        }

        .btn-edit-article:hover {
            background-color: #444;
        }

        .article-image {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            background-color: white;
            border: 2px solid #222;
            margin-bottom: 20px;
        }

        .article-meta {
            background-color: #b5b5b5;
            padding: 10px 15px;
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            margin-bottom: 20px;
            border-left: 4px solid #222;
        }

        .article-content {
            background-color: #ffffff;
            padding: 25px;
            font-size: 16px;
            line-height: 1.6;
            color: #333;
            border-radius: 4px;
            white-space: pre-wrap; 
        }
    </style>
</head>
<body>

    <header>
        <?php include 'header_view.php'; ?>
    </header>

    <main class="main-container">
        
        <?php if (!empty($articulo)): ?>
            <div class="article-box">
                
                <div class="article-header">
                    <h1 class="article-title"><?php echo htmlspecialchars($articulo['titulo']); ?></h1>
                    
                    <?php if ($esProfesional): ?>
                        <a href="EditarArticulo_view.php?id=<?php echo $articulo['ID']; ?>&version=<?php echo $articulo['version_id']; ?>" class="btn-edit-article">
                            Editar artículo
                        </a>
                    <?php endif; ?>
                </div>

                

                <div class="article-meta">
                    <span><strong>Categoría:</strong> <?php echo htmlspecialchars($articulo['categoria']); ?></span>
                    <span><strong>Editor / Autor:</strong> <?php echo htmlspecialchars($articulo['editor']); ?></span>
                </div>

                <div class="article-content"><?php echo htmlspecialchars($articulo['contenido']); ?></div>
                <img src="<?php echo "img_articulos/".htmlspecialchars($imgUrl); ?>" alt="Imagen del artículo" class="article-image">
            </div>
        <?php else: ?>
            <div class="article-box">
                <h1 class="article-title">Artículo no encontrado</h1>
                <p>El artículo que intentas leer no existe o ha sido eliminado.</p>
            </div>
        <?php endif; ?>

    </main>

</body>
</html>
