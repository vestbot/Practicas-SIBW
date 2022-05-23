<?php
	// Inicializamos el motor de plantillas
	require_once "/usr/local/lib/php/vendor/autoload.php";
	    include("modelo.php");
	$loader = new \Twig\Loader\Filesystem('templates');
	$twig = new \Twig\Environment($loader);


	$database=Database::getInstance(); // obtenemos la base de datos para trabajar con ella

    $lista_productos = $database->getListaProductos(); // array con los ids de todos los productos

    echo $twig->render('index.html', ['lista_productos' => $lista_productos]);
?>