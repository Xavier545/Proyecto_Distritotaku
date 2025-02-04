<?php 
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
    $pw = htmlspecialchars($_POST['pw']); // Contraseña en texto plano
    $email = htmlspecialchars($_POST['email']);
    $address = htmlspecialchars($_POST['direccion']);
    $city = htmlspecialchars($_POST['ciudad']);
    $postal_code = htmlspecialchars($_POST['codigoPostal']);
    $birthdate = htmlspecialchars($_POST['date']);
    $rol = "user"; // Establecer el rol como "user" de forma predeterminada

    // Verificar si el nickname ya existe
    $sql = "SELECT * FROM USER WHERE nickname = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nickname);
    $stmt->execute();
    $result = $stmt->get_result();
    $alert = true;

    if ($result->num_rows > 0) {
        $name_error = "Lo siento... el nombre de usuario ya existe";
    } else {
        // Insertar nuevo usuario con contraseña en texto plano
        $alert = false;
        $sql = "INSERT INTO USER (firstname, lastname, nickname, rol, pw, email, address, postal_code, city, birthdate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssss", $firstname, $lastname, $nickname, $rol, $pw, $email, $address, $postal_code, $city, $birthdate);
        
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

?>