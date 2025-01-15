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
            // Cifrar la contraseña antes de almacenarla
            $hashed_pw = password_hash($pw, PASSWORD_DEFAULT);

            // Insertar nuevo usuario
            $sql = "INSERT INTO USER (firstname, lastname, nickname, rol, pw, email, address, postal_code, city, birthdate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssssss", $firstname, $lastname, $nickname, $rol, $hashed_pw, $email, $address, $postal_code, $city, $birthdate);
            
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
            // Verificar si la nueva contraseña es válida
            if(strlen($new_pw) < 8) {
                echo "<script>alert('La contraseña debe tener al menos 8 caracteres.');</script>";
            } else {
                // Cifrar la nueva contraseña
                $hashed_pw = password_hash($new_pw, PASSWORD_DEFAULT);
                $sql = "UPDATE USER SET firstname = ?, lastname = ?, nickname = ?, email = ?, address = ?, city = ?, postal_code = ?, pw = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssssssi", $firstname, $lastname, $nickname, $email, $address, $city, $postal_code, $hashed_pw, $userId);
            }
        } else {
            // Si no hay nueva contraseña, actualizar solo los otros campos
            $sql = "UPDATE USER SET firstname = ?, lastname = ?, nickname = ?, email = ?, address = ?, city = ?, postal_code = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssi", $firstname, $lastname, $nickname, $email, $address, $city, $postal_code, $userId);
        }

        if ($stmt->execute()) {
            // Redirigir después de la actualización para evitar el reenvío de formularios
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

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro y Administración</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <!-- Formulario de inicio de sesión -->
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

        <!-- Opciones de administración -->
        <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
            <h2 class="mt-5">Opciones de Administración</h2>

            <!-- Botón para mostrar el formulario de registro en un popup -->
            <button class="btn btn-secondary mb-3" type="button" data-bs-toggle="modal" data-bs-target="#registerModal">
                Registrar Usuario
            </button>

            <!-- Modal para registro de usuario -->
            <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST" action="">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="registerModalLabel">Registrar Usuario</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
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
                                    <label for="pw">Contraseña</label>
                                    <input type="password" class="form-control" name="pw" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="direccion">Dirección</label>
                                    <input type="text" class="form-control" name="direccion" required>
                                </div>
                                <div class="form-group">
                                    <label for="ciudad">Ciudad</label>
                                    <input type="text" class="form-control" name="ciudad" required>
                                </div>
                                <div class="form-group">
                                    <label for="codigoPostal">Código Postal</label>
                                    <input type="text" class="form-control" name="codigoPostal" required>
                                </div>
                                <div class="form-group">
                                    <label for="date">Fecha de Nacimiento</label>
                                    <input type="date" class="form-control" name="date" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" name="register" class="btn btn-primary">Registrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <h2 class="mt-5">Usuarios Registrados</h2>
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
                                <td>
                                    <a href="?delete&id=<?php echo $user['id']; ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">Eliminar</a>
                                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $user['id']; ?>">Editar</button>

                                    <!-- Modal para editar usuario -->
                                    <div class="modal fade" id="editModal<?php echo $user['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo $user['id']; ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form method="POST" action="">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel<?php echo $user['id']; ?>">Editar Usuario</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                                        <div class="form-group">
                                                            <label for="firstname">Nombre</label>
                                                            <input type="text" class="form-control" name="firstname" value="<?php echo $user['firstname']; ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="lastname">Apellido</label>
                                                            <input type="text" class="form-control" name="lastname" value="<?php echo $user['lastname']; ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="nickname">Nickname</label>
                                                            <input type="text" class="form-control" name="nickname" value="<?php echo $user['nickname']; ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">Email</label>
                                                            <input type="email" class="form-control" name="email" value="<?php echo $user['email']; ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="address">Dirección</label>
                                                            <input type="text" class="form-control" name="address" value="<?php echo $user['address']; ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="city">Ciudad</label>
                                                            <input type="text" class="form-control" name="city" value="<?php echo $user['city']; ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="postal_code">Código Postal</label>
                                                            <input type="text" class="form-control" name="postal_code" value="<?php echo $user['postal_code']; ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="new_pw">Nueva Contraseña</label>
                                                            <input type="password" class="form-control" name="new_pw">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                        <button type="submit" name="update_user" class="btn btn-primary">Guardar Cambios</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
