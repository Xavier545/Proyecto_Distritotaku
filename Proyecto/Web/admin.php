<?php
session_start();

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




<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro y Administración</title>
    <link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>
    <div class="container">
        <h2>Iniciar Sesión como Administrador</h2>
        <?php if (isset($login_error)): ?>
            <div class="alert alert-danger"><?php echo $login_error; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Usuario</label>
                <input type="text" class="form-control" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <button type="submit" name="admin_login" class="btn btn-primary">Iniciar Sesión</button>
        </form>

        <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
            <h2>Registro de Usuario</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="firstname">Nombre</label>
                    <input type="text" class="form-control" name="firstname" id="firstname" required>
                </div>
                <div class="form-group">
                    <label for="lastname">Apellido</label>
                    <input type="text" class="form-control" name="lastname" id="lastname" required>
                </div>
                <div class="form-group">
                    <label for="nickname">Nickname</label>
                    <input type="text" class="form-control" name="nickname" id="nickname" required>
                    <?php if (isset($name_error)): ?>
                        <span style="color:red;"><?php echo $name_error; ?></span>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" class="form-control" name="email" id="email" required>
                </div>
                <div class="form-group">
                    <label for="date">Fecha de nacimiento</label>
                    <input type="date" class="form-control" name="date" id="date" required>
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" class="form-control" name="direccion" id="direccion" required>
                </div>
                <div class="form-group">
                    <label for="ciudad">Ciudad</label>
                    <input type="text" class="form-control" name="ciudad" id="ciudad" required>
                </div>
                <div class="form-group">
                    <label for="cpostal">Código Postal</label>
                    <input type="text" class="form-control" name="codigoPostal" id="cpostal" required>
                </div>
                <div class="form-group">
                    <label for="pw">Contraseña</label>
                    <input type="password" class="form-control" name="pw" id="pw" required>
                </div>
                <button type="submit" name="register" class="btn btn-primary">Registrar</button>
            </form>

            <h2>Panel de Administración</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Nickname</th>
                        <th>Email</th>
                        <th>Dirección</th>
                        <th>Ciudad</th>
                        <th>Código Postal</th>
                        <th>Fecha de Nacimiento</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo $user['id']; ?></td>
                                <td><?php echo $user['firstname']; ?></td>
                                <td><?php echo $user['lastname']; ?></td>
                                <td><?php echo $user['nickname']; ?></td>
                                <td><?php echo $user['email']; ?></td>
                                <td><?php echo $user['address']; ?></td>
                                <td><?php echo $user['city']; ?></td>
                                <td><?php echo $user['postal_code']; ?></td>
                                <td><?php echo $user['birthdate']; ?></td>
                                <td><?php echo $user['rol']; ?></td>
                                <td>
                                    <a href="?delete=true&id=<?php echo $user['id']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');" class="btn btn-danger">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="11">No hay usuarios registrados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
