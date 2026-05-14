<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagos Plataforma - FixItNow</title>
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

        .pago-card {
            background-color: #adadad;
            margin-bottom: 15px;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 4px;
        }

        .pago-info {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .pago-titulo {
            font-size: 18px;
            color: #111;
            font-weight: bold;
        }

        .pago-fecha {
            font-size: 14px;
            color: #333;
        }

        .pago-costo {
            font-size: 22px;
            font-weight: bold;
            color: #111;
        }

        .pago-id {
            font-size: 11px;
            color: #444;
            background-color: #999;
            padding: 2px 6px;
            border-radius: 4px;
            align-self: flex-start;
        }
    </style>
</head>
<body>

    <header>
        <?php include 'header_view.php'; ?>
    </header>

    <main class="main-container">
        <h1 class="page-title">Pagos de la plataforma</h1>

        <div class="pagos-lista">
            <?php if (empty($pagos)): ?>
                <p style="text-align: center; background-color: #adadad; padding: 20px;">No se han registrado pagos aún.</p>
            <?php else: ?>
                
                <?php foreach ($pagos as $pago): ?>
                    <div class="pago-card">
                        <div class="pago-info">
                            <span class="pago-id">ID: #<?php echo htmlspecialchars($pago['ID_ingreso']); ?></span>
                            <span class="pago-titulo">Pago Mensual FixItNow</span>
                            <span class="pago-fecha">Fecha de cobro: <?php echo date('d/m/Y H:i', strtotime($pago['fecha_pago'])); ?></span>
                        </div>
                        
                        <div class="pago-costo">
                            $<?php echo number_format($pago['ingreso'], 2); ?>
                        </div>
                    </div>
                <?php endforeach; ?>

            <?php endif; ?>
        </div>
    </main>
</body>
</html>
