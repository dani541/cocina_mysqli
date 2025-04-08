<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/database/config.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/database/functions.php";

include_once $_SERVER['DOCUMENT_ROOT'] . "/classes/User.php";


$email=$password="";
$emailEr=$passwordEr="";

$errores=false;





if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $email=$_POST["email"];
    $password=$_POST["password"];



    if (empty($email)) {
        $emailEr="Es obligatorio";
        $errores=true;
    }



    if (empty($password)) {
        $passwordEr="Es obligatorio";
        $errores=true;
    }


    if(!$errores){


        $user = findUser($email);

        if ($user) {
            echo "Hola, " . $user['name'];
        } else {
            echo "Usuario no encontrado.";
        }


    }


}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    

        <h3>Login</h3>


    <form action="" method="POST">
    <label for="">Email:</label>
    <input type="text" name="email">


    <br>
    <br>

    <label for="">Contraseña:</label>
    <input type="text" name="password">
    
    
    
    <input type="submit" value="Login">
    </form>



</body>
</html>