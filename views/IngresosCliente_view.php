<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Ingresos - FixItNow</title>
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
            margin-bottom: 30px;
            font-weight: bold;
        }

        /* Tarjetas de Ingresos */
        .ingreso-card {
            background-color: #adadad;
            margin-bottom: 15px;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 4px;
        }

        .ingreso-info {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .ingreso-titulo {
            font-size: 20px;
            color: #111;
            font-weight: bold;
        }

        .ingreso-detalle {
            font-size: 14px;
            color: #333;
        }
        
        .ingreso-detalle span {
            font-weight: bold;
            color: #000;
        }

        .ingreso-derecha {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 10px;
        }

        .ingreso-costo {
            font-size: 22px;
            font-weight: bold;
            color: #111;
        }

        .ingreso-id {
            font-size: 12px;
            color: #444;
            background-color: #999;
            padding: 3px 8px;
            border-radius: 50px;
        }

    </style>
</head>
<body>

    <header>
        <?php include 'header_view.php'; ?>
    </header>

    <main class="main-container">
        
        <h1 class="page-title">Historial de Ingresos</h1>

        <div class="ingresos-lista">
            <?php if (empty($ingresos)): ?>
                <p style="text-align: center; background-color: #adadad; padding: 20px; border-radius: 4px;">Aún no tienes contrataciones registradas.</p>
            <?php else: ?>
                
                <?php foreach ($ingresos as $ingreso): ?>
                    <div class="ingreso-card">
                        
                        <div class="ingreso-info">
                            <span class="ingreso-titulo"><?php echo htmlspecialchars($ingreso['nombre_servicio']); ?></span>
                            <span class="ingreso-detalle">Cliente: <span><?php echo htmlspecialchars($ingreso['cliente_nombre']); ?></span></span>
                            <span class="ingreso-detalle">Fecha: <span><?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($ingreso['fecha_creacion']))); ?></span></span>
                        </div>
                        
                        <div class="ingreso-derecha">
                            <span class="ingreso-costo">$<?php echo htmlspecialchars(number_format($ingreso['costo'], 2)); ?></span>
                            <span class="ingreso-id">ID Contrato: #<?php echo htmlspecialchars($ingreso['ID']); ?></span>
                        </div>
                        
                    </div>
                <?php endforeach; ?>

            <?php endif; ?>
        </div>

    </main>
</body>
</html>
