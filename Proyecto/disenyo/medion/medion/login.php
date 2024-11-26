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
    nickname VARCHAR(30) NOT NULL,
    pw VARCHAR(50) NOT NULL
);";
$conn->query($sql);

// Insertar usuarios si la tabla está vacía
$sql = "SELECT * FROM USER;";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    $users = [
        ["Adrian", "Callejas", "carcaj", "cisco"],
        ["Gabriel", "Silva", "grubusp", "cisco"],
        ["Laura", "Ventis", "Lyra", "cisco"],
        ["Juan", "Cortinas", "Kaox", "cisco"]
    ];
    
    foreach ($users as $user) {
        $sql = "INSERT INTO USER (firstname, lastname, nickname, pw) 
                VALUES ('" . $user[0] . "', '" . $user[1] . "', '"  . $user[2] . "', '" . $user[3] . "');";
        $conn->query($sql);
    }
}

// Recojo los datos del form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nickname = htmlspecialchars($_REQUEST['nickname']);
    $pw = htmlspecialchars($_REQUEST['pw']);

    // Reviso la tabla de la bbdd
    $sql = "SELECT * FROM USER WHERE nickname = ? AND pw = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nickname, $pw); //le doy lo que he recogido del form
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si el usuario existe
    if ($result->num_rows > 0) {
        $_SESSION['nickname'] = $nickname;
        header('Location: index.html');
        exit();
    } else {
        echo "Usuario no encontrado.";
    }
    $stmt->close();
}

$conn->close();
?>

