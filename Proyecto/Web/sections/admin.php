<?php

// Conexión a la base de datos
$servername = "db";
$username = "mysql";
$password = "mysecret";
$dbname = "mydb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Procesar el formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    // Asegurarse de que todos los campos están presentes
    if (isset($_POST['firstname'], $_POST['lastname'], $_POST['nickname'], $_POST['pw'], $_POST['email'], $_POST['direccion'], $_POST['ciudad'], $_POST['codigoPostal'], $_POST['date'])) {
        
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

        if ($result->num_rows > 0) {
            $name_error = "Lo siento... el nombre de usuario ya existe";
        } else {
            // Insertar nuevo usuario
            $sql = "INSERT INTO USER (firstname, lastname, nickname, rol, pw, email, address, postal_code, city, birthdate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssssss", $firstname, $lastname, $nickname, $rol, $pw, $email, $address, $postal_code, $city, $birthdate);
            
            if ($stmt->execute()) {
                echo "<script>alert('Usuario registrado exitosamente');</script>";
            } else {
                echo "<script>alert('Error al registrar el usuario: " . $stmt->error . "');</script>";
            }
        }

        $stmt->close();
    } else {
        echo "<script>alert('Por favor, completa todos los campos del formulario.');</script>";
    }
}

// Procesar el formulario de inicio de sesión del administrador
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['admin_login'])) {
    // Credenciales de administrador
    $admin_username = "admin";
    $admin_password = "admin"; // Cambia esto por una contraseña más segura

    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Verificar credenciales
    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
    } else {
        $login_error = "Credenciales incorrectas.";
    }
}

// Manejar la eliminación de usuarios
if (isset($_GET['delete']) && isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    $userId = intval($_GET['id']);
    
    // Eliminar el usuario
    $sql = "DELETE FROM USER WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    if ($stmt->execute()) {
        echo "<script>alert('Usuario eliminado exitosamente.');</script>";
    } else {
        echo "<script>alert('Error al eliminar usuario: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

// Procesar el formulario de edición de usuario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_user'])) {
    // Asegurarse de que se está recibiendo el ID del usuario
    if (isset($_POST['user_id'])) {
        $userId = intval($_POST['user_id']);
        $firstname = htmlspecialchars($_POST['firstname']);
        $lastname = htmlspecialchars($_POST['lastname']);
        $nickname = htmlspecialchars($_POST['nickname']);
        $email = htmlspecialchars($_POST['email']);
        $address = htmlspecialchars($_POST['address']);
        $city = htmlspecialchars($_POST['city']);
        $postal_code = htmlspecialchars($_POST['postal_code']);
        $new_pw = isset($_POST['new_pw']) ? htmlspecialchars($_POST['new_pw']) : '';

        // Verificar si se ha proporcionado una nueva contraseña
        if (!empty($new_pw)) {
            $sql = "UPDATE USER SET firstname = ?, lastname = ?, nickname = ?, email = ?, address = ?, city = ?, postal_code = ?, pw = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssssi", $firstname, $lastname, $nickname, $email, $address, $city, $postal_code, $new_pw, $userId);
        } else {
            // Si no hay nueva contraseña, actualizar solo los otros campos
            $sql = "UPDATE USER SET firstname = ?, lastname = ?, nickname = ?, email = ?, address = ?, city = ?, postal_code = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssi", $firstname, $lastname, $nickname, $email, $address, $city, $postal_code, $userId);
        }

        if ($stmt->execute()) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error al actualizar el usuario: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    }
}

// Obtener usuarios de la base de datos solo si el administrador está logueado
$users = [];
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    $sql = "SELECT * FROM USER";
    $result = $conn->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }
}
?>