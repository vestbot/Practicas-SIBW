<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("modelo.php");

    $loader = new \Twig\Loader\FilesystemLoader('template');
    $twig = new \Twig\Environment($loader);


    $database=Database::getInstance();
    $variablesParaTwig = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nick = $_POST['nick'];
        $email = $_POST['email'];
        $pass = $_POST['contraseña'];
      
       
       if( empty($nick) == true ){
            $errors[] = "El NICK no puede estar vacío";
       }

       if( empty($email) == true){
            $errors[] = "El EMAIL no puede estar vacío";
       }

       if( empty($pass) == true){
            $errors[] = "La CONTRASEÑA no puede estar vacía";
       }

        session_start();
        if(empty($errors) == true){
            $res = $database->addUser($nick, $email, $pass);
            if($res){
              $variablesParaTwig['resultado'] = "insertado";
              $_SESSION['nickUsuario'] = $nick;  // guardo en la sesión el nick del usuario que se ha logueado
              header("Location: index.php");
            }
            else{
                $variablesParaTwig['resultado'] = "error";
            }
        }
        else{
            $variablesParaTwig['resultado'] = "error";
            $variablesParaTwig['errores'] = $errors;
        }
    }
      
      echo $twig->render('registrarse.html', $variablesParaTwig);
    ?>