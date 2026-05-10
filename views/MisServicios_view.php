<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Servicios - FixItNow</title>
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

        .btn-anadir-main {
            background-color: #777;
            color: white;
            border: none;
            width: 100%;
            padding: 15px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-bottom: 20px;
            transition: background-color 0.2s;
        }

        .btn-anadir-main:hover {
            background-color: #666;
        }

        .add-form-container {
            background-color: #adadad;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            display: none;
        }

        .add-form-inner {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .input-form {
            padding: 10px;
            border: none;
            font-size: 15px;
        }

        .btn-guardar {
            background-color: #222;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-weight: bold;
        }

        .servicio-card {
            background-color: #adadad;
            margin-bottom: 15px;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
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
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .servicio-costo {
            font-size: 20px;
            color: #111;
        }

        .btn-toggle {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            display: flex;
            align-items: center;
        }

        .icon-active {
            width: 40px;
            height: 40px;
            fill: #333;
        }

        .icon-inactive {
            width: 35px;
            height: 35px;
            fill: #777; 
            opacity: 0.5;
        }

    </style>
</head>
<body>

    <header>
        <?php include 'header_view.php'; ?>
    </header>

    <main class="main-container">
        
        <h1 class="page-title">Mis Servicios</h1>

        <button class="btn-anadir-main" id="btn-mostrar-form">Añadir</button>

        <div class="add-form-container" id="contenedor-formulario">
            <form method="POST" action="MisServicios.php" class="add-form-inner">
                <input type="hidden" name="accion" value="añadir">
                <input type="text" name="nombre_servicio" class="input-form" placeholder="Título del servicio" required style="flex-grow: 1;">
                <input type="number" name="costo" class="input-form" placeholder="Costo ($)" step="50" min="0" required style="width: 100px;">
                <button type="submit" class="btn-guardar">Guardar</button>
            </form>
        </div>

        <div class="servicios-lista">
            <?php if (empty($servicios)): ?>
                <p style="text-align: center;">Aún no ofreces ningún servicio.</p>
            <?php else: ?>
                
                <?php foreach ($servicios as $servicio): ?>
                    <div class="servicio-card">
                        
                        <div class="servicio-info">
                            <span class="servicio-titulo"><?php echo htmlspecialchars($servicio['nombre_servicio']); ?></span>
                            <span class="servicio-profesional"><?php echo htmlspecialchars($servicio['profesional_nombre']); ?></span>
                        </div>
                        
                        <div class="servicio-derecha">
                            <span class="servicio-costo">$<?php echo htmlspecialchars(number_format($servicio['costo'], 2)); ?></span>
                            
                            <form action="MisServicios.php" method="POST" style="margin: 0; display:flex;">
                                <input type="hidden" name="accion" value="toggle">
                                <input type="hidden" name="servicio_id" value="<?php echo $servicio['ID']; ?>">
                                
                                <button type="submit" class="btn-toggle" title="<?php echo $servicio['disponible'] ? 'Desactivar servicio' : 'Activar servicio'; ?>">
                                    <?php if ($servicio['disponible']): ?>
                                        <svg class="icon-active" viewBox="0 0 24 24">
                                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                        </svg>
                                    <?php else: ?>
                                        <svg class="icon-inactive" viewBox="0 0 24 24">
                                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                                        </svg>
                                    <?php endif; ?>
                                </button>
                            </form>

                        </div>
                    </div>
                <?php endforeach; ?>

            <?php endif; ?>
        </div>

    </main>

    <script>
        document.getElementById('btn-mostrar-form').addEventListener('click', function() {
            const form = document.getElementById('contenedor-formulario');
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        });
    </script>
</body>
</html>