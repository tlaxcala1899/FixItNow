<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($data["titulo"]) ? htmlspecialchars($data["titulo"]) : 'Reportes de Respuestas'; ?> - FixItNow</title>
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
        .page-title {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .reporte-card {
            background: #adadad;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .reporte-titulo {
            margin-top: 0;
            font-size: 20px;
        }
        .acciones-container {
            display: flex; 
            gap: 10px; 
            align-items: center; 
            flex-wrap: wrap;
            margin-top: 15px;
        }
        .btn-foro {
            background-color: #555;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-foro:hover { background-color: #333; }
        .btn-descartar {
            background-color: #888;
            color: white;
            border: none;
            padding: 10px 20px;
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
            padding: 10px 20px;
            border-radius: 50px;
            cursor: pointer;
            font-weight: bold;
        }
        .btn-eliminar:hover { background-color: #000; }
    </style>
</head>
<body>

    

    <main class="main-container">
        <h1 class="page-title">
            <?php echo isset($data["titulo"]) ? htmlspecialchars($data["titulo"]) : 'Bandeja de Reportes'; ?>
        </h1>

        <?php if (empty($data["reportes"])): ?>
            <div class="reporte-card" style="text-align: center;">
                <p>No hay reportes pendientes en este momento.</p>
            </div>
        <?php else: ?>
            
            <?php foreach ($data["reportes"] as $reporte): ?>
                
                <div class="reporte-card">
                    <h2 class="reporte-titulo">
                        #<?php echo htmlspecialchars($reporte['ID']); ?> - <?php echo htmlspecialchars($reporte['titulo']); ?>
                    </h2>

                    <p>
                        <strong>Fecha:</strong> <?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($reporte['fecha_creacion']))); ?>
                    </p>

                    <div style="background-color: #fff; padding: 15px; border-radius: 4px; margin-bottom: 15px;">
                        <strong>Extracto de la descripción:</strong><br>
                        <?php echo nl2br(htmlspecialchars($reporte['extracto'])); ?>...
                    </div>

                    <div class="acciones-container">
                        
                        <a href="ForoVista.php?id=<?php echo htmlspecialchars($reporte['id_pregunta']); ?>" class="btn-foro">
                            Ver en el Foro
                        </a>

                        <form action="ReporteRespuesta.php" method="POST" style="margin: 0;">
                            <input type="hidden" name="id_reporte" value="<?php echo htmlspecialchars($reporte['ID']); ?>">
                            <button type="submit" name="descartar_reporte" class="btn-descartar">
                                Descartar Reporte
                            </button>
                        </form>

                        <form action="ReporteRespuesta.php" method="POST" style="margin: 0;">
                            <input type="hidden" name="id_reporte" value="<?php echo htmlspecialchars($reporte['ID']); ?>">
                            <input type="hidden" name="id_respuesta" value="<?php echo htmlspecialchars($reporte['respuesta']); ?>">
                            <button type="submit" name="eliminar_respuesta" class="btn-eliminar">
                                Eliminar Respuesta Reportada
                            </button>
                        </form>
                        
                    </div>
                </div>

            <?php endforeach; ?>

        <?php endif; ?>
    </main>

</body>
</html>