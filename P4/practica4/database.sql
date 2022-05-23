/* Comandos para la ejecucion del fichero
 mysql -h 127.0.0.1 -P 3306 -u vestbot -p >>> sibw 
 use SIBW;
 source ruta de la base de datos */


/* Borramos las tablas en caso de estar ya creadas */
DROP TABLE IF EXISTS Imagenes;
DROP TABLE IF EXISTS Comentarios;
DROP TABLE IF EXISTS Enlaces;
DROP TABLE IF EXISTS Reparto;
DROP TABLE IF EXISTS Descripcion;
DROP TABLE IF EXISTS Productos;
DROP TABLE IF EXISTS PalabrasProhibidas;
DROP TABLE IF EXISTS Usuario;



/* Creamos las tablas */

/* Tabla de Producto */
CREATE TABLE Productos(
  id INT AUTO_INCREMENT,
  nombre VARCHAR(100) NOT NULL,
  foto_portada VARCHAR(100) NOT NULL,
  estudio VARCHAR(100),
  precio VARCHAR(50),
  descripcion TEXT,
  reparto TEXT,
  enlaces TEXT,   
  etiquetas VARCHAR(100),
  PRIMARY KEY(id)
);


/* Tabla de Imagenes */
CREATE TABLE Imagenes(
  id INT AUTO_INCREMENT,
  ruta VARCHAR(100),
  producto INT NOT NULL,
  pie VARCHAR(50),
  PRIMARY KEY(id),
  FOREIGN KEY(producto) REFERENCES Productos(id) ON DELETE CASCADE
);

/* Tabla de comentarios */
CREATE TABLE Comentarios(
  id INT AUTO_INCREMENT,
  producto INT NOT NULL,
  autor VARCHAR(100) NOT NULL,
  comentario VARCHAR(300),
  fecha DATETIME,
  editado BOOLEAN,
  PRIMARY KEY(id),
  FOREIGN KEY(producto) REFERENCES Productos(id) ON DELETE CASCADE
);



/* Tabla de palabras prohibidas */
CREATE TABLE PalabrasProhibidas(
  palabra VARCHAR(50),
  PRIMARY KEY(palabra)
);

/* Tabla de usuarios */
CREATE TABLE Usuario(
  username VARCHAR(50),
  email VARCHAR(100) UNIQUE NOT NULL,
  passw VARCHAR(100) NOT NULL,
  rol ENUM('registrado', 'moderador', 'gestor', 'superusuario') NOT NULL,
  PRIMARY KEY(username)
);

/* Añadimos algunos elementos por defecto a cada tabla */

INSERT INTO PalabrasProhibidas(palabra) VALUES('culo');
INSERT INTO PalabrasProhibidas(palabra) VALUES('horrible');
INSERT INTO PalabrasProhibidas(palabra) VALUES('odiar');
INSERT INTO PalabrasProhibidas(palabra) VALUES('eliminar');
INSERT INTO PalabrasProhibidas(palabra) VALUES('succionar');
INSERT INTO PalabrasProhibidas(palabra) VALUES('cago');
INSERT INTO PalabrasProhibidas(palabra) VALUES('marron');

INSERT INTO Productos(nombre,foto_portada,estudio,precio,descripcion,reparto,enlaces) VALUES ('Given','./imgs/Given.jpg','Lerche', '3€','<p> Given es un anime basado en el manga del mismo nombre. Trata la historia de un chico <em>Ritsuka Uenoyama</em> que en su descanso de clases
            se encuentra con <em>Mafuyu Sato</em> sujetando una guitarra con las cuerdas rotas. En el momento en que Uenoyama termina de arreglar la guitarra, Mafuyu se queda prendado completamente de él. Sin embargo, escuchar la canción de Mafuyu por casualidad deja una profunda impresión en Uenoyama.</p>
          <p> Tras esto, Uenoyama lo invita a formar parte de su banda junto a <em>Haruki Nakayama</em> y a <em> Akihiko Kaji</em>. Él acepta y a partir de aquí vemos como se va
            desarrollando las relaciones entre estos personajes principalmente. </p>','<table>
              <tr>
                <th>Personajes</th>
                <th>Seiyū</th>
              </tr>
              <tr>
                <td>Mafuyu Sato</td>
                <td>Shougo Yano</td>
              <tr>
                <td>Ritsuka Uenoyama</td>
                <td>Yūma Uchida</td>
              </tr>
              <tr>
                <td>Hiiragi Kashima</td>
                <td>Fumiya Imai</td>
              </tr>
              <tr>
                <td>Haruki Nakayama</td>
                <td>Masatomo Nakazawa</td>
              </tr>
              <tr>
                <td>Ugetsu Murata</td>
                <td>Shintarō Asanuma</td>
              </tr>
              <tr>
                <td>Akihiko Kaji</td>
                <td>Takuya Eguchi</td>
              </tr>
            </table>','<a href="https://given-anime.com/">TVアニメ『ギヴン』公式サイト </a> <span>- Sitio web oficial de Given </span>
            <br><a href="https://twitter.com/given_anime">TVアニメ ギヴン』公式サイト (@given_anime) </a> <span> - Twitter Oficial (japonés) </span>');

INSERT INTO Productos(nombre,foto_portada,estudio,precio,descripcion,reparto,enlaces) VALUES ('Pichi Pichi Pitch','./imgs/mermaidmelody.jpg','Sony Pictures Television', '3€','<p>La serie trata de las respectivas princesas sirenas de los 7 mares, contando sus aventuras por el mundo humano.

Luchia es la princesa sirena del Océano Pacífico Norte. Conocerá a Hanon, la princesa sirena del Océano Atlántico Sur, y a Rina, princesa del Océano Atlántico Norte.

Juntas se deberán enfrentar contra las diablesas acuáticas para devolver la paz al mar y a todos los que lo habitan.</p> <p> Más tarde conocerán a Karen, princesa del Océano Antártico. Las cuatro deben salvar a las tres princesas sirenas capturadas, Noel,
 hermana gemela de Karen, princesa del Océano Ártico, Coco, princesa del Océano Pacífico Sur, y Sarah, princesa del Océano Índico. </p>','<table>
              <tr>
                <th>Personajes</th>
                <th>Seiyū</th>
              </tr>
              <tr>
                <td>Luchia Nanami</td>
                <td>Sara Polo</td>
              <tr>
                <td>Hannon Hōshō</td>
                <td>Elena Palacios</td>
              </tr>
              <tr>
                <td>Rina Tōin</td>
                <td>Ana Richart</td>
              </tr>
              <tr>
                <td>Karen</td>
                <td>Belén Rodríguez</td>
              </tr>
              <tr>
                <td>Noel</td>
                <td>Ana Plaza</td>
              </tr>
              <tr>
                <td>Coco</td>
                <td>Inés Blázquez</td>
              </tr>
              <tr>
                <td>Sara</td>
                <td>Ana Isabel Hernando</td>
              </tr>
            </table>','<a href="https://es.wikipedia.org/wiki/Mermaid_Melody:_Pichi_Pichi_Pitch">Wikipedia Pichi Pichi Pitch </a>');

INSERT INTO Productos(nombre,foto_portada,descripcion) VALUES ('Zombieland Saga','./imgs/zombieland.jpg','<p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla maximus ultricies pharetra.
 Aenean velit ante, elementum nec hendrerit sit amet, lobortis auctor erat. 
 Praesent libero tortor, aliquam in mi ut, porttitor sagittis eros. In varius massa libero, vitae interdum tellus elementum id.
  Duis sagittis enim euismod, eleifend libero vitae, fermentum erat. Praesent libero nulla, mollis sit amet augue eu, sagittis eleifend felis. 
  Suspendisse viverra faucibus urna, a iaculis odio aliquam vitae. Sed tempor tincidunt nisi, in mollis dui blandit ut. Sed finibus a lorem vitae elementum. 
  Suspendisse ut leo erat. Proin eget sodales massa, a euismod mi. Vestibulum ornare lacinia sem tincidunt convallis. Nulla eget arcu ut turpis blandit semper. 
  Aliquam nec est sed est scelerisque gravida.</p> <p> Donec vel sodales justo, sodales cursus velit. Sed tristique, mi eget facilisis ultricies, elit nisi varius sem, at finibus sapien elit nec elit. 
  Ut sagittis arcu nec ligula sollicitudin, non laoreet augue fringilla.
 Vivamus quis diam iaculis, faucibus metus in, venenatis purus. In sed cursus nunc. Ut nec porta dolor. Nulla elementum fermentum nunc sit amet fringilla.</p>');

INSERT INTO Productos(nombre,foto_portada,descripcion) VALUES ('Haikyuu!!','./imgs/haikyuu.jpg','<p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla maximus ultricies pharetra.
 Aenean velit ante, elementum nec hendrerit sit amet, lobortis auctor erat. 
 Praesent libero tortor, aliquam in mi ut, porttitor sagittis eros. In varius massa libero, vitae interdum tellus elementum id.
  Duis sagittis enim euismod, eleifend libero vitae, fermentum erat. Praesent libero nulla, mollis sit amet augue eu, sagittis eleifend felis. 
  Suspendisse viverra faucibus urna, a iaculis odio aliquam vitae. Sed tempor tincidunt nisi, in mollis dui blandit ut. Sed finibus a lorem vitae elementum. 
  Suspendisse ut leo erat. Proin eget sodales massa, a euismod mi. Vestibulum ornare lacinia sem tincidunt convallis. Nulla eget arcu ut turpis blandit semper. 
  Aliquam nec est sed est scelerisque gravida.</p> <p> Donec vel sodales justo, sodales cursus velit. Sed tristique, mi eget facilisis ultricies, elit nisi varius sem, at finibus sapien elit nec elit. 
  Ut sagittis arcu nec ligula sollicitudin, non laoreet augue fringilla.
 Vivamus quis diam iaculis, faucibus metus in, venenatis purus. In sed cursus nunc. Ut nec porta dolor. Nulla elementum fermentum nunc sit amet fringilla.</p>');

INSERT INTO Productos(nombre,foto_portada,descripcion) VALUES ('Kimetsu no Yaiba','./imgs/kimetsu.jpg','<p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla maximus ultricies pharetra.
 Aenean velit ante, elementum nec hendrerit sit amet, lobortis auctor erat. 
 Praesent libero tortor, aliquam in mi ut, porttitor sagittis eros. In varius massa libero, vitae interdum tellus elementum id.
  Duis sagittis enim euismod, eleifend libero vitae, fermentum erat. Praesent libero nulla, mollis sit amet augue eu, sagittis eleifend felis. 
  Suspendisse viverra faucibus urna, a iaculis odio aliquam vitae. Sed tempor tincidunt nisi, in mollis dui blandit ut. Sed finibus a lorem vitae elementum. 
  Suspendisse ut leo erat. Proin eget sodales massa, a euismod mi. Vestibulum ornare lacinia sem tincidunt convallis. Nulla eget arcu ut turpis blandit semper. 
  Aliquam nec est sed est scelerisque gravida.</p> <p> Donec vel sodales justo, sodales cursus velit. Sed tristique, mi eget facilisis ultricies, elit nisi varius sem, at finibus sapien elit nec elit. 
  Ut sagittis arcu nec ligula sollicitudin, non laoreet augue fringilla.
 Vivamus quis diam iaculis, faucibus metus in, venenatis purus. In sed cursus nunc. Ut nec porta dolor. Nulla elementum fermentum nunc sit amet fringilla.</p>');

INSERT INTO Productos(nombre,foto_portada,descripcion) VALUES ('Pretty Cure','./imgs/prettycure.jpg','<p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla maximus ultricies pharetra.
 Aenean velit ante, elementum nec hendrerit sit amet, lobortis auctor erat. 
 Praesent libero tortor, aliquam in mi ut, porttitor sagittis eros. In varius massa libero, vitae interdum tellus elementum id.
  Duis sagittis enim euismod, eleifend libero vitae, fermentum erat. Praesent libero nulla, mollis sit amet augue eu, sagittis eleifend felis. 
  Suspendisse viverra faucibus urna, a iaculis odio aliquam vitae. Sed tempor tincidunt nisi, in mollis dui blandit ut. Sed finibus a lorem vitae elementum. 
  Suspendisse ut leo erat. Proin eget sodales massa, a euismod mi. Vestibulum ornare lacinia sem tincidunt convallis. Nulla eget arcu ut turpis blandit semper. 
  Aliquam nec est sed est scelerisque gravida.</p> <p> Donec vel sodales justo, sodales cursus velit. Sed tristique, mi eget facilisis ultricies, elit nisi varius sem, at finibus sapien elit nec elit. 
  Ut sagittis arcu nec ligula sollicitudin, non laoreet augue fringilla.
 Vivamus quis diam iaculis, faucibus metus in, venenatis purus. In sed cursus nunc. Ut nec porta dolor. Nulla elementum fermentum nunc sit amet fringilla.</p>');

INSERT INTO Productos(nombre,foto_portada,descripcion) VALUES ('Tate no Yuusha','./imgs/tatenoyuusha.png','<p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla maximus ultricies pharetra.
 Aenean velit ante, elementum nec hendrerit sit amet, lobortis auctor erat. 
 Praesent libero tortor, aliquam in mi ut, porttitor sagittis eros. In varius massa libero, vitae interdum tellus elementum id.
  Duis sagittis enim euismod, eleifend libero vitae, fermentum erat. Praesent libero nulla, mollis sit amet augue eu, sagittis eleifend felis. 
  Suspendisse viverra faucibus urna, a iaculis odio aliquam vitae. Sed tempor tincidunt nisi, in mollis dui blandit ut. Sed finibus a lorem vitae elementum. 
  Suspendisse ut leo erat. Proin eget sodales massa, a euismod mi. Vestibulum ornare lacinia sem tincidunt convallis. Nulla eget arcu ut turpis blandit semper. 
  Aliquam nec est sed est scelerisque gravida.</p> <p> Donec vel sodales justo, sodales cursus velit. Sed tristique, mi eget facilisis ultricies, elit nisi varius sem, at finibus sapien elit nec elit. 
  Ut sagittis arcu nec ligula sollicitudin, non laoreet augue fringilla.
 Vivamus quis diam iaculis, faucibus metus in, venenatis purus. In sed cursus nunc. Ut nec porta dolor. Nulla elementum fermentum nunc sit amet fringilla.</p>');

INSERT INTO Productos(nombre,foto_portada,descripcion) VALUES ('Violet Evergarden','./imgs/violet.jpg','<p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla maximus ultricies pharetra.
 Aenean velit ante, elementum nec hendrerit sit amet, lobortis auctor erat. 
 Praesent libero tortor, aliquam in mi ut, porttitor sagittis eros. In varius massa libero, vitae interdum tellus elementum id.
  Duis sagittis enim euismod, eleifend libero vitae, fermentum erat. Praesent libero nulla, mollis sit amet augue eu, sagittis eleifend felis. 
  Suspendisse viverra faucibus urna, a iaculis odio aliquam vitae. Sed tempor tincidunt nisi, in mollis dui blandit ut. Sed finibus a lorem vitae elementum. 
  Suspendisse ut leo erat. Proin eget sodales massa, a euismod mi. Vestibulum ornare lacinia sem tincidunt convallis. Nulla eget arcu ut turpis blandit semper. 
  Aliquam nec est sed est scelerisque gravida.</p> <p> Donec vel sodales justo, sodales cursus velit. Sed tristique, mi eget facilisis ultricies, elit nisi varius sem, at finibus sapien elit nec elit. 
  Ut sagittis arcu nec ligula sollicitudin, non laoreet augue fringilla.
 Vivamus quis diam iaculis, faucibus metus in, venenatis purus. In sed cursus nunc. Ut nec porta dolor. Nulla elementum fermentum nunc sit amet fringilla.</p>');

INSERT INTO Productos(nombre,foto_portada,descripcion) VALUES ('Fairy Tail','./imgs/fairytail.jpg','<p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla maximus ultricies pharetra.
 Aenean velit ante, elementum nec hendrerit sit amet, lobortis auctor erat. 
 Praesent libero tortor, aliquam in mi ut, porttitor sagittis eros. In varius massa libero, vitae interdum tellus elementum id.
  Duis sagittis enim euismod, eleifend libero vitae, fermentum erat. Praesent libero nulla, mollis sit amet augue eu, sagittis eleifend felis. 
  Suspendisse viverra faucibus urna, a iaculis odio aliquam vitae. Sed tempor tincidunt nisi, in mollis dui blandit ut. Sed finibus a lorem vitae elementum. 
  Suspendisse ut leo erat. Proin eget sodales massa, a euismod mi. Vestibulum ornare lacinia sem tincidunt convallis. Nulla eget arcu ut turpis blandit semper. 
  Aliquam nec est sed est scelerisque gravida.</p> <p> Donec vel sodales justo, sodales cursus velit. Sed tristique, mi eget facilisis ultricies, elit nisi varius sem, at finibus sapien elit nec elit. 
  Ut sagittis arcu nec ligula sollicitudin, non laoreet augue fringilla.
 Vivamus quis diam iaculis, faucibus metus in, venenatis purus. In sed cursus nunc. Ut nec porta dolor. Nulla elementum fermentum nunc sit amet fringilla.</p>');


INSERT INTO Imagenes(ruta, producto, pie) VALUES('./imgs/Given.jpg', 1, 'Anime Given');
INSERT INTO Imagenes(ruta, producto, pie) VALUES('./imgs/mermaidmelody.jpg', 2, 'Anime Pichi Pichi Pitch');
INSERT INTO Imagenes(ruta, producto, pie) VALUES('./imgs/zombieland.jpg', 3, 'Anime Zombieland Saga');
INSERT INTO Imagenes(ruta, producto, pie) VALUES('./imgs/haikyuu.jpg', 4, 'Anime Haikyuu!!');
INSERT INTO Imagenes(ruta, producto, pie) VALUES('./imgs/kimetsu.jpg', 5, 'Anime Kimetsu no Yaiba');
INSERT INTO Imagenes(ruta, producto, pie) VALUES('./imgs/prettycure.jpg', 6, 'Anime Pretty Cure');
INSERT INTO Imagenes(ruta, producto, pie) VALUES('./imgs/tatenoyuusha.png', 7, 'Anime Tate no Yuusha');
INSERT INTO Imagenes(ruta, producto, pie) VALUES('./imgs/violet.jpg', 8, 'Anime Violet Evergarden');
INSERT INTO Imagenes(ruta, producto, pie) VALUES('./imgs/fairytail.jpg', 9, 'Anime Fairy Tail');
INSERT INTO Imagenes(ruta, producto, pie) VALUES('./imgs/given_protas.jpg', 1, 'Personajes Given');
INSERT INTO Imagenes(ruta, producto, pie) VALUES('./imgs/personajes_pichi.jpg', 2, 'Personajes Pichi Pichi');




INSERT INTO Comentarios(producto, autor, comentario, fecha, editado) VALUES(1, 'Mafuyu', 'Hi everyone!', NOW(), false);
INSERT INTO Comentarios(producto, autor, comentario, fecha, editado) VALUES(1, 'Uenoyama', 'Long time no see', NOW(), false);
INSERT INTO Comentarios(producto, autor, comentario, fecha, editado) VALUES(2, 'Luchia', 'Chicas! Kaito no me hace caso :(', NOW(), false);
INSERT INTO Comentarios(producto, autor, comentario, fecha, editado) VALUES(2, 'Hanon', 'Ay que pesada, siempre con lo mismo', NOW(), false);


/*Contraseña Mayufu*/
INSERT INTO Usuario(username,email,passw,rol) VALUES ('Vic','vestbot@ugr.es','$2y$10$psLj1geqv4fFEynltZfB2eOYpdfKEjA39hcu9nDf2Xvb1em.4C.qC','superusuario');
/*Contraseña granblue*/
INSERT INTO Usuario(username,email,passw,rol) VALUES ('Sorn','sorn@ugr.es','$2y$10$TASJNptlM1IOKrQgEQCgGOTco3WQrlHB2zOuZFTVJmKfEDNYzEBEy','gestor');
/*Contraseña Heartfilia*/
INSERT INTO Usuario(username,email,passw,rol) VALUES ('Lucy','lucy@ugr.es','$2y$10$Q6SghbPzivUMswe7mIo6XOLF4Gpuxz6Adxq6nhiAiQzYSUV14wApK','moderador');
/*Contraseña ganadora*/
INSERT INTO Usuario(username,email,passw,rol) VALUES ('Chanel','chanel@ugr.es','$2y$10$qF5sA7naWrXMOdVcxu2g4es7qXCVEI8qbfz5ZQYNoxG2KHn7Vpnme','registrado');