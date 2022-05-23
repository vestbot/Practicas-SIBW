<?php
	// Inicializamos el motor de plantillas
	require_once "/usr/local/lib/php/vendor/autoload.php";
	include("modelo.php");
	$loader = new \Twig\Loader\FilesystemLoader('template');
	$twig = new \Twig\Environment($loader);

	if(isset($_GET['prod']) && is_numeric($_GET['prod']) ){  //esto de aquí es para coger el id de cada producto
        $idProd = $_GET['prod'];
    }
    else{
        $idProd = -1;
    }

	 $database=Database::getInstance();

    $producto = $database->getProducto($idProd);
    $lista_imagenes = $database->getFotosProducto($idProd);
    $lista_comentarios = $database->getComentariosProducto($idProd);
    $lista_enlaces = $database->getEnlacesProducto($idProd);
    $lista_reparto = $database->getRepartoProducto($idProd);
    $descripcion = $database->getDescripcionProducto($idProd);
    $lista_palabras = $database->getPalabrasProhibidas();

    echo $twig->render('producto_imprimir.html', ['producto' => $producto, 'lista_imagenes' => $lista_imagenes, 'lista_comentarios' => $lista_comentarios, 'lista_enlaces' => $lista_enlaces, 'lista_reparto' => $lista_reparto,'descripcion' => $descripcion, 'lista_palabras' => $lista_palabras]);
?>