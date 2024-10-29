<?php 


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing_page</title>
    <link rel="stylesheet" href="landing_page.css">
</head>
<body>
    <div class="menu"> <!-- Que no se vea hasta que no esté logueado-->
        <!-- Start nav -->
        <nav id="menu">
            <!-- Start menu -->
            <ul>
                <li><a href="#">Menú</a>
                    <!-- Start menú desplegable -->
                    <ul>
                        <li><a href="#">Usuarios</a></li>
                        <li><a href="#">Productos</a></li>
                        
                    </ul>
                    <!-- End menú desplegable -->
                </li>
            </ul>
            <!-- End menu -->
        </nav>
        <!-- End nav -->
    </div>

    <div class="landing_page_centro">
        <img class="logo" src="../imagenes_web/Distritootaku_logo_2.png" alt="Logo">
    </div>

    <div class="divlogin">
       <a href="login.php"><button type="button" class="login">Log in</button></a> 
    </div>  

    
  




</body>
</html>