<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("modelo.php");

    $loader = new \Twig\Loader\FilesystemLoader('template');
    $twig = new \Twig\Environment($loader);


    $database=Database::getInstance();
    $variablesParaTwig = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') { // recibimos los datos del formulario
        $nick = $_POST['nick'];
        $pass = $_POST['contraseña'];
      
        if ($database->checkLogin($nick, $pass)) {
          session_start();
          
          $_SESSION['nickUsuario'] = $nick;  // guardo en la sesión el nick del usuario que se ha logueado
          //$_SESSION['password'] = $pass; //guardo en la sesión la contraseña del que se ha logeado
          header("Location: index.php");
        }
        else{
          $variablesParaTwig['resultado'] = "error";
        }
  
      }
      
      echo $twig->render('login.html', $variablesParaTwig);
    ?>