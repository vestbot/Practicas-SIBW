<?php

    //En este fichero incluyo todas las operaciones relacionadas con la base de datos
    class Database{
        private static $instance;
        private $mysqli;
    

        /* Constructor de la clase para crear el objeto mysqli */
        private function __construct(){
            $this->$mysqli = new mysqli("mysql", "vestbot", "sibw", "SIBW"); // creamos el objeto con el usuario que nos conectaremos
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
        
            $producto = array('id' => '-1', 'nombre' => 'No tenemos un anime llamado asi :(', 'estudio' => 'XXX', 'precio' => 'YYY', 'descripcion' => 'ZZZ', 'reparto' => 'VVV', 'enlaces' => 'ggggggggggg', 'etiquetas' => 'wwwwww');
            
            if ($res->num_rows > 0) {
                $row = $res->fetch_assoc();
                
                $producto = array('id' => $row['id'], 'nombre' => $row['nombre'], 'estudio' => $row['estudio'], 'precio' => $row['precio'], 'descripcion' => $row['descripcion'], 'reparto' => $row['reparto'],'enlaces' => $row['enlaces'], 'etiquetas' => $row['etiquetas']);
            }
            
            return $producto;
        }

        /* Funcion para obtener las fotos de un producto
           Devuelve un array con imagenes cada una con: ruta donde se encuentra la imagen y pie */
        public function getFotosProducto($idProd){
            $consulta = "SELECT * FROM Imagenes WHERE producto=?";
            /* cl representa una consulta lista */
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

        

        /* Funcion para obtener los comentarios de un producto 
           Devuelve un array con comentarios cada uno con: autor, comentario, fecha */
        public function getComentariosProducto($idProd){
            $consulta = "SELECT * FROM Comentarios WHERE producto=?";
            /* cl representa una consulta lista */
            $cl = $this->$mysqli->prepare($consulta);
            $cl->bind_param("i",$idProd);
            $cl->execute();
            $res=$cl->get_result();
            $cl->close();
        
            $comentario = array('id' => '-1', 'autor' => 'Anonimo', 'comentario' => 'me encanta este anime', 'fecha' => 'nunca',);

            $lista_comentarios = array();
            
            while($row=$res->fetch_assoc()){
                $comentario = array('id' => $row['id'], 'autor' => $row['autor'], 'comentario' => $row['comentario'], 'fecha' => $row['fecha'], 'editado' =>$row['editado']);
                $lista_comentarios[] = $comentario;
            }
            
            return $lista_comentarios;
        }

        // NUEVAS FUNCIONES PARA LA PRÁCTICA 4

        /* Funcion para obtener la lista de productos 
           Devuelve un array con productos cada uno con: id, nombre, foto_portada */
        public function getListaProductos(){
            $consulta = "SELECT id, nombre, foto_portada FROM Productos";
            /* cl representa una consulta lista */
            $cl = $this->$mysqli->prepare($consulta);
            $cl->execute();
            $res=$cl->get_result();
            $cl->close();
        
            $producto = array('id' => '-1', 'nombre' => 'Producto', 'foto_portada' => '');

            $lista_productos = array();
            
            /* Para cada producto obtenido obtengo sus fotos y pongo la primera en la portada */
            while($row=$res->fetch_assoc()){
                $producto = array('id' => $row['id'], 'nombre' => $row['nombre'], 'foto_portada' => $row['foto_portada']);  
                $lista_productos[] = $producto;
            }
            
            return $lista_productos;
        }

        /* Funcion para obtener la lista de los comentarios del sistema 
           Devuelve un array con los comentarios, cada uno con: id,producto,autor,comentario,fecha  */
        public function getListaComentarios(){  //esencialmente hace lo mismo que getComentariosProducto pero esta vez obtenemos TODOS los comentarios existentes
            $consulta = "SELECT * FROM Comentarios";
            /* cl representa una consulta lista */
            $cl = $this->$mysqli->prepare($consulta);
            $cl->execute();
            $res=$cl->get_result();
            $cl->close();


            $lista_comentarios = array();
            
            while($row=$res->fetch_assoc()){
                $comentario = array('id' => $row['id'], 'producto' => $row['producto'], 'autor' => $row['autor'], 'comentario' => $row['comentario'], 'fecha' => $row['fecha'],'editado' => $row['editado']);
                $lista_comentarios[] = $comentario;
            }
            
            return $lista_comentarios;

        }

        /* Funcion para obtener un comentario por su id*/
        public function getComentario($idCm){
            $consulta = "SELECT * FROM Comentarios WHERE id=?";
            /* cl representa una consulta lista */
            $cl = $this->$mysqli->prepare($consulta);
            $cl->bind_param("i",$idCm);
            $cl->execute();
            $res=$cl->get_result();
            $cl->close();

            $comentario = array('id' => 'xx', 'producto' => '-1', 'autor' => 'Anonimo', 'comentario' => 'me encanta este anime', 'fecha' => 'nunca');

             if ($res->num_rows > 0) {
                $row = $res->fetch_assoc();
                $comentario = array('id' => $row['id'], 'producto' => $row['producto'], 'autor' => $row['autor'], 'comentario' => $row['comentario'], 'fecha' => $row['fecha'], 'editado' => $row['editado']);
            }
            
            return $comentario;


        }

        /* Funcion para actualizar un comentario por su identificador
           Devuelve el comentario actualizado */
        public function actualizarComentario($idCm, $texto){
            $consulta = "UPDATE Comentarios SET comentario=?, editado=true WHERE id=?";
            /* cl representa una consulta lista */
            $cl = $this->$mysqli->prepare($consulta);
            $cl->bind_param("si", $texto, $idCm);
            $cl->execute();
            $res=$cl->get_result();
            $cl->close();

            if ($res->num_rows > 0){
                $row = $res->fetch_assoc();
            }else{
                $row = 0;
            }

            return $row;
        }

        /* Funcion para borrar un comentario por su identificador
           */
        public function borrarComentario($idCm){
            $consulta = "DELETE FROM Comentarios WHERE id=?";
            /* cl representa una consulta lista */
            $cl = $this->$mysqli->prepare($consulta);
            $cl->bind_param("i", $idCm);
            $cl->execute();
            $res=$cl->get_result();
            $cl->close();
        }

         /* Funcion para buscar un comentario */
        public function buscarComentario($texto){
            $consulta = "SELECT * FROM Comentarios WHERE comentario LIKE ?";
            /* cl representa una consulta lista */
            $cl = $this->$mysqli->prepare($consulta);
            $busqueda = "%" . $texto . "%"; // buscamos comentarios que contengan lo que queremos buscar
            $cl->bind_param("s", $busqueda);
            $cl->execute();
            $res=$cl->get_result();
            $cl->close();

            $lista_comentarios = array();
            
            while($row=$res->fetch_assoc()){
                $comentario = array('id' => $row['id'], 'producto' => $row['producto'], 'autor' => $row['autor'], 'comentario' => $row['comentario'], 'fecha' => $row['fecha']);
                $lista_comentarios[] = $comentario;
            }
            
            return $lista_comentarios;
        }

         /* Funcion para buscar un producto */
        public function buscarProducto($texto){
            $consulta = "SELECT id, nombre, foto_portada FROM Productos WHERE descripcion LIKE ? OR etiquetas LIKE ?";
            /* cl representa una consulta lista */
            $cl = $this->$mysqli->prepare($consulta);
            $busqueda = "%" . $texto . "%";
            $cl->bind_param("ss", $busqueda,$busqueda);
            $cl->execute();
            $res=$cl->get_result();
            $cl->close();
        
            $producto = array('id' => '-1', 'nombre' => 'Anime', 'foto_portada' => '');

            $lista_productos = array();
            
            
            while($row=$res->fetch_assoc()){
                $producto = array('id' => $row['id'], 'nombre' => $row['nombre'], 'foto_portada' => $row['foto_portada']);  
                $lista_productos[] = $producto;
            }
            
            return $lista_productos;
        }

        public function borrarProducto($idProd){
            $consulta = "DELETE FROM Productos WHERE id=?";
            /* cl representa una consulta lista */
            $cl = $this->$mysqli->prepare($consulta);
            $cl->bind_param("i", $idProd);
            $cl->execute();
            $res=$cl->get_result();
            $cl->close();
        }


         /* Funcion para añadir un producto nuevo
            Devuelve el resultado del producto*/
        public function addProducto($nombre, $estudio, $precio, $descripcion, $reparto, $enlace, $etiquetas, $file_name){
            $consulta = "INSERT INTO Productos (nombre, estudio, precio, descripcion, reparto, enlaces, etiquetas, foto_portada) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            /* cl representa una consulta lista */
            $ruta_imagen = "./imgs/".$file_name;
            $cl = $this->$mysqli->prepare($consulta);
            $cl->bind_param("ssssssss", $nombre, $estudio, $precio, $descripcion, $reparto, $enlace, $etiquetas, $ruta_imagen);
            $cl->execute();
            $res=$cl->get_result();

            if($cl->affected_rows != -1){
                $res = array('resultado' => TRUE, 'id' => $this->$mysqli->insert_id);
            }
            else{
                $res = array('resultado' => FALSE, 'id' => -1);
            }

            $cl->close();
    
            return $res;
        }

        /* Funcion para añadir un producto nuevo
            Devuelve el resultado del producto*/
        public function updateProducto($id, $nombre, $estudio, $precio, $descripcion, $reparto, $enlace, $etiquetas, $file_name){
            $consulta = "UPDATE Productos SET nombre=?, estudio=?, precio=?, descripcion=?, reparto=?, enlaces=?, etiquetas=?, foto_portada=? WHERE id=?";
            /* cl representa una consulta lista */
            $ruta_imagen = $file_name;
            $cl = $this->$mysqli->prepare($consulta);
            $cl->bind_param("sssssssss", $nombre, $estudio, $precio, $descripcion, $reparto, $enlace, $etiquetas, $ruta_imagen, $id);
            $cl->execute();
            $res=$cl->get_result();

            if($cl->affected_rows != -1){
                $res = TRUE;
            }
            else{
                $res = FALSE;
            }

            $cl->close();
    
            return $res;
        }

        /* Funcion para añadir fotos a un producto */
        public function addImagenProducto($id, $foto){
            $consulta = "INSERT INTO Imagenes (ruta, producto) VALUES (?, ?)";
            /* cl representa una consulta lista */
            $ruta_imagen = $foto;
            $cl = $this->$mysqli->prepare($consulta);
            $cl->bind_param("si", $ruta_imagen, $id);
            $cl->execute();
            $res=$cl->get_result();

            if($cl->affected_rows != -1){
                $res = true;
            }
            else{
                $res = false;
            }

            $cl->close();
    
            return $res;
        }

         /* Funcion para borrar todas las fotos asociadas a un producto */
        public function borrarImagenesProducto($id){
            $consulta = "DELETE FROM Imagenes WHERE producto=?";
            /* cl representa una consulta lista */
            $cl = $this->$mysqli->prepare($consulta);
            $cl->bind_param("i",$id);
            $cl->execute();
            $res=$cl->get_result();
            $cl->close();
        }

        /* Funcion para añadir un comentario
           */
          public function addComentario($id, $nick, $email, $texto){
            $consulta = "INSERT INTO Comentarios (producto, autor, comentario, fecha, editado) VALUES (?, ?, ?, NOW(), false)";
            /* cl representa una consulta lista */
            $cl = $this->$mysqli->prepare($consulta);
            $cl->bind_param("iss", $id, $nick, $texto);
            $cl->execute();
            $res=$cl->get_result();
            $cl->close();
        }


        // HASTA AQUI


        /* Funcion para obtener las palabras prohibidas
           Devuelve un array con de palabras */
        public function getPalabrasProhibidas(){
            $consulta = "SELECT * FROM PalabrasProhibidas";
            /* cl representa una consulta lista */
            $cl = $this->$mysqli->prepare($consulta);
            $cl->execute();
            $res=$cl->get_result();
            $cl->close();
        
            $palabra = array('palabra' => 'xxx');

            $lista_palabras = array();
            
            while($row=$res->fetch_assoc()){
                $palabra = array('palabra' => $row['palabra']);
                $lista_palabras[] = $palabra;
            }
            
            return $lista_palabras;
        }



        /* Funcion para comprobar si existe un usuario con el nombre de usuario y contraseña dada
           Devuelve true o false */
        public function checkLogin($nick, $pass) {
            $consulta = "SELECT * FROM Usuario WHERE username=?";
            /* cl representa una consulta lista */
            $cl = $this->$mysqli->prepare($consulta);
            $cl->bind_param("s",$nick);
            $cl->execute();
            $res=$cl->get_result();
            $cl->close();
            
            while($row=$res->fetch_assoc()){
                if (password_verify($pass, $row['passw'] )) {
                    return true;
                }
            }
            
            return false;
          }

    /* Funcion para obtener un usuario por su username */
          function getUser($nick) {
            $consulta = "SELECT * FROM Usuario WHERE username=?";
            /* cl representa una consulta lista */
            $cl = $this->$mysqli->prepare($consulta);
            $cl->bind_param("s",$nick);
            $cl->execute();
            $res=$cl->get_result();
            $cl->close();

            if ($res->num_rows > 0){
                $row = $res->fetch_assoc();
            }else{
                $row = 0;
            }

            return $row;
          }

          /* Funcion para añadir un nuevo usuario */
          function addUser($nick, $email, $pass){
            $consulta = "INSERT INTO Usuario (username, email, passw, rol) VALUES (?, ?, ?, 'registrado')";
            /* cl representa una consulta lista */
            $cl = $this->$mysqli->prepare($consulta);
            $cifrada = password_hash($pass, PASSWORD_DEFAULT);
            $cl->bind_param("sss", $nick, $email, $cifrada);
            $cl->execute();
            $res=$cl->get_result();

            if($cl->affected_rows != -1){
                $res = true;
            }
            else{
                $res = false;
            }

            $cl->close();
    
            return $res;
          }

          /* Funcion para actualizar un usuario por su username */
          function actualizarUser($actuser, $nick, $email, $pass) {
            $consulta = "UPDATE Usuario SET username=?, email=?, passw=? WHERE username=?";
            /* cl representa una consulta lista */
            $cl = $this->$mysqli->prepare($consulta);
            $cl->bind_param("ssss", $nick, $email, $pass, $actuser);
            $cl->execute();
            $res=$cl->get_result();
            

            if ($cl->affected_rows != -1){
                $res = true;
            }
            else{
                $res = false;
            }

            $cl->close();
            return $res;
          }

   
    /* Funcion para comprobar si se puede modificar un rol de usuario verificando que siempre hay un superusuario
             Devuelve true si se puede y false si no */
        function quitarSuperusuario($username) {
            $consulta = "SELECT rol FROM Usuario WHERE username=?";
            /* cl representa una consulta lista */
            $cl = $this->$mysqli->prepare($consulta);
            $cl->bind_param("s", $username);
            $cl->execute();
            $res=$cl->get_result();
            $cl->close();

            $sepuede = true;

            if ($res->num_rows > 0){
                $row = $res->fetch_assoc();
                if($row['rol'] == 'superusuario'){ // Comprobamos si el rol del usuario es un superusuario
                    $consulta2 = "SELECT * FROM Usuario WHERE rol='superusuario'"; // obtenemos el numero de superusuarios que hay en el sistema
                    /* cl representa una consulta lista */
                    $cl2 = $this->$mysqli->prepare($consulta2);
                    $cl2->execute();
                    $res2=$cl2->get_result();
                    $cl2->close();

                    if ($res2->num_rows < 2){ // si hay menos de dos (es decir hay uno solo) no podemos cambiar el rol de superusuario porque entonces no habría
                        $sepuede = false;
                    }
                }
            }
            else{
                $sepuede = false;
            }

            return $sepuede;
        }

        /* Funcion para actualizar el rol de un usuario por su username */
        function actualizarRol($username, $rol) {
            $consulta = "UPDATE Usuario SET rol=? WHERE username=?";
            /* cl representa una consulta lista */
            $cl = $this->$mysqli->prepare($consulta);
            $cl->bind_param("ss", $rol, $username);
            $cl->execute();
            $res=$cl->get_result();
            

            if ($cl->affected_rows != -1){
                $res = true;
            }else{
                $res = false;
            }
            $cl->close();

            return $res;
          }
    }
    


?>