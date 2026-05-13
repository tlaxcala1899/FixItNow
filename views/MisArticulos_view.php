<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis artículos - FixItNow</title>
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
    </style>
</head>
<body>

    <header>
        <?php include 'header_view.php'; ?>
    </header>

    <main class="main-container">
        <h1 class="page-title">Mis artículos</h1>

        <div class="articulos-lista">
            <?php if (empty($misArticulos)): ?>
                <p style="text-align: center;">No has escrito ningún artículo todavía.</p>
            <?php else: ?>
                <?php foreach ($misArticulos as $articulo): ?>
                    <a href="ArticuloCliente.php?id=<?php echo $articulo['version_id']; ?>" class="articulo-btn">
                        <div class="art-img-box">
                            <img src="img_articulos/-1.png" alt="Imagen artículo">
                        </div>
                        <div class="art-info-box">
                            <h3 class="art-titulo"><?php echo htmlspecialchars($articulo['titulo']); ?></h3>
                            <p class="art-extracto"><?php echo htmlspecialchars(trim($articulo['extracto'])) . '...'; ?></p>
                        </div>
                        <div class="art-categoria">
                            <?php echo htmlspecialchars($articulo['categoria']); ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

</body>
</html>