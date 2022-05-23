<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("modelo.php");

    $loader = new \Twig\Loader\FilesystemLoader('template');
    $twig = new \Twig\Environment($loader);


    $database=Database::getInstance();

    $variablesParaTwig = [];
  
    session_start();
    
    if (isset($_SESSION['nickUsuario'])) {   // cogemos el usuario del que hemos iniciado sesión y ese será su perfil
        $variablesParaTwig['user'] = $database->getUser($_SESSION['nickUsuario']);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $nick = $_POST['nick'];
      $email = $_POST['email'];
      $pass = $_POST['contraseña'];


      if($nick != "" && $email != "" && $pass != ""){
        // Actualizo el user
        $res = $database->actualizarUser($_SESSION['nickUsuario'], $nick, $email, password_hash($pass, PASSWORD_DEFAULT));
        if($res){
          $variablesParaTwig['resultado'] = "insertado";
          // Actualizo el user de la pagina
          $variablesParaTwig['user'] = $database->getUser($nick);
          $_SESSION['nickUsuario'] = $nick;
          header("Location: index.php");
          
        }
        else{
            $variablesParaTwig['resultado'] = "error";
        }

      }
      else{
        $variablesParaTwig['resultado'] = "error";
      }
      
      

    }

      echo $twig->render('perfil.html', $variablesParaTwig);
    ?>