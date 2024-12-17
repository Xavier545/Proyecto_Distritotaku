<?php
session_start();

// Verificar si el usuario está logueado como administrador
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php"); // Redirigir al login si no está logueado
    exit();
}

// Incluir archivo de configuración para la base de datos
include 'config.php';

// Manejar la eliminación de usuarios
if (isset($_GET['delete'])) {
    $userId = filter_var($_GET['id'], FILTER_VALIDATE_INT); // Validar el ID del usuario
    if ($userId) {
        $sql = "DELETE FROM USER WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        if ($stmt->execute()) {
            // Si el usuario eliminado está logueado, destruir su sesión
            $sql_check_session = "SELECT nickname FROM USER WHERE id = ?";
            $stmt_check = $conn->prepare($sql_check_session);
            $stmt_check->bind_param("i", $userId);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();
            if ($result_check->num_rows === 0 && isset($_SESSION['id']) && $_SESSION['id'] === $userId) {
                session_destroy();
                setcookie(session_name(), '', time() - 3600, '/'); // Eliminar la cookie de sesión
            }

            echo "<script>alert('Usuario eliminado exitosamente.');</script>";
            header("Location: admin.php"); // Recargar la página para actualizar la lista
            exit();
        } else {
            echo "<script>alert('Error al eliminar usuario: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('ID de usuario inválido.');</script>";
    }
}

// Obtener usuarios de la base de datos
$sql = "SELECT * FROM USER";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Registro de Usuarios</title>
    <link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>
    <div class="container">
        <h2>Registro de Usuarios</h2>
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
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['firstname']; ?></td>
                            <td><?php echo $row['lastname']; ?></td>
                            <td><?php echo $row['nickname']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['address']; ?></td>
                            <td><?php echo $row['city']; ?></td>
                            <td><?php echo $row['postal_code']; ?></td>
                            <td><?php echo $row['birthdate']; ?></td>
                            <td><?php echo $row['rol']; ?></td>
                            <td>
                                <a href="admin.php?delete=true&id=<?php echo $row['id']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');" class="btn btn-danger">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="11">No se encontraron usuarios.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>

<?php
$conn->close();
?>
