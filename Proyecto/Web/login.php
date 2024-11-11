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

// Crear la tabla USER si no existe
$sql = "CREATE TABLE IF NOT EXISTS USER (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    email VARCHAR(50)
);";
$conn->query($sql);

// Insertar usuarios si la tabla está vacía
$sql = "SELECT * FROM USER;";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    $users = [
        ["LUIS JORGE", "BARRACHINA BUESO", "lbarra@gmail.com"],
        ["CARLOS ANTONIO", "EGEA HERNANDEZ", "cegea@gmail.com"],
        ["CESAR LUIS", "BLASCO ESCUREDO", "cblasco@gmail.com"],
        ["MANUEL", "GARCIA GIRONA", "mgarcia@gmail.com"],
        ["ADOLFO", "VIDAGANY GISBERT", "avida@gmail.com"]
    ];
    
    foreach ($users as $user) {
        $sql = "INSERT INTO USER (firstname, lastname, email) 
                VALUES ('" . $user[0] . "', '" . $user[1] . "', '" . $user[2] . "');";
        $conn->query($sql);
    }
}

// Recojo los datos del form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_REQUEST['nombre']);
    $apellido = htmlspecialchars($_REQUEST['apellido']);

    // Reviso la tabla de la bbdd
    $sql = "SELECT * FROM USER WHERE firstname = ? AND lastname = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nombre, $apellido); //le doy lo que he recogido del form
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si el usuario existe
    if ($result->num_rows > 0) {
        $_SESSION['nombre'] = $nombre . ' ' . $apellido;
        header('Location: landing_page.php');
        exit();
    } else {
        echo "Usuario no encontrado.";
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
    <title>Login</title>
</head>
<body>
    <form method="POST" action="">
        Nombre: <input type="text" name="nombre" required><br>
        Apellido: <input type="text" name="apellido" required><br>
        <input type="submit" value="Iniciar Sesión">
    </form>
</body>
</html>

