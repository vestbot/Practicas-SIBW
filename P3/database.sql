/* Comandos para la ejecucion del fichero
 mysql -h 127.0.0.1 -P 3306 -u vestbot -p >>> sibw22 
 use SIBW;
 source /home/victor/Escritorio/DGIIM/Sibw/P3/database.sql */


/* Borramos las tablas en caso de estar ya creadas */
DROP TABLE IF EXISTS Imagenes;
DROP TABLE IF EXISTS Comentarios;
DROP TABLE IF EXISTS Productos;
DROP TABLE IF EXISTS PalabrasProhibidas;


/* Creamos las tablas */

/* Tabla de Evento */
CREATE TABLE Productos(
  id INT AUTO_INCREMENT,
  nombre VARCHAR(100) NOT NULL,
  foto_portada VARCHAR(100) NOT NULL,
  /*estudio VARCHAR(100) NOT NULL,
  precio VARCHAR(50) NOT NULL,
  descripcion TEXT NOT NULL,    
  enlace VARCHAR(100),
  fecha DATETIME,*/
  PRIMARY KEY(id)
);

/* Tabla de Imagenes */
CREATE TABLE Imagenes(
  id INT AUTO_INCREMENT,
  ruta VARCHAR(100),
  producto INT NOT NULL,
  pie VARCHAR(50),
  PRIMARY KEY(id),
  FOREIGN KEY(producto) REFERENCES Productos(id)
);

/* Tabla de comentarios */
CREATE TABLE Comentarios(
  id INT AUTO_INCREMENT,
  producto INT NOT NULL,
  autor VARCHAR(100) NOT NULL,
  comentario VARCHAR(300),
  fecha DATETIME,
  PRIMARY KEY(id),
  FOREIGN KEY(producto) REFERENCES Productos(id)
);

/* Tabla de palabras prohibidas */
CREATE TABLE PalabrasProhibidas(
  palabra VARCHAR(50),
  PRIMARY KEY(palabra)
);

/* Añadimos algunos elementos por defecto a cada tabla */

INSERT INTO PalabrasProhibidas(palabra) VALUES('culo');
INSERT INTO PalabrasProhibidas(palabra) VALUES('horrible');
INSERT INTO PalabrasProhibidas(palabra) VALUES('odiar');
INSERT INTO PalabrasProhibidas(palabra) VALUES('eliminar');
INSERT INTO PalabrasProhibidas(palabra) VALUES('succionar');
INSERT INTO PalabrasProhibidas(palabra) VALUES('cago');
INSERT INTO PalabrasProhibidas(palabra) VALUES('marron');

INSERT INTO Productos(nombre,foto_portada) VALUES ('Given','./imgs/Given.jpg');
INSERT INTO Productos(nombre,foto_portada) VALUES ('Pichi Pichi Pitch','./imgs/mermaidmelody.jpg');
INSERT INTO Productos(nombre,foto_portada) VALUES ('Zombieland Saga','./imgs/zombieland.jpg');

INSERT INTO Imagenes(ruta, evento, pie) VALUES('./imgs/Given.jpg', 1, 'Anime Given');
INSERT INTO Imagenes(ruta, evento, pie) VALUES('./imgs/mermaidmelody.jpg', 2, 'Anime Pichi Pichi Pitch');
INSERT INTO Imagenes(ruta, evento, pie) VALUES('./img/imgs/zombieland.jpg', 3, 'Anime Zombieland Saga');


INSERT INTO Comentario(evento, autor, comentario, fecha) VALUES(1, 'Mafuyu', 'Hi everyone!', NOW());
INSERT INTO Comentario(evento, autor, comentario, fecha) VALUES(1, 'Uenoyama', 'Long time no see', NOW());
