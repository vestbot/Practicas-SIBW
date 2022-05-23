<?php
	// Inicializamos el motor de plantillas
	require_once "/usr/local/lib/php/vendor/autoload.php";
	include("modelo.php");
	$loader = new \Twig\Loader\FilesystemLoader('template');
	$twig = new \Twig\Environment($loader);

    $variablesParaTwig = [];

	if(isset($_GET['prod']) && is_numeric($_GET['prod']) ){  //esto de aquí es para coger el id de cada producto
        $idProd = $_GET['prod'];
    }
    else{
        $idProd = -1;
    }

	 $database=Database::getInstance();

    $variablesParaTwig['producto'] = $database->getProducto($idProd);
    $variablesParaTwig['lista_imagenes'] = $database->getFotosProducto($idProd);
    $variablesParaTwig['lista_comentarios']  = $database->getComentariosProducto($idProd);
    $variablesParaTwig['lista_palabras']  = $database->getPalabrasProhibidas();

    session_start();
    
    if (isset($_SESSION['nickUsuario'])) {
        $variablesParaTwig['user'] = $database->getUser($_SESSION['nickUsuario']);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $texto = $_POST['texto'];

        if($texto != ""){
            $database->addComentario($idProd, $variablesParaTwig['user']['username'], $variablesParaTwig['user']['email'], $texto);
            $variablesParaTwig['lista_comentarios']  = $database->getComentariosProducto($idProd);
            header("Location: producto.php?prod=$idProd");
        }
        
    }

    echo $twig->render('producto.html', $variablesParaTwig);
?>