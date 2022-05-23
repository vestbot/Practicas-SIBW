<?php
	// Inicializamos el motor de plantillas
	require_once "/usr/local/lib/php/vendor/autoload.php";
    include("modelo.php");
	$loader = new \Twig\Loader\FilesystemLoader('template');
	$twig = new \Twig\Environment($loader);

	$database= database::getInstance();  //obtenemos una instancia de la base de datos para trabajar con ella.
	$variablesParaTwig = [];

    
  
    session_start();
    
    if (isset($_SESSION['nickUsuario'])) {  // comprobamos si se ha iniciado sesion con un usuario o no
        $variablesParaTwig['user'] = $database->getUser($_SESSION['nickUsuario']);
    }


    echo $twig->render('buscadores.html', $variablesParaTwig);
?>