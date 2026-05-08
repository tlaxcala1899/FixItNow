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
                            <span class="answer-timestamp"><?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($answer['fecha_publicacion']))); ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </main>
</body>
</html>