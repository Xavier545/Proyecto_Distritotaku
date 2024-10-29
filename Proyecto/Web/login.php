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
        <form class ="form_login" action="/action_page.php">
            <label for="fname">Primer nombre:</label><br>
            <input type="text" id="fname" name="fname" placeholder="Nombre"><br>
            <label for="lname">Apellidos:</label><br>
            <input type="text" id="lname" name="lname" placeholder="Apellidos"><br>
            <label for="lname">DNI:</label><br>
            <input type="text" id="lname" name="lname" placeholder="DNI"><br>
            <label for="lname">Correo/gmail:</label><br>
            <input type="text" id="lname" name="lname" placeholder="correo"><br><br>
            <input type="submit" value="Submit">
        </form> 
    </div>
    
</body>
</html>
