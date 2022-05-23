<?php

    //En este fichero incluyo todas las operaciones relacionadas con la base de datos
    class Database{
        private static $instance;
        private $mysqli;
    

        /* Constructor de la clase para crear el objeto mysqli */
        private function __construct(){
            $this->$mysqli = new mysqli("mysql", "vestbot", "sibw22", "SIBW"); // creamos el objeto con el usuario que nos conectaremos
            if ($mysqli->connect_errno) { 
            echo ("Fallo al conectar: " . $mysqli->connect_error); //mensaje de error
            }

            $this->$mysqli->set_charset("utf8"); //Establece el conjunto de caracteres al que estamos usando
        }

        /* Obtener instancia de la base de datos para no hacer 50 conexiones */
        public static function getInstance(){
            if(!self::$instance instanceof self){ // si no tenemos creada una instancia, la creamos
                self::$instance = new self();
            }
        
            return self::$instance;
        }

        /* Funcion para obtener un producto por su identificador 
           Devuelve un array con: id, nombre, estudio, precio, descripcion, cast, enlaces */
        public function getProducto($idProd){
            $consulta = "SELECT * FROM Productos WHERE id=?"; // cogemos el producto con el id correspondiente
            /* cl representa una consulta lista */
            $cl = $this->$mysqli->prepare($consulta);
            $cl->bind_param("i",$idProd);
            $cl->execute();
            $res=$cl->get_result();
            $cl->close();
        
            $producto = array('id' => '-1', 'nombre' => 'No tenemos un anime llamado asi :(', 'estudio' => 'XXX', 'precio' => 'YYY', 'descripcion' => 'ZZZ', 'cast' => 'VVV', 'enlaces' => '');
            
            if ($res->num_rows > 0) {
                $row = $res->fetch_assoc();
                
                $producto = array('id' => $row['id'], 'nombre' => $row['nombre'], 'estudio' => $row['estudio'], 'precio' => $row['precio'], 'descripcion' => $row['descripcion'], 'cast' => $row['cast'], 'enlaces' => $row['enlaces']);
            }
            
            return $producto;
        }

        /* Funcion para obtener las fotos de un producto
           Devuelve un array con imagenes cada una con: ruta donde se encuentra la imagen y pie */
        public function getFotosProducto($idProd){
            $consulta = "SELECT * FROM Imagenes WHERE evento=?";
            /* stmt representa una consulta lista */
            $cl = $this->$mysqli->prepare($consulta);
            $cl->bind_param("i",$idProd);
            $cl->execute();
            $res=$cl->get_result();
            $cl->close();
        
            $imagen = array('ruta' => '../imgs/Given.jpg', 'pie' => 'Pie de foto');

            $lista_imagenes = array();
            
            while($row=$res->fetch_assoc()){  // añadimos en un array todas las imagenes que hay por cada producto
                $imagen = array('ruta' => $row['ruta'], 'pie' => $row['pie']);
                $lista_imagenes[] = $imagen;
            }
            
            return $lista_imagenes;
        }

        /* Funcion para obtener los comentarios de un evento 
           Devuelve un array con comentarios cada uno con: autor, comentario, fecha */
        public function getComentariosEvento($idEv){
            $consulta = "SELECT * FROM Comentario WHERE evento=?";
            /* stmt representa una consulta lista */
            $stmt = $this->$mysqli->prepare($consulta);
            $stmt->bind_param("i",$idEv);
            $stmt->execute();
            $res=$stmt->get_result();
            $stmt->close();
        
            $comentario = array('autor' => 'Anonimo', 'comentario' => 'viva el rol', 'fecha' => 'nunca');

            $lista_comentarios = array();
            
            while($row=$res->fetch_assoc()){
                $comentario = array('autor' => $row['autor'], 'comentario' => $row['comentario'], 'fecha' => $row['fecha']);
                $lista_comentarios[] = $comentario;
            }
            
            return $lista_comentarios;
        }

        /* Funcion para obtener la lista de eventos 
           Devuelve un array con eventos cada uno con: id, titulo, foto_portada */
        public function getListaEventos(){
            $consulta = "SELECT id, titulo, foto_portada FROM Evento";
            /* stmt representa una consulta lista */
            $stmt = $this->$mysqli->prepare($consulta);
            $stmt->execute();
            $res=$stmt->get_result();
            $stmt->close();
        
            $evento = array('id' => '-1', 'titulo' => 'Evento', 'foto_portada' => './img/dice.png');

            $lista_eventos = array();
            
            /* Para cada evento obtenido obtengo sus fotos y pongo la primera en la portada */
            while($row=$res->fetch_assoc()){
                $evento = array('id' => $row['id'], 'titulo' => $row['titulo'], 'foto_portada' => $row['foto_portada']);  
                $lista_eventos[] = $evento;
            }
            
            return $lista_eventos;
        }

        /* Funcion para obtener las palabras prohibidas
           Devuelve un array con de palabras */
        public function getPalabrasProhibidas(){
            $consulta = "SELECT * FROM PalabrasProhibidas";
            /* stmt representa una consulta lista */
            $stmt = $this->$mysqli->prepare($consulta);
            $stmt->execute();
            $res=$stmt->get_result();
            $stmt->close();
        
            $palabra = array('palabra' => 'xxx');

            $lista_palabras = array();
            
            while($row=$res->fetch_assoc()){
                $palabra = array('palabra' => $row['palabra']);
                $lista_palabras[] = $palabra;
            }
            
            return $lista_palabras;
        }
    }

   



?>