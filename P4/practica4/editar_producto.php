<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("modelo.php");

    $loader = new \Twig\Loader\FilesystemLoader('template');
    $twig = new \Twig\Environment($loader);


    $database=Database::getInstance();
  
    session_start();

    if(isset($_GET['prod']) && is_numeric($_GET['prod']) ){
      $idProd = $_GET['prod'];
    }
    else{
      $idProd = -1;
    }

    $variablesParaTwig = [];

    $variablesParaTwig['producto'] = $database->getProducto($idProd);
    $variablesParaTwig['lista_imagenes'] = $database->getFotosProducto($idProd);

    function console_log( $data ){
      echo '<script>';
      echo 'console.log('. json_encode( $data ) .')';
      echo '</script>';
    }
    
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
      
      // Cargo la portada
      if(isset($_FILES['portada'])){
          $errors= array();
          $file_name = $_FILES['portada']['name'];
          $file_size = $_FILES['portada']['size'];
          $file_tmp = $_FILES['portada']['tmp_name'];
          $file_type = $_FILES['portada']['type'];
          $file_ext = strtolower(end(explode('.',$_FILES['portada']['name'])));
          $file_without_ext1 = pathinfo($file_name);
          $extensions= array("jpeg","jpg","png");

          
          if (in_array($file_ext,$extensions) === false){
            $errors[] = "Extensión no permitida, elige una imagen JPEG, PNG o JPG.";
          }
          
          if ($file_size > 2097152){
            $errors[] = 'Tamaño del fichero demasiado grande';
          }
          
          if (empty($errors)==true) {
              $file_name3 =  $file_without_ext1['filename'];
              $file_name4 = "./imgs/" . $file_name3 . "." . $file_ext;
              $contador = 0;
              
              while(file_exists($file_name4)){
                  $file_name4 = "./imgs/" . $file_name3 . $contador . "." . $file_ext;
                  $contador= $contador+1;

                  console_log($file_name4);
              }
            move_uploaded_file($file_tmp, $file_name4);
            
            $variablesParaTwig['imagen'] = $file_name4;

            $res = $database->updateProducto($idProd, $nombre, $estudio, $precio, $descripcion, $reparto, $enlace, $etiquetas, $file_name4);
            if($res){
                $variablesParaTwig['resultado'] = "insertado";
            }
            else{
                $variablesParaTwig['resultado'] = "error";
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
          //$database->borrarImagenesProducto($idProd);

          for($i = 0; $i < $total_ficheros; $i++){
            $file_name2 = $_FILES['imagenes']['name'][$i];
            $file_size2 = $_FILES['imagenes']['size'][$i];
            $file_tmp2 = $_FILES['imagenes']['tmp_name'][$i];
            $file_type2 = $_FILES['imagenes']['type'][$i];
            $file_ext2 = strtolower(end(explode('.',$_FILES['imagenes']['name'][$i])));
            $file_without_ext = pathinfo($file_name2);
            
            $extensions= array("jpeg","jpg","png");
            
            if (in_array($file_ext2,$extensions) === false){
              $errors2[] = "Extensión no permitida, elige una imagen JPEG, PNG o JPG";
            }
            
            if ($file_size2 > 2097152){
              $errors2[] = 'Tamaño del fichero demasiado grande';
            }
            
            if (empty($errors2)==true) {
              $file_name5 =  $file_without_ext['filename'];
              $file_name6 = "./imgs/" . $file_name5 . "." . $file_ext2;
              $contador2 = 0;
              
              while(file_exists($file_name6)){
                  $file_name6 = "./imgs/" . $file_name5 . $contador2 . "." . $file_ext2;
                  $contador2= $contador2+1;

                  console_log($file_name4);
              }

                move_uploaded_file($file_tmp2,$file_name6);

                $database->addImagenProducto($idProd, $file_name6);
              
            }
            
            if (sizeof($errors2) > 0) {
              $variablesParaTwig['errores'] = $errors2;
            }
          }
          
      }
    }


      echo $twig->render('editar_producto.html', $variablesParaTwig);
    ?>