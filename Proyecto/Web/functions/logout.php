<?php
function logout(){
    // Manejar logout
    if (isset($_GET['logout'])) {
        session_destroy();  //la sesion se destruye
        header("Location: landing_page.php"); //me envia a la landing page
        exit();
    }
}


?>