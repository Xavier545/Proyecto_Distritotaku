<?php
$servername = "db";
$username = "mysql";
$password = "mysecret";
$dbname = "mydb";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Hola Xavier
// Recojo los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nickname = htmlspecialchars($_REQUEST['nickname']);
    $pw = htmlspecialchars($_REQUEST['pw']);

    // Consulta a la base de datos
    $sql = "SELECT * FROM USER WHERE nickname = ? AND pw = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nickname, $pw);
    $stmt->execute();
    $result = $stmt->get_result();
    $alertuser = false;

    // Verificar si el usuario existe
    if ($result->num_rows > 0) {
        $_SESSION['nickname'] = $nickname;
        header('Location: landing_page.php');
        exit();
    } else {
        $alertuser = true;
    }
    $stmt->close();
}



?>