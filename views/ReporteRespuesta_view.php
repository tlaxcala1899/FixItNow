<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte #<?php echo $reporte['ID']; ?> - FixItNow</title>

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

        .respuesta-reportada {
            background: #e9e9e9;
            border: 1px solid #bbb;
            padding: 15px;
            margin-top: 20px;
            white-space: pre-wrap;
            line-height: 1.6;
        }

        .btn-eliminar {
            display: inline-block;
            background: #8b0000;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: bold;
            margin-top: 20px;
            border: none;
            cursor: pointer;
        }

        .btn-eliminar:hover {
            background: #a80000;
        }

    </style>

</head>

<body>

    <main class="main-container">

        <h1 class="page-title">
            Reporte #<?php echo $reporte['ID']; ?>
        </h1>

        <div class="reporte-completo">
            <h2 class="reporte-titulo">
                <?php echo htmlspecialchars($reporte['titulo']); ?>
            </h2>

            <p>
                <strong>Fecha:</strong>
                <?php echo $reporte['fecha_creacion']; ?>
            </p>

            <div class="reporte-descripcion">
                <?php echo nl2br(htmlspecialchars($reporte['descripcion'])); ?>
            </div>

            <h3>Respuesta reportada</h3>

            <div class="respuesta-reportada">
                <?php echo nl2br(htmlspecialchars($reporte['contenido'])); ?>
            </div>

            <form action="ReporteRespuesta.php" method="POST">
                <input type="hidden"
                       name="id_respuesta"
                       value="<?php echo $reporte['ID_respuesta']; ?>">

                <button type="submit"
                        name="eliminar_respuesta"
                        class="btn-eliminar">
                </button>
            </form>
        </div>
    </main>
</body>
</html>