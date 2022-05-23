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

    if(isset($_GET['prod']) && is_numeric($_GET['prod'])){
        $idProd = $_GET['prod'];
        $variablesParaTwig['producto'] = $database->getProducto($idProd);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $database->borrarProducto($idProd);

            header("Location: index.php");
       
    }


      echo $twig->render('borrar_productos.html', $variablesParaTwig);
    ?>