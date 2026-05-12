<?php 
$esColaborador = (isset($_SESSION['usuario_rol']) && strtolower($_SESSION['usuario_rol']) === 'colaborador');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pregunta - FixItNow</title>
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
            margin: 0 auto;
            padding: 20px;
            width: 100%;
            box-sizing: border-box;
            flex-grow: 1;
        }

        h1.page-title {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .question-box {
            background-color: #adadad;
            padding: 20px;
            display: flex;
            margin-bottom: 20px;
            border-radius: 8px;
            position: relative;
        }

        .question-img-box {
            background-color: #ffffff;
            width: 150px;
            height: 150px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-shrink: 0;
            margin-right: 20px;
        }

        .question-img-box img {
            width: 100px;
            height: 100px;
            object-fit: contain;
        }

        .question-text-box {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .question-text {
            font-size: 24px;
            font-weight: normal;
            margin: 0 0 10px 0;
            color: #111;
        }

        .question-author-meta {
            font-size: 13px;
            color: #333;
            text-align: right;
            align-self: flex-end; 
            margin-top: 10px;
        }

        .reply-box-outer {
            background-color: #adadad; 
            padding: 15px;
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        .reply-input-inner {
            flex-grow: 1;
            background-color: #ffffff; 
            padding: 10px;
            margin-right: 15px;
        }

        .reply-input {
            width: 100%;
            height: 80px; 
            border: none;
            font-size: 16px;
            font-family: Arial, sans-serif;
            resize: vertical;
            outline: none;
        }

        .send-btn-icon {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
        }

        .send-btn-icon svg {
            width: 32px;
            height: 32px;
            fill: #000;
        }

        .answers-list {
            margin-top: 20px;
        }

        .answer-box {
            background-color: #b5b5b5; 
            margin-bottom: 15px;
            border-radius: 4px;
            overflow: hidden;
        }

        .answer-body {
            padding: 15px;
            color: #000;
            font-size: 14px;
            line-height: 1.6;
        }

        .answer-body span.answer-prefix {
            font-weight: bold;
        }

        .answer-footer {
            background-color: #8c8c8c; 
            color: white;
            font-size: 12px;
            display: flex;
            justify-content: space-between;
            padding: 8px 15px;
            align-items: center;
        }

        .answer-footer .answer-author-name {
            font-weight: normal;
        }

        .btn-report-reply {
            background-color: transparent;
            color: #fff;
            border: 1px solid #fff;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 11px;
            cursor: pointer;
            margin-left: 10px;
            transition: 0.2s;
        }

        .btn-report-reply:hover {
            background-color: #fff;
            color: #8c8c8c;
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

        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; font-size: 14px; }
        
        .modal-input {
            width: 100%; padding: 10px; border: none;
            border-bottom: 2px solid #222; background-color: #fff;
            box-sizing: border-box; font-family: Arial, sans-serif; resize: vertical;
        }

        .modal-actions { text-align: right; margin-top: 20px; }
        
        .btn-modal {
            background-color: #222; color: white; border: none;
            padding: 8px 20px; border-radius: 50px; font-weight: bold; cursor: pointer;
        }

    </style>
</head>
<body>

    <header>
        <?php include 'header_view.php'; ?>
    </header>

    <main class="main-container">
        <h1 class="page-title">Pregunta</h1>

        <?php if ($question): ?>
            <div class="question-box">
                <div class="question-img-box">
                    <?php $autorFotoUrl = !empty($question['autor_foto']) ? $question['autor_foto'] : 'img/Nophoto.png'; ?>
                    <img src="<?php echo htmlspecialchars($autorFotoUrl); ?>" alt="Foto de perfil">
                </div>
                <div class="question-text-box">
                    <span class="question-text"><?php echo htmlspecialchars($question['pregunta']); ?></span>
                    
                    <div class="question-author-meta">
                        <span>Autor: <?php echo htmlspecialchars($question['autor_nombre']); ?></span><br>
                        <span>Fecha: <?php echo htmlspecialchars(date('d/m/Y', strtotime($question['fecha_publicacion']))); ?></span><br>
                        <span>Hora: <?php echo htmlspecialchars(date('H:i', strtotime($question['fecha_publicacion']))); ?></span>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <p style="text-align: center;">Error: No se pudo cargar la pregunta.</p>
        <?php endif; ?>

        <?php if ($canReply): ?>
            <div class="reply-box-outer">
                <form action="ForoVista.php" method="POST" style="width: 100%; display: flex; align-items: center;">
                    <input type="hidden" name="accion" value="agregar_respuesta">
                    
                    <input type="hidden" name="pregunta_id" value="<?php echo htmlspecialchars($question['ID_pregunta']); ?>">
                    
                    <div class="reply-input-inner">
                        <textarea name="respuesta_content" class="reply-input" placeholder="Repuesta" required></textarea>
                    </div>
                    
                    <button type="submit" class="send-btn-icon" title="Enviar respuesta">
                        <svg viewBox="0 0 24 24"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
                    </button>
                </form>
            </div>
        <?php endif; ?>

        <div class="answers-list">
            <?php if (empty($answers)): ?>
                <p style="text-align: center;">Aún no hay respuestas. ¡Sé el primero en ayudar!</p>
            <?php else: ?>
                <?php foreach ($answers as $answer): ?>
                    <div class="answer-box">
                        <div class="answer-body">
                            <span class="answer-prefix">Respuesta:</span> <?php echo htmlspecialchars($answer['contenido']); ?>
                        </div>
                        <div class="answer-footer">
                            <span class="answer-author-name">Nombre: <?php echo htmlspecialchars($answer['autor_nombre']); ?></span>
                            
                            <div style="display: flex; align-items: center;">
                                <span class="answer-timestamp"><?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($answer['fecha_publicacion']))); ?></span>
                                
                                <?php if ($esColaborador): ?>
                                    <button type="button" class="btn-report-reply" data-id="<?php echo $answer['ID_respuesta']; ?>" onclick="abrirModalReporte(this)">Reportar</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <?php if ($esColaborador): ?>
            <div class="modal-overlay" id="modal-reporte">
                <div class="modal-box">
                    <h2 style="margin-top:0; color:#111;">Reportar Respuesta</h2>
                    <form action="ForoVista.php?id=<?php echo htmlspecialchars($question['ID_pregunta']); ?>" method="POST">
                        <input type="hidden" name="accion" value="reportar_respuesta">
                        
                        <input type="hidden" name="respuesta_id" id="input-respuesta-id" value="">
                        <input type="hidden" name="pregunta_id" value="<?php echo htmlspecialchars($question['ID_pregunta']); ?>">
                        
                        <div class="form-group">
                            <label>Título del reporte</label>
                            <input type="text" name="titulo_reporte" class="modal-input" maxlength="100" required placeholder="Motivo principal...">
                        </div>
                        
                        <div class="form-group">
                            <label>Descripción detallada</label>
                            <textarea name="descripcion_reporte" class="modal-input" rows="4" maxlength="1000" required placeholder="Explica el problema con esta respuesta..."></textarea>
                        </div>
                        
                        <div class="modal-actions">
                            <button type="button" class="btn-modal" style="background-color: transparent; color: #222; border: 2px solid #222; margin-right: 10px;" onclick="cerrarModalReporte()">Cancelar</button>
                            <button type="submit" class="btn-modal">Enviar Reporte</button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                const modalReporte = document.getElementById('modal-reporte');
                const inputRespuestaId = document.getElementById('input-respuesta-id');

                function abrirModalReporte(btn) {
                    inputRespuestaId.value = btn.getAttribute('data-id');
                    modalReporte.style.display = 'flex';
                }

                function cerrarModalReporte() {
                    modalReporte.style.display = 'none';
                }
            </script>
        <?php endif; ?>
        
        <script>
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('msg') === 'reporte_exito') {
                alert('El reporte de la respuesta ha sido enviado al equipo de inspectores con éxito.');
            }
        </script>

    </main>
</body>
</html>