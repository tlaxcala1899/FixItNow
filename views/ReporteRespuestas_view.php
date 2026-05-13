<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes de respuestas - FixItNow</title>

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

        .reporte-btn {
            display: flex;
            background-color: #b5b5b5;
            text-decoration: none;
            color: #000;
            margin-bottom: 15px;
            padding: 15px;
            transition: background-color 0.2s;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            align-items: center;
        }

        .reporte-btn:hover {
            background-color: #a0a0a0;
        }

        .reporte-info-box {
            flex-grow: 1;
        }

        .reporte-titulo {
            font-size: 18px;
            font-weight: bold;
            margin: 0 0 5px 0;
        }

        .reporte-extracto {
            font-size: 12px;
            margin: 0;
            color: #333;
        }

    </style>

</head>

<body>
    <main class="main-container">
        <h1 class="page-title">Reportes de respuestas</h1>
        <div class="reportes-lista">
            <?php if (empty($reportes)): ?>

                <p style="text-align: center;">
                    No hay reportes pendientes.
                </p>

            <?php else: ?>
                <?php foreach ($reportes as $reporte): ?>
                    <a href="ReporteRespuesta.php?id=<?php echo $reporte['ID']; ?>" 
                       class="reporte-btn">

                        <div class="reporte-info-box">
                            <h3 class="reporte-titulo">
                                <?php echo htmlspecialchars($reporte['titulo']); ?>
                            </h3>

                            <p class="reporte-extracto">
                                <?php echo htmlspecialchars($reporte['extracto']); ?>...
                            </p>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>