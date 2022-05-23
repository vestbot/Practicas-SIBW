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


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $texto = $_POST['busq_com'];

        
        if( $texto != ''){
            //Si el comentario a buscar no es vacio, lo buscamos
            $variablesParaTwig['lista_comentarios'] = $database->buscarComentario($texto);
        }
        else{
            $variablesParaTwig['resultado'] = "error";
            
        } 
        
        if(empty($variablesParaTwig['lista_comentarios'])){

            $variablesParaTwig['resultado'] = "error";
         
        }
        
    }


      echo $twig->render('lista_comentarios.html', $variablesParaTwig);
    ?>