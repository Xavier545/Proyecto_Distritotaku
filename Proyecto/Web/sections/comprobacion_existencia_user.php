<?php
// Iniciar sesión
session_start();

// Verificar si el usuario está logueado
if (isset($_SESSION['nickname'])) {
    // Conectar a la base de datos
    $servername = "db";
    $username = "mysql";
    $password = "mysecret";
    $dbname = "mydb";
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Comprobar si el usuario existe
    $nickname = $_SESSION['nickname'];
    $sql = "SELECT id FROM USER WHERE nickname = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nickname);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        // Si el usuario no existe, cerrar sesión y redirigir al login
        session_destroy();
        header("Location: login.php");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>