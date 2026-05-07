<?php
$rolUsuario = strtolower($_SESSION['usuario_rol'] ?? '');
if ($rolUsuario !== 'cliente') {
    header("Location: inicio.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hacer una Pregunta</title>
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
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
            width: 100%;
            box-sizing: border-box;
            flex-grow: 1;
        }

        .edit-box {
            background-color: #adadad;
            padding: 30px;
            border-radius: 8px;
        }

        .edit-box h1 {
            font-size: 32px;
            margin-top: 0;
            margin-bottom: 20px;
        }

        .info-group {
            background-color: #ffffff;
            margin-bottom: 15px;
            padding: 15px;
            text-align: left;
            border-radius: 4px;
        }

        .info-label {
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #333;
            text-transform: uppercase;
        }

        .info-input {
            width: 100%;
            border: none;
            background: #f9f9f9;
            font-size: 16px;
            color: #333;
            outline: none;
            font-family: Arial, sans-serif;
            padding: 10px;
            box-sizing: border-box;
            border-bottom: 2px solid #222;
        }

        textarea.info-input {
            resize: vertical;
            min-height: 150px;
            line-height: 1.5;
        }

        .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
            gap: 15px;
        }

        .btn-save {
            flex: 1;
            background-color: #222;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 50px;
            font-size: 16px;
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
            font-size: 16px;
            cursor: pointer;
            text-align: center;
        }

        .btn-cancel:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>

    <header>
        <?php include 'header_view.php'; ?>
    </header>

    <main class="main-container">
        <div class="edit-box">
            <h1>Hacer una pregunta al foro</h1>
            
            <?php if (isset($error)): ?>
                <p style="color: red; font-weight: bold; background: white; padding: 10px;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <form method="POST" action="RedactarPregunta.php">
                <input type="hidden" name="accion" value="crear_pregunta">

                <div class="info-group">
                    <span class="info-label">Describe tu problema o duda</span>
                    <textarea name="pregunta" class="info-input" placeholder="Ej: Mi computadora emite 3 pitidos cortos al encender y no da video, ¿qué puede ser?" maxlength="400" required></textarea>
                </div>

                <div class="action-buttons">
                    <a href="ListadoForos.php" class="btn-cancel">Cancelar</a>
                    <button type="submit" class="btn-save">Publicar Pregunta</button>
                </div>
            </form>
        </div>
    </main>

</body>
</html>
