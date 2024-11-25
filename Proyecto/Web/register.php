<?php 
session_start();

$servername = "db";
$username = "mysql";
$password = "mysecret";
$dbname = "mydb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Procesar el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $nickname = htmlspecialchars($_POST['nickname']);
    $pw = htmlspecialchars($_POST['pw']);

    // Verificar si el nickname ya existe
    $sql = "SELECT * FROM USER WHERE nickname = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nickname);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "El nickname ya existe. Por favor, elige otro.";
    } else {
        // Insertar nuevo usuario
        $sql = "INSERT INTO USER (firstname, lastname, nickname, pw) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $firstname, $lastname, $nickname, $pw);
        
        if ($stmt->execute()) {
            // Redirigir al login después de registrar
            header('Location: login.php');
            exit();
        } else {
            echo "Error al registrar el usuario: " . $stmt->error;
        }
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>
    <h1>Registro de Usuario</h1>
    <form method="POST" action="">
        Nombre: <input type="text" name="firstname" required><br>
        Apellido: <input type="text" name="lastname" required><br>
        Nickname: <input type="text" name="nickname" required><br>
        Contraseña: <input type="password" name="pw" required><br>
        <input type="submit" value="Registrar">
    </form>
</body>
</html>
