
CREATE DATABASE fixitnowdb;
USE fixitnowdb;

SELECT * FROM usuario;

UPDATE usuario SET rol = 'profesional' WHERE id_usuario=2;
DELETE FROM version_1 WHERE id=10;
UPDATE version_1 SET url_img_articulo = 'img_articulos/-1.png' WHERE id=2;

SELECT * FROM articulo;
SELECT * FROM version_1;
SELECT * FROM respuesta;
/*--UPDATE usuario SET url_foto_perfil =null;
ALTER TABLE usuario ADD CONSTRAINT correo UNIQUE (correo);

*/

DELIMITER //
CREATE PROCEDURE postArticulo(
    ntitulo VARCHAR(100),
    ncategoria VARCHAR(50),
    nredactor INT,
    nurl_img_articulo VARCHAR(255),
    ncontenido VARCHAR(4000)
)
DETERMINISTIC 
BEGIN
    DECLARE narticulo INT;
    
    INSERT INTO articulo(titulo, categoria, redactor) 
    VALUES (ntitulo, ncategoria, nredactor);
    
    SET narticulo = LAST_INSERT_ID();
    
    INSERT INTO version_1(editor, articulo, url_img_articulo, contenido) 
    VALUES (nredactor, narticulo, nurl_img_articulo, ncontenido);
END // 
DELIMITER ;

UPDATE TABLE  

call postArticulo('Ventajas de usar linux','sistemas operativos',2,'-1.png','En un mundo donde los sistemas operativos comerciales dominan la mayoría de los ordenadores personales, Linux se presenta como una alternativa potente, gratuita y cada vez más accesible. Aunque durante años se le consideró un sistema reservado para programadores y entusiastas, hoy en día sus ventajas lo convierten en una opción atractiva para todo tipo de usuarios.

La ventaja más evidente es que Linux es completamente gratuito. No solo no pagas por instalar el sistema operativo, sino que tampoco necesitas licencias para usarlo en múltiples equipos. Al ser de código abierto, cualquier persona puede estudiar, modificar y distribuir el sistema, lo que fomenta la transparencia y la confianza.

Linux es famoso por su sólida seguridad. Su arquitectura basada en permisos y la separación de privilegios dificultan la propagación de virus y malware. La gran mayoría de las amenazas dirigidas a Windows no afectan a Linux, y las actualizaciones de seguridad se gestionan de forma centralizada, rápida y eficiente.

¿Tienes un ordenador antiguo? Linux puede darle una segunda vida. Distribuciones como Xubuntu o Linux Mint con entornos ligeros funcionan fluidamente en equipos con pocos recursos. Además, Linux es famoso por su estabilidad: puede permanecer encendido durante semanas o meses sin necesidad de reiniciarse, algo habitual en servidores y estaciones de trabajo.

Desde el aspecto visual hasta el comportamiento del sistema, Linux te permite modificar prácticamente todo. Puedes elegir entre decenas de "entornos de escritorio" (GNOME, KDE, XFCE, etc.) o incluso prescindir del entorno gráfico si lo deseas. Esta flexibilidad no tiene equivalente en otros sistemas operativos.

En Linux, el usuario decide cuándo y cómo actualizar. No hay reinicios forzados ni largas esperas. Puedes continuar trabajando mientras se descargan las actualizaciones en segundo plano, y la mayoría de cambios no requieren reiniciar el equipo.

Linux no es perfecto —puede tener una curva de aprendizaje inicial y algún que otro problema de compatibilidad con hardware muy nuevo—, pero sus ventajas en cuanto a libertad, seguridad, rendimiento y control lo convierten en una alternativa digna de consideración. Si buscas un sistema operativo que respete tu privacidad, funcione bien incluso en equipos modestos y te permita aprender y modificar cada detalle, darle una oportunidad a Linux puede ser una de las mejores decisiones tecnológicas que tomes.')


SELECT A.ID,V.ID AS version_id, A.titulo,  A.categoria, 
            LEFT(V.contenido, 100) AS contenido_resumen,V.url_img_articulo,  U.nombre AS editor
            FROM Articulo AS A 
            INNER JOIN Version_1 AS V ON A.ID = V.articulo 
            INNER JOIN Usuario AS U ON V.editor = U.ID_usuario
            ORDER BY V.fecha_creacion 
            LIMIT 10 OFFSET 0 ;

SELECT A.ID, V.ID AS version_id, A.titulo,  A.categoria, 
            V.contenido,V.url_img_articulo,  U.nombre AS editor
            FROM Articulo AS A 
            INNER JOIN Version_1 AS V ON A.ID = V.articulo 
            INNER JOIN Usuario AS U ON V.editor = U.ID_usuario
           	WHERE V.ID = 2;

CREATE USER 'sin_sesion'@'localhost' IDENTIFIED BY '12345678';
REVOKE ALL PRIVILEGES, GRANT OPTION FROM 'sin_sesion'@'localhost';
GRANT SELECT, INSERT ON fixitnowdb.usuario TO 'sin_sesion'@'localhost';
GRANT SELECT ON fixitnowdb.articulo TO 'sin_sesion'@'localhost';
GRANT SELECT ON fixitnowdb.version_1 TO 'sin_sesion'@'localhost';
GRANT SELECT ON fixitnowdb.pregunta TO 'sin_sesion'@'localhost';
GRANT SELECT xitnowdb.respuesta TO 'sin_sesion'@'localhost';


CREATE USER 'cliente'@'localhost' IDENTIFIED BY '12345678';
REVOKE ALL PRIVILEGES, GRANT OPTION FROM 'cliente'@'localhost';
GRANT SELECT, update  ON fixitnowdb.usuario TO 'cliente'@'localhost';
GRANT SELECT ON fixitnowdb.articulo TO 'cliente'@'localhost';
GRANT SELECT ON fixitnowdb.version_1 TO 'cliente'@'localhost';
GRANT SELECT,INSERT ON fixitnowdb.pregunta TO 'cliente'@'localhost';
GRANT SELECT ON fixitnowdb.respuesta TO 'cliente'@'localhost';
GRANT SELECT ON fixitnowdb.servicios TO 'cliente'@'localhost';
GRANT SELECT, INSERT ON  fixitnowdb.ingresos_cliente TO  'cliente'@'localhost';
GRANT SELECT,INSERT, UPDATE  ON fixitnowdb.metodo_pago TO 'cliente'@'localhost';



CREATE USER 'profesional'@'localhost' IDENTIFIED BY '12345678';
REVOKE ALL PRIVILEGES, GRANT OPTION FROM 'profesional'@'localhost';
GRANT SELECT,UPDATE,INSERT ON fixitnowdb.usuario TO 'profesional'@'localhost';
GRANT SELECT,INSERT ON fixitnowdb.articulo TO 'profesional'@'localhost';
GRANT SELECT,INSERT,update ON fixitnowdb.version_1 TO 'profesional'@'localhost';
GRANT SELECT ON fixitnowdb.pregunta TO 'profesional'@'localhost';
GRANT SELECT,INSERT  ON fixitnowdb.respuesta TO 'profesional'@'localhost';
GRANT SELECT, INSERT, DELETE,UPDATE ON fixitnowdb.servicios TO 'profesional'@'localhost';
GRANT SELECT ON fixitnowdb.ingresos_cliente TO 'profesional'@'localhost';
GRANT SELECT, INSERT ON fixitnowdb.ingresos_plataforma TO 'profesional'@'localhost';


CREATE USER 'colaborador'@'localhost' IDENTIFIED BY '12345678';
REVOKE ALL PRIVILEGES, GRANT OPTION FROM 'colaborador'@'localhost';
GRANT SELECT,update ON fixitnowdb.usuario TO 'colaborador'@'localhost';
GRANT SELECT ON fixitnowdb.articulo TO 'colaborador'@'localhost';
GRANT SELECT ON fixitnowdb.pregunta TO 'colaborador'@'localhost';
GRANT SELECT ON fixitnowdb.respuesta TO 'colaborador'@'localhost';
GRANT SELECT ON fixitnowdb.version_1 TO 'colaborador'@'localhost';
GRANT INSERT ON fixitnowdb.reporte_articulo TO 'colaborador'@'localhost';
GRANT INSERT ON fixitnowdb.reporte_respuesta TO 'colaborador'@'localhost';



CREATE USER 'inspector'@'localhost' IDENTIFIED BY '12345678';
REVOKE ALL PRIVILEGES, GRANT OPTION FROM 'inspector'@'localhost';
GRANT SELECT,update ON fixitnowdb.usuario TO 'inspector'@'localhost';
GRANT SELECT ON fixitnowdb.articulo TO 'inspector'@'localhost';
GRANT SELECT ON fixitnowdb.pregunta TO 'inspector'@'localhost';
GRANT SELECT,DELETE  ON fixitnowdb.respuesta TO 'inspector'@'localhost';
GRANT SELECT, DELETE  ON fixitnowdb.version_1 TO 'inspector'@'localhost';
GRANT SELECT, INSERT ON fixitnowdb.ingresos_plataforma TO 'inspector'@'localhost';
GRANT SELECT,update ON fixitnowdb.reporte_articulo TO 'inspector'@'localhost';
GRANT SELECT,UPDATE  ON fixitnowdb.reporte_respuesta TO 'inspector'@'localhost';


DELIMITER //
CREATE TRIGGER trg_respuestas_eliminadas
AFTER DELETE ON respuesta
FOR EACH ROW
BEGIN
    INSERT INTO log_respuestas_eliminadas (
        id_respuesta_original,
        id_pregunta,
        contenido,
        fecha_publicacion_original,
        inspector_id
    ) VALUES (
        OLD.ID_respuesta,
        OLD.id_pregunta,
        OLD.contenido,
        OLD.fecha_publicacion,
        @inspector_actual
    );
END //
DELIMITER ;

CREATE TABLE log_versiones_eliminadas (
    ID_log INT AUTO_INCREMENT PRIMARY KEY,
    id_version_original INT,
    editor_original INT,
    id_articulo INT,
    url_img_articulo VARCHAR(255),
    contenido VARCHAR(4000),
    fecha_creacion_original TIMESTAMP,
    fecha_eliminacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    inspector_id INT,
    FOREIGN KEY (inspector_id) REFERENCES usuario(ID_usuario)
) AUTO_INCREMENT = 26;


DELIMITER //
CREATE TRIGGER trg_versiones_eliminadas
AFTER DELETE ON version_1
FOR EACH ROW
BEGIN
    INSERT INTO log_versiones_eliminadas (
        id_version_original,
        editor_original,
        id_articulo,
        url_img_articulo,
        contenido,
        fecha_creacion_original,
        inspector_id
    ) VALUES (
        OLD.ID,
        OLD.editor,
        OLD.articulo,
        OLD.url_img_articulo,
        OLD.contenido,
        OLD.fecha_creacion,
        @inspector_actual 
    );
END //

DELIMITER ;

CREATE TABLE log_respuestas_eliminadas (
    ID_log INT AUTO_INCREMENT PRIMARY KEY,
    id_respuesta_original INT,
    id_pregunta INT,
    contenido VARCHAR(4000),
    fecha_publicacion_original TIMESTAMP,
    fecha_eliminacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    inspector_id INT,
    FOREIGN KEY (inspector_id) REFERENCES usuario(ID_usuario)
) AUTO_INCREMENT = 26;




CREATE TABLE Usuario(
	ID_usuario INT AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(100),
	apellido_paterno VARCHAR(50),
	apellido_materno VARCHAR(50),
	correo VARCHAR(100) unique,
	url_foto_perfil VARCHAR(255),
	cedula VARCHAR(12),
	contrasena VARCHAR(60),
	rol VARCHAR(30)
);

CREATE TABLE Articulo(
	ID INT AUTO_INCREMENT PRIMARY KEY,
	titulo VARCHAR(100),
	categoria VARCHAR(50),
	redactor INT,
	FOREIGN KEY (redactor) REFERENCES Usuario(ID_usuario)
	
);



CREATE TABLE Version_1(
	ID INT AUTO_INCREMENT PRIMARY KEY,
	editor INT,
	articulo INT,
	fecha_creacion TIMESTAMP DEFAULT current_timestamp,
	url_img_articulo VARCHAR(255),
	contenido VARCHAR(4000),
	FOREIGN KEY (editor) REFERENCES usuario(ID_usuario),
	FOREIGN KEY (articulo) REFERENCES articulo(ID)
);


/*
--colaborador crea e inspector recibe*/
 CREATE TABLE reporte_articulo (
 	ID INT AUTO_INCREMENT PRIMARY KEY,
 	colaborador INT,
 	inspector INT,
	version_1 INT,
	fecha_creacion TIMESTAMP DEFAULT current_timestamp,
	titulo VARCHAR(100),
	descripcion VARCHAR(1000),
	atendido BOOLEAN,
 	FOREIGN KEY (colaborador) REFERENCES usuario(ID_usuario),
 	FOREIGN KEY (version_1) REFERENCES version_1(ID)
 );

CREATE TABLE pregunta(
	ID_pregunta INT AUTO_INCREMENT PRIMARY KEY,
	pregunta VARCHAR(400),
	fecha_publicacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	cliente INT,
	FOREIGN KEY (cliente) REFERENCES usuario(ID_usuario)
);

CREATE TABLE respuesta (
	ID_respuesta INT AUTO_INCREMENT PRIMARY KEY,
	id_pregunta INT,
	colaborador INT,
	contenido VARCHAR(2000),
	fecha_publicacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (colaborador) REFERENCES usuario(ID_Usuario), 
	FOREIGN KEY (id_pregunta) REFERENCES pregunta(id_pregunta)
);

CREATE TABLE reporte_respuesta(
	ID INT AUTO_INCREMENT PRIMARY KEY,
	titulo VARCHAR(100),
	descripcion VARCHAR(1000),
	fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	respuesta INT,
	colaborador INT,
	inspector INT,
	atendido BOOLEAN,
	
	FOREIGN KEY (colaborador) REFERENCES usuario(ID_usuario),
	FOREIGN KEY (inspector) REFERENCES usuario(ID_usuario),
	FOREIGN KEY (respuesta) REFERENCES respuesta(ID_respuesta)
);


CREATE TABLE metodo_pago(
	ID INT AUTO_INCREMENT PRIMARY KEY, 
	Numero_tarjeta VARCHAR(20) NOT NULL,
	Proveedor_tarjeta VARCHAR(100),
	nombre_titular VARCHAR(200),
	Fecha_vencimiento VARCHAR(5) NOT NULL, 
	cliente INT, 
	FOREIGN KEY (cliente) REFERENCES usuario(id_usuario)
);


CREATE TABLE servicios(
	ID INT AUTO_INCREMENT PRIMARY KEY, 
	nombre_servicio VARCHAR(100),
	profesional_oferta INT,
	costo DECIMAL,
	disponible BOOLEAN DEFAULT TRUE,
	FOREIGN KEY (profesional_oferta) REFERENCES usuario(id_usuario)
);

CREATE TABLE ingresos_cliente (
	ID INT AUTO_INCREMENT PRIMARY KEY, 
	cliente INT,
	profesional INT,
	fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	servicio INT,
	FOREIGN KEY (servicio) REFERENCES servicios(ID),
	FOREIGN KEY (cliente) REFERENCES usuario(id_usuario),
	FOREIGN KEY (profesional) REFERENCES usuario(id_usuario)
);
CREATE TABLE ingresos_plataforma(
	ID_ingreso INT AUTO_INCREMENT PRIMARY KEY,
	usuario INT,
	ingreso DECIMAL,
	fecha_pago TIMESTAMP,
	FOREIGN KEY (usuario) REFERENCES usuario(ID_usuario)
	
);
SELECT * FROM usuario;
UPDATE usuario SET rol ='inspector' WHERE id_usuario=7;
/*
--
Usar PASSWORD() para hashear contraseña
--
-------------------------------------------------------------------------------------------*/
