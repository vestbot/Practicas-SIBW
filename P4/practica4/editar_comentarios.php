<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("modelo.php");

    $loader = new \Twig\Loader\FilesystemLoader('template');
    $twig = new \Twig\Environment($loader);


    $database=Database::getInstance();
  
    session_start();

    $variablesParaTwig = [];

    
    if (isset($_SESSION['nickUsuario'])) {  //necesito hacerlo para que en el menu me salgan las opciones segun el tipo de usuario
        $variablesParaTwig['user'] = $database->getUser($_SESSION['nickUsuario']);
    }

    if(isset($_GET['cm']) && is_numeric($_GET['cm'])){
        $idCm = $_GET['cm'];
        $variablesParaTwig['comentario'] = $database->getComentario($idCm);
        $producto = $variablesParaTwig['comentario']['producto']; // cogemos el producto asociado al comentario 
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $texto = $_POST['texto_comment'];

        if( $texto != ''){
            //Si el comentario a editar no es vacio, lo actualizamos
            $database->actualizarComentario($idCm,$texto);

            header("Location: producto.php?prod=$producto" );
        }
        else{
            $variablesParaTwig['resultado'] = "error";
            $variablesParaTwig['errores'] = "No se puede actualizar un comentario con texto vacío, hay que escribir al menos un caracter";
        }
    }


      echo $twig->render('editar_comentarios.html', $variablesParaTwig);
    ?>