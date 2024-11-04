<?php 
session_start();



$n = "adrian";
$p = "123";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $nombre = htmlspecialchars($_REQUEST['nombre']);
    $psswd = htmlspecialchars($_REQUEST['contrasenya']);

    if($nombre == $n && $psswd == $p){
        header('Location: landing_page.php');
    }


/************* PENDIENTE */
/* Falta validar con BBDD */

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Document</title>
</head>
<body>

    <div class="login">
        <form class ="form_login" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" >
            <label for="fname">Nombre  de usuario:</label><br>
            <input type="text" id="nombre" name="nombre" placeholder="Nombre"><br>
            <label for="lname">Contraseña</label><br>
            <input type="password" id="contrasenya" name="contrasenya" placeholder="****"><br>
            <?php
            if(empty($nombre) || empty($psswd)){
                echo'<p style="color:#ff0000">alguno de los campos está vacío</p>'; //
            }elseif($nombre != $n || $psswd != $p){
                echo'<p style="color:#ff0000">alguna de las credenciales es incorrecta</p>';
            }
            
            ?>
            <input type="submit" value="Submit"><br>
            <a class="registrarse" href="register.php">No tienes cuenta? Regístrate</a>
        </form>
    </div>
</body>
</html>


<?php



?>