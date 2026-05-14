<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte #<?php echo htmlspecialchars($reporte['ID']); ?> - FixItNow</title>
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
        .reporte-completo {
            background: #f5f5f5;
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
        }
        .reporte-titulo {
            font-size: 22px;
            margin-top: 0;
        }
        .reporte-descripcion {
            white-space: pre-wrap;
            line-height: 1.6;
        }
        .acciones-container {
            display: flex; 
            gap: 10px; 
            align-items: center; 
            flex-wrap: wrap;
        }
        .btn-ver-articulo {
            background: #555;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-ver-articulo:hover { background: #333; }
        .btn-descartar {
            background-color: #888;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-descartar:hover { background-color: #666; }
        .btn-eliminar {
            background-color: #222;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 50px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-eliminar:hover { background-color: #000; }
    </style>
</head>
<body>
    <header><?php include 'header_view.php'; ?></header>
    <main class="main-container">
        <h1 class="page-title">Reporte #<?php echo htmlspecialchars($reporte['ID']); ?></h1>

        <div class="reporte-completo">
            <h2 class="reporte-titulo"><?php echo htmlspecialchars($reporte['titulo']); ?></h2>
            <p><strong>Fecha:</strong> <?php echo htmlspecialchars($reporte['fecha_creacion']); ?></p>
            <div class="reporte-descripcion">
                <?php echo nl2br(htmlspecialchars($reporte['descripcion'])); ?>
            </div>
        </div>

        <div class="acciones-container">
            <?php if (!empty($reporte['version_id'])): ?>
                
                <a href="ArticuloCliente.php?id=<?php echo htmlspecialchars($reporte['version_id']); ?>" class="btn-ver-articulo">
                    Ver artículo reportado
                </a>

                <form action="ReporteArticulo.php" method="POST" style="margin: 0;">
                    <input type="hidden" name="id_reporte" value="<?php echo htmlspecialchars($reporte['ID']); ?>">
                    <button type="submit" name="descartar_reporte" class="btn-descartar">Descartar Reporte</button>
                </form>

                <form action="ReporteArticulo.php" method="POST" style="margin: 0;">
                    <input type="hidden" name="id_reporte" value="<?php echo htmlspecialchars($reporte['ID']); ?>">
                    <input type="hidden" name="id_version" value="<?php echo htmlspecialchars($reporte['version_id']); ?>">
                    <button type="submit" name="eliminar_version" class="btn-eliminar">Eliminar Versión</button>
                </form>

            <?php else: ?>
                
                <p>No se encontró el artículo asociado.</p>
                <form action="ReporteArticulo.php" method="POST" style="margin: 0;">
                    <input type="hidden" name="id_reporte" value="<?php echo htmlspecialchars($reporte['ID']); ?>">
                    <button type="submit" name="descartar_reporte" class="btn-descartar">Descartar Reporte</button>
                </form>

            <?php endif; ?>
        </div>
    </main>

</body>
</html>