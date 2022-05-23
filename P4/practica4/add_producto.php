<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("modelo.php");

    $loader = new \Twig\Loader\FilesystemLoader('template');
    $twig = new \Twig\Environment($loader);


    $database=Database::getInstance();
  
    session_start();

    $variablesParaTwig = [];
    
    if (isset($_SESSION['nickUsuario'])) {
        $variablesParaTwig['user'] = $database->getUser($_SESSION['nickUsuario']);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'];
        $estudio = $_POST['estudio'];
        $precio = $_POST['precio'];
        $descripcion = $_POST['descripcion'];
        $enlace = $_POST['enlace'];
        $reparto = $_POST['reparto'];
        $etiquetas = $_POST['etiquetas'];

        $idNuevoProducto;
        

        
        // Cargo la portada
        if(isset($_FILES['portada'])){
            $errors= array();
            $file_name = $_FILES['portada']['name'];
            $file_size = $_FILES['portada']['size'];
            $file_tmp = $_FILES['portada']['tmp_name'];
            $file_type = $_FILES['portada']['type'];
            $file_ext = strtolower(end(explode('.',$_FILES['portada']['name'])));
            
            $extensions= array("jpeg","jpg","png");
            
            if (in_array($file_ext,$extensions) === false){
              $errors[] = "Extensión no permitida, elige una imagen JPEG, PNG O JPG.";
            }
            
            if ($file_size > 2097152){
              $errors[] = 'Tamaño del fichero demasiado grande';
            }
            
            if (empty($errors)==true) {
              move_uploaded_file($file_tmp, "imgs/" . $file_name);
              
              $variablesParaTwig['portada'] = "imgs/" . $file_name;

              $res = $database->addProducto($nombre, $estudio, $precio, $descripcion, $reparto, $enlace, $etiquetas, $file_name);
              if($res['resultado']){
                  $variablesParaTwig['resultado'] = "insertado";
                  $idNuevoProducto = $res['id'];
              }
              else{
                  $variablesParaTwig['resultado'] = "error";
                  $idNuevoProducto = $res['id'];
              }
            }
            
            if (sizeof($errors) > 0) {
              $variablesParaTwig['errores'] = $errors;
            }
        }
        
        // Cargo imagenes del producto
        if(isset($_FILES['imagenes'])){
            $errors2= array();
            $total_ficheros = count($_FILES['imagenes']['name']);
            
            for($i = 0; $i < $total_ficheros; $i++){
              $file_name2 = $_FILES['imagenes']['name'][$i];
              $file_size2 = $_FILES['imagenes']['size'][$i];
              $file_tmp2 = $_FILES['imagenes']['tmp_name'][$i];
              $file_type2 = $_FILES['imagenes']['type'][$i];
              $file_ext2 = strtolower(end(explode('.',$_FILES['imagenes']['name'][$i])));
              
              $extensions= array("jpeg","jpg","png");
              
              if (in_array($file_ext2,$extensions) === false){
                $errors2[] = "Extensión no permitida, elige una imagen JPEG, PNG o JPG.";
              }
              
              if ($file_size2 > 2097152){
                $errors2[] = 'Tamaño del fichero demasiado grande';
              }
              
              if (empty($errors2)==true) {
                move_uploaded_file($file_tmp2, "imgs/" . $file_name2);

                $database->addImagenProducto($idNuevoProducto, $file_name2);       
              }
              
              if (sizeof($errors2) > 0) {
                $variablesParaTwig['errores'] = $errors2;
              }
            }
            
        }
      }

      echo $twig->render('add_producto.html', $variablesParaTwig);
    ?>