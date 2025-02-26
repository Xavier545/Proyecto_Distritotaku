<?php

    // Conectar a la base de datos
    $servername = "db";
    $username = "mysql";
    $password = "mysecret";
    $dbname = "mydb";
    $conn = new mysqli($servername, $username, $password, $dbname);
// Verificar si el usuario está logueado
if (isset($_SESSION['nickname'])) {
    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Comprobar si el usuario existe
    $nickname = $_SESSION['nickname'];  
    //  TODO  $rol = $_SESSION['rol'];
    $sql = "SELECT id FROM USER WHERE nickname = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nickname);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        // Si el usuario no existe, cerrar sesión
        session_destroy();
        // Mostrar un mensaje en la misma página
        echo "<script>alert('Tu cuenta ha sido eliminada.');</script>";
        // Terminar la ejecución del script
        exit();
    }
 } //else {
//     // Si no hay sesión, simplemente terminar la ejecución
//     exit();
// }
?>