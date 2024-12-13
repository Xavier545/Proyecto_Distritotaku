<?php
session_start();

// Definir las credenciales del administrador
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD', 'admin'); // Cambia esto a una contraseña más segura

// Verificar si el usuario ya está logueado como administrador
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    // Conexión a la base de datos
    $servername = "db";
    $username = "mysql";
    $password = "mysecret";
    $dbname = "mydb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Error al conectar con la base de datos: " . $conn->connect_error);
    }

    // Procesar la eliminación de un usuario
    if (isset($_POST['delete_user'])) {
        $nickname_to_delete = htmlspecialchars($_POST['nickname_to_delete']);
        $sql = "DELETE FROM USER WHERE nickname = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nickname_to_delete);
        if ($stmt->execute()) {
            echo "<script>alert('Usuario eliminado correctamente.');</script>";
        } else {
            echo "<script>alert('Error al eliminar el usuario: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    }

    // Procesar la adición de un nuevo usuario
    if (isset($_POST['add_user'])) {
        $firstname = htmlspecialchars($_POST['firstname']);
        $lastname = htmlspecialchars($_POST['lastname']);
        $nickname = htmlspecialchars($_POST['nickname']);
        $email = htmlspecialchars($_POST['email']);
        $birthdate = htmlspecialchars($_POST['birthdate']);
        $address = htmlspecialchars($_POST['address']);
        $password = password_hash('defaultpassword', PASSWORD_DEFAULT); // Cambia esto según sea necesario

        // Verificar si el nickname ya existe
        $sql = "SELECT * FROM USER WHERE nickname = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nickname);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('El nickname ya está en uso. Elige otro.');</script>";
        } else {
            // Insertar el nuevo usuario
            $sql = "INSERT INTO USER (firstname, lastname, nickname, email, birthdate, address, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssss", $firstname, $lastname, $nickname, $email, $birthdate, $address, $password);
            if ($stmt->execute()) {
                echo "<script>alert('Usuario añadido correctamente.');</script>";
            } else {
                echo "<script>alert('Error al añadir el usuario: " . $stmt->error . "');</script>";
            }
            $stmt->close();
        }
    }

    $conn->close();
} else {
    // Procesar el inicio de sesión
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);

        if ($username === ADMIN_USERNAME && $password === ADMIN_PASSWORD) {
            $_SESSION['admin_logged_in'] = true;
            header("Location: admin.php");
            exit();
        } else {
            $error = "Credenciales incorrectas.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/bootstrap.css">
</head>

<body>
    <div class="container">
        <h2>Panel de Administración</h2>

        <?php if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true): ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Usuario</label>
                    <input type="text" class="form-control" name="username" id ="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger mt-2"><?= $error ?></div>
                <?php endif; ?>
            </form>
        <?php else: ?>
            <h3>Gestión de Usuarios</h3>
            <form method="POST" action="">
                <h4>Añadir Usuario</h4>
                <div class="form-group">
                    <label for="firstname">Nombre</label>
                    <input type="text" class="form-control" name="firstname" required>
                </div>
                <div class="form-group">
                    <label for="lastname">Apellido</label>
                    <input type="text" class="form-control" name="lastname" required>
                </div>
                <div class="form-group">
                    <label for="nickname">Nickname</label>
                    <input type="text" class="form-control" name="nickname" required>
                </div>
                <div class="form-group">
                    <label for="email">Correo</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="form-group">
                    <label for="birthdate">Fecha de nacimiento</label>
                    <input type="date" class="form-control" name="birthdate" required>
                </div>
                <div class="form-group">
                    <label for="address">Dirección</label>
                    <input type="text" class="form-control" name="address" required>
                </div>
                <button type="submit" name="add_user" class="btn btn-success">Añadir Usuario</button>
            </form>

            <h4>Eliminar Usuario</h4>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="nickname_to_delete">Nickname del Usuario a Eliminar</label>
                    <input type="text" class="form-control" name="nickname_to_delete" required>
                </div>
                <button type="submit" name="delete_user" class="btn btn-danger">Eliminar Usuario</button>
            </form>

            <a href="logout.php" class="btn btn-warning mt-3">Cerrar Sesión</a>
        <?php endif; ?>
    </div>

    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.js"></script>
</body>

</html>