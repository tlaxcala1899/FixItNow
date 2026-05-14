<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nosotros - FixItNow</title>
    <link rel="stylesheet" href="css/header.css">
    
    <style>
        /* COLORES ACORDES A LA PÁGINA (Gris claro) */
        body { 
            font-family: Arial, sans-serif; 
            line-height: 1.6; 
            color: #000000; 
            background-color: #d1d1d1; 
            margin: 0;
            padding: 0;
        }
        
        .container { 
            max-width: 900px; 
            margin: 40px auto; 
            padding: 30px; 
            background: #e6e6e6; 
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }

        h1 { 
            color: #000000; 
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        h2 { 
            color: #333333; 
            border-bottom: 2px solid #888888; 
            padding-bottom: 8px; 
            margin-top: 30px;
        }

        p {
            font-size: 1.1em;
            color: #222222;
        }

        .roles-container { 
            display: flex; 
            flex-wrap: wrap;
            gap: 20px; 
            margin-top: 20px; 
        }

        .rol-card { 
            background: #d1d1d1; 
            padding: 20px; 
            border-radius: 8px; 
            flex: 1; 
            min-width: 250px;
            border: 1px solid #b3b3b3;
        }

        .rol-card h3 {
            color: #000000;
            margin-top: 0;
        }
    </style>
</head>
<body>
    <header><?php include 'header_view.php'; ?></header>

    <div class="container">
        <h1>Sobre Nosotros</h1>
        
        <h2>¿Qué es FixItNow?</h2>
        <p>FixItNow es una página web a la cual personas de todo el mundo pueden ingresar y encontrar soluciones a sus problemas con hardware o software para cualquier dispositivo electrónico. Nuestro objetivo principal es ser un sitio seguro donde puedas consultar diferentes métodos para reparar y arreglar tus dispositivos de manera efectiva y sin dañarlos.</p>

        <h2>Nuestra Problemática y Misión</h2>
        <p>Alrededor del 81% de las personas interactúa con dispositivos electrónicos a diario, sin embargo, una parte considerable de esa población no tiene siquiera los conocimientos más básicos sobre la forma correcta de usarlos o cómo solucionar problemas comunes. Para nosotros, la principal problemática fue no tener un sitio seguro y verificado para hacer consultas fiables.</p>
        <p>Además, FixItNow responde a la urgente necesidad de reducir la basura electrónica global. Al facilitar el 'derecho a reparar', extendemos la vida útil de los dispositivos y combatimos la obsolescencia programada, promoviendo un consumo tecnológico más responsable y sostenible para el planeta.</p>

        <h2>¿Cómo Funciona Nuestra Comunidad?</h2>
        <p>Lo que nos diferencia de otras páginas son nuestras reseñas verificadas y nuestro equipo de soporte. El sistema opera mediante un flujo escalonado eficiente sustentado en tres roles principales:</p>
        
        <div class="roles-container">
            <div class="rol-card">
                <h3>🤝 Colaboradores</h3>
                <p>Usuarios con conocimiento técnico encargados de compartir los métodos que se llevan a cabo para hacer las reparaciones de manera efectiva y sugerir actualizaciones a los artículos.</p>
            </div>
            <div class="rol-card">
                <h3>🔍 Inspectores</h3>
                <p>Trabajadores de la plataforma que se encargan de supervisar a los colaboradores y autorizar los artículos, haciendo que las guías y reseñas se conviertan en algo totalmente confiable e inteligible.</p>
            </div>
            <div class="rol-card">
                <h3>🛠️ Profesionales</h3>
                <p>Expertos certificados que se encargan de modificar reseñas, supervisar que la información sea correcta y asesorar en tiempo real. En casos críticos, pueden ser contratados para reparar por sí mismos los dispositivos dañados de los usuarios.</p>
            </div>
        </div>

        <h2>Nuestro Compromiso Contigo</h2>
        <p>Queremos que nuestros usuarios potenciales sean personas de todas las edades. Entendemos la urgencia de una falla técnica, por ello desarrollamos una interfaz intuitiva y totalmente responsiva, al alcance de cualquier persona con acceso a Internet.</p>
        <p>Buscamos romper la brecha digital. Nuestra plataforma transforma el lenguaje técnico complejo en instrucciones accesibles, empoderando a personas de cualquier edad o nivel educativo para que pierdan el miedo a su propia tecnología.</p>
    </div>

</body>
</html>