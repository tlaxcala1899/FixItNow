<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Método de Pago - FixItNow</title>
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
            flex-grow: 1; 
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px; 
        }

        .edit-box {
            background-color: #adadad;
            padding: 40px 50px;
            width: 100%;
            max-width: 450px;
            border-radius: 8px;
            text-align: center;
        }

        .edit-box h1 {
            font-size: 28px;
            margin-top: 0;
            margin-bottom: 25px;
            color: #111;
        }

        .info-group {
            background-color: #ffffff;
            margin-bottom: 15px;
            padding: 12px 15px;
            text-align: left;
            border-radius: 4px;
        }

        .info-label {
            font-weight: bold;
            display: block;
            margin-bottom: 6px;
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
        }

        .info-input {
            width: 100%;
            border: none;
            background: transparent;
            font-size: 16px;
            color: #333;
            outline: none;
            font-family: Arial, sans-serif;
            padding: 5px 0;
            border-bottom: 2px solid #222;
        }

        /* Ocultar flechas de inputs numéricos */
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none; 
            margin: 0; 
        }

        .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            gap: 15px;
        }

        .btn-save {
            flex: 1;
            background-color: #222;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 50px;
            font-size: 15px;
            cursor: pointer;
            transition: 0.3s;
            font-weight: bold;
        }

        .btn-save:hover {
            background-color: #444;
        }

        .btn-cancel {
            flex: 1;
            background-color: white;
            color: black;
            text-decoration: none;
            padding: 12px;
            border-radius: 50px;
            font-weight: bold;
            border: 2px solid black;
            font-size: 15px;
            cursor: pointer;
            display: inline-block;
        }

        .btn-cancel:hover {
            background-color: #f0f0f0;
        }

        .alert {
            padding: 10px;
            margin-bottom: 20px;
            color: white;
            font-weight: bold;
            border-radius: 4px;
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
        <div class="edit-box">
            <h1>Método de Pago</h1>
            
            <?php if ($mensaje === 'exito'): ?>
                <div class="alert alert-success">Método de pago guardado correctamente.</div>
            <?php elseif ($mensaje === 'error'): ?>
                <div class="alert alert-error">Error al guardar los datos. Intenta nuevamente.</div>
            <?php elseif ($mensaje === 'incompleto'): ?>
                <div class="alert alert-error">Por favor llena todos los campos.</div>
            <?php endif; ?>

            <form method="POST" action="MetodoPago.php">
                <input type="hidden" name="accion" value="guardar_pago">

                <div class="info-group">
                    <span class="info-label">Nombre del Titular</span>
                    <input type="text" name="nombre_titular" class="info-input" placeholder="Ej. Juan Pérez" value="<?php echo isset($metodoActual['nombre_titular']) ? htmlspecialchars($metodoActual['nombre_titular']) : ''; ?>" required>
                </div>

                <div class="info-group">
                    <span class="info-label">Número de Tarjeta</span>
                    <input type="number" name="numero_tarjeta" class="info-input" placeholder="0000 0000 0000 0000" value="<?php echo isset($metodoActual['Numero_tarjeta']) ? htmlspecialchars($metodoActual['Numero_tarjeta']) : ''; ?>" maxlength="20" required>
                </div>

                <div style="display: flex; gap: 15px;">
                    <div class="info-group" style="flex: 1;">
                        <span class="info-label">Proveedor</span>
                        <select name="proveedor_tarjeta" class="info-input" required>
                            <option value="">Selecciona...</option>
                            <option value="Visa" <?php echo (isset($metodoActual['Proveedor_tarjeta']) && $metodoActual['Proveedor_tarjeta'] == 'Visa') ? 'selected' : ''; ?>>Visa</option>
                            <option value="Mastercard" <?php echo (isset($metodoActual['Proveedor_tarjeta']) && $metodoActual['Proveedor_tarjeta'] == 'Mastercard') ? 'selected' : ''; ?>>Mastercard</option>
                            <option value="American Express" <?php echo (isset($metodoActual['Proveedor_tarjeta']) && $metodoActual['Proveedor_tarjeta'] == 'American Express') ? 'selected' : ''; ?>>American Express</option>
                        </select>
                    </div>

                    <div class="info-group" style="flex: 1;">
                        <span class="info-label">Vencimiento (MM/AA)</span>
                        <input type="text" name="fecha_vencimiento" class="info-input" placeholder="12/25" value="<?php echo isset($metodoActual['Fecha_vencimiento']) ? htmlspecialchars($metodoActual['Fecha_vencimiento']) : ''; ?>" maxlength="5" required>
                    </div>
                </div>

                <div class="action-buttons">
                    <a href="inicio.php" class="btn-cancel">Cancelar</a>
                    <button type="submit" class="btn-save">Guardar Datos</button>
                </div>
            </form>
        </div>
    </main>

</body>
</html>