<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("modelo.php");

    $loader = new \Twig\Loader\FilesystemLoader('template');
    $twig = new \Twig\Environment($loader);


    $database=Database::getInstance();
  
    session_start();

    $variablesParaTwig = [];

    $variablesParaTwig['lista_comentarios'] = $database->getListaComentarios();
    
    if (isset($_SESSION['nickUsuario'])) {  //necesito hacerlo para que en el menu me salgan las opciones segun el tipo de usuario
        $variablesParaTwig['user'] = $database->getUser($_SESSION['nickUsuario']);
    }

      echo $twig->render('lista_comentarios.html', $variablesParaTwig);
    ?>