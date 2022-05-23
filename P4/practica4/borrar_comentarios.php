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

       
            
            $database->borrarComentario($idCm,$texto);

           
            header("Location: producto.php?prod=$producto" );
       
    }


      echo $twig->render('borrar_comentarios.html', $variablesParaTwig);
    ?>