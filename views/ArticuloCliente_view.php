<?php


$rolUsuario = strtolower($_SESSION['usuario_rol'] ?? '');
$esProfesional = ($rolUsuario === 'profesional');
$esColaborador = ($rolUsuario === 'colaborador');
$imgUrl = (!empty($articulo['url_img_articulo'])) ? $articulo['url_img_articulo'] : 'img/default-camera.png';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($articulo['titulo'] ?? 'Artículo'); ?> - FixItNow</title>
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

        .article-box {
            background-color: #adadad;
            padding: 30px;
            border-radius: 8px;
        }

        .article-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .article-title {
            font-size: 32px;
            margin: 0;
            color: #000;
            flex-grow: 1;
        }

        .btn-edit-article {
            background-color: #222;
            color: white;
            text-decoration: none;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: bold;
            transition: background-color 0.3s;
            white-space: nowrap;
            margin-left: 20px;
            border: none;
            cursor: pointer;
        }

        .btn-edit-article:hover {
            background-color: #444;
        }

        .article-image {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            background-color: white;
            border: 2px solid #222;
            margin-bottom: 20px;
        }

        .article-meta {
            background-color: #b5b5b5;
            padding: 10px 15px;
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            margin-bottom: 20px;
            border-left: 4px solid #222;
        }

        .article-content {
            background-color: #ffffff;
            padding: 25px;
            font-size: 16px;
            line-height: 1.6;
            color: #333;
            border-radius: 4px;
            white-space: pre-wrap; 
        }
        .btn-report-article {
            background-color: #777; 
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: bold;
            transition: background-color 0.3s;
            white-space: nowrap;
            margin-left: 20px;
            border: none;
            cursor: pointer;
        }

        .btn-report-article:hover {
            background-color: #555;
        }

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.6);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-box {
            background-color: #cecece;
            padding: 30px;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            font-size: 14px;
        }

        .modal-input {
            width: 100%;
            padding: 10px;
            border: none;
            border-bottom: 2px solid #222;
            background-color: #fff;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            resize: vertical;
        }

        .modal-actions {
            text-align: right;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <header>
        <?php include 'header_view.php'; ?>
    </header>

    <main class="main-container">
        
        <?php if (!empty($articulo)): ?>
            <div class="article-box">
                
                <div class="article-header">
                    <h1 class="article-title"><?php echo htmlspecialchars($articulo['titulo']); ?></h1>
                    
                    <?php if ($esProfesional): ?>
                        <a href="EditarArticulo.php?id=<?php echo $articulo['ID']; ?>&version=<?php echo $articulo['version_id']; ?>" class="btn-edit-article">
                            Editar artículo
                        </a>
                         
                    <?php endif; ?>
                    <?php if ($esColaborador): ?>
                        <button type="button" class="btn-report-article" id="btn-abrir-modal">
                            Reportar artículo
                        </button>
                    <?php endif; ?>
                </div>

                

                <div class="article-meta">
                    <span><strong>Categoría:</strong> <?php echo htmlspecialchars($articulo['categoria']); ?></span>
                    <span><strong>Editor / Autor:</strong> <?php echo htmlspecialchars($articulo['editor']); ?></span>
                </div>

                <div class="article-content"><?php echo htmlspecialchars($articulo['contenido']); ?></div>
                <img src="<?php echo htmlspecialchars($imgUrl); ?>" alt="Imagen del artículo" class="article-image"> 
            </div>
        <?php else: ?>
            <div class="article-box">
                <h1 class="article-title">Artículo no encontrado</h1>
                <p>El artículo que intentas leer no existe o ha sido eliminado.</p>
            </div>
        <?php endif; ?>
        
        
        <?php if ($esColaborador): ?>
            <div class="modal-overlay" id="modal-reporte">
                <div class="modal-box">
                    <h2 style="margin-top:0; color:#111;">Reportar Artículo</h2>
                    <form action="ArticuloCliente.php?id=<?php echo htmlspecialchars($_GET['id'] ?? ''); ?>" method="POST">
                        <input type="hidden" name="accion" value="reportar_articulo">
                        <input type="hidden" name="id_version" value="<?php echo $version['ID']; ?>">

                        <div class="form-group">
                            <label>Título del reporte</label>
                            <input type="text" name="titulo_reporte" class="modal-input" maxlength="100" required placeholder="Motivo principal...">
                        </div>
                        
                        <div class="form-group">
                            <label>Descripción detallada</label>
                            <textarea name="descripcion_reporte" class="modal-input" rows="4" maxlength="1000" required placeholder="Explica el problema con este artículo..."></textarea>
                        </div>
                        
                        <div class="modal-actions">
                            <button type="button" class="btn-edit-article" style="background-color: transparent; color: #222; border: 2px solid #222;" id="btn-cerrar-modal">Cancelar</button>
                            <button type="submit" class="btn-edit-article">Enviar Reporte</button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                const modal = document.getElementById('modal-reporte');
                document.getElementById('btn-abrir-modal').addEventListener('click', () => {
                    modal.style.display = 'flex';
                });
                document.getElementById('btn-cerrar-modal').addEventListener('click', () => {
                    modal.style.display = 'none';
                });
            </script>
        <?php endif; ?>

    </main>
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('msg') === 'reporte_exito') {
            alert('El reporte ha sido enviado al equipo de inspectores con éxito.');
        }
    </script>
</body>
</html>
