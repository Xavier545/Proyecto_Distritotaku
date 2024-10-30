<?php 
session_start();
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
            <label for="fname">Primer nombre:</label><br>
            <input type="text" id="nombre" name="nombre" placeholder="Nombre"><br>
            <label for="lname">Apellidos:</label><br>
            <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos"><br>
            <label for="lname">DNI:</label><br>
            <input type="text" id="dni" name="dni" placeholder="DNI"><br>
            <label for="lname">Correo/gmail:</label><br>
            <input type="text" id="correo" name="correo" placeholder="correo"><br><br>
            <label for="lname">Contraseña</label><br>
            <input type="password" id="contrasenya" name="contrasenya" placeholder="****"><br><br>
            <input type="submit" value="Submit">
        </form> 
    </div>
    
</body>
</html>

<?php 

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $nombre = htmlspecialchars($_REQUEST['nombre']);
    $apellidos = htmlspecialchars($_REQUEST['apellidos']);
    $dni = htmlspecialchars($_REQUEST['dni']);
    $correo = htmlspecialchars($_REQUEST['correo']);
    
    $psswd = htmlspecialchars($_REQUEST['contrasenya']);

    if(empty($nombre) || empty($apellidos) || empty($dni) || empty($correo)){
        echo 'alguno de los campos está vacío'; //
    }else{
        echo''.$nombre.''.$apellidos.''.$dni.''.$correo.''.$psswd.'';
    }
/************* PENDIENTE */
/* Falta validar con BBDD */

}


?>
