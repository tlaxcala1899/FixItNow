<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios - FixItNow</title>
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
            font-weight: bold;
        }

        .search-bar-container {
            background-color: #b5b5b5; 
            padding: 15px;
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            border-radius: 4px;
        }

        .btn-icon {
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px 10px;
        }

        .btn-icon svg {
            width: 28px;
            height: 28px;
            fill: #000;
        }

        .search-form {
            display: flex;
            flex-grow: 1;
            align-items: center;
        }

        .search-input {
            flex-grow: 1;
            padding: 12px;
            border: none;
            margin: 0 10px;
            font-size: 16px;
        }

        .servicio-card {
            background-color: #adadad;
            margin-bottom: 15px;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 4px;
        }

        .servicio-info {
            display: flex;
            flex-direction: column;
        }

        .servicio-titulo {
            font-size: 20px;
            color: #111;
            margin-bottom: 5px;
        }

        .servicio-profesional {
            font-size: 13px;
            color: #333;
        }

        .servicio-derecha {
            text-align: right;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 10px;
        }

        .servicio-costo {
            font-size: 20px;
            color: #111;
        }

        .btn-contratar {
            background-color: #222;
            color: white;
            border: none;
            padding: 8px 16px;
            font-size: 14px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.2s;
        }

        .btn-contratar:hover {
            background-color: #444;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            color: white;
            text-align: center;
            font-weight: bold;
        }
        .alert-success { background-color: #4CAF50; }
        .alert-error { background-color: #f44336; }

    </style>
</head>
<body>

    <header>
        <?php include 'header_view.php'; ?>
    </header>

    <main class="main-container">
        
        <?php if ($mensaje === 'Servicio_contratado'): ?>
            <div class="alert alert-success">¡Servicio contratado exitosamente!</div>
        <?php endif; ?>
        <?php if ($error === 'Sin_metodo_pago'): ?>
            <div class="alert alert-error">Error: Debes registrar un método de pago válido antes de contratar.</div>
        <?php endif; ?>

        <h1 class="page-title">Servicios</h1>

        <div class="search-bar-container">
            <button class="btn-icon" title="Filtrar">
                <svg viewBox="0 0 24 24"><path d="M10 18h4v-2h-4v2zM3 6v2h18V6H3zm3 7h12v-2H6v2z"/></svg>
            </button>

            <form method="GET" action="ListadoServicios.php" class="search-form">
                <input type="text" name="buscar" class="search-input" placeholder="buscar" value="<?php echo htmlspecialchars($busqueda); ?>">
                
                <button type="submit" class="btn-icon" title="Buscar">
                    <svg viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                </button>
            </form>
        </div>

        <div class="servicios-lista">
            <?php if (empty($servicios)): ?>
                <p style="text-align: center;">No se encontraron servicios disponibles.</p>
            <?php else: ?>
                
                <?php foreach ($servicios as $servicio): ?>
                    <div class="servicio-card">
                        
                        <div class="servicio-info">
                            <span class="servicio-titulo"><?php echo htmlspecialchars($servicio['nombre_servicio']); ?></span>
                            <span class="servicio-profesional"><?php echo htmlspecialchars($servicio['profesional_nombre']); ?></span>
                        </div>
                        
                        <div class="servicio-derecha">
                            <span class="servicio-costo">$<?php echo htmlspecialchars(number_format($servicio['costo'], 2)); ?></span>
                            
                            <?php if ($esCliente): ?>
                                <?php if ($tieneMetodoPago): ?>
                                    <form action="ListadoServicios.php" method="POST" style="margin: 0;">
                                        <input type="hidden" name="accion" value="contratar">
                                        <input type="hidden" name="servicio_id" value="<?php echo $servicio['ID']; ?>">
                                        <input type="hidden" name="profesional_id" value="<?php echo $servicio['profesional_oferta']; ?>">
                                        <button type="submit" class="btn-contratar">Contratar</button>
                                    </form>
                                <?php else: ?>
                                    <button type="button" class="btn-contratar" onclick="alert('Debes registrar un método de pago en tu perfil con todos los datos antes de poder contratar un servicio.')">Contratar</button>
                                <?php endif; ?>
                            <?php endif; ?>

                        </div>
                    </div>
                <?php endforeach; ?>

            <?php endif; ?>
        </div>

    </main>
</body>
</html>