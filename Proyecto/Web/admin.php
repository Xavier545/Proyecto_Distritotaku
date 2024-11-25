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

// Verificar si el usuario es admin
if (!isset($_SESSION['nickname'])) {
    header('Location: login.php');
    exit();
}

$sql = "SELECT role FROM USER WHERE nickname = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION['nickname']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user['role'] !== 'admin') {
    echo "Acceso denegado. Solo los administradores pueden acceder.";
    exit();
}

// Eliminar usuario
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete'])) {
    $id = intval($_POST['id']);
    $sql = "DELETE FROM USER WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo "Usuario eliminado.";
}

// Listar usuarios
$sql = "SELECT id, firstname, lastname, nickname, role FROM USER";
$result = $conn->query($sql);

// Agregar usuario
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['register'])) {
    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $nickname = htmlspecialchars($_POST['nickname']);
    $pw = htmlspecialchars($_POST['pw']);
    $role = htmlspecialchars($_POST['role']);

    $sql = "INSERT INTO USER (firstname, lastname, nickname, pw, role) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $firstname, $lastname, $nickname, $pw, $role);
    $stmt->execute();
    echo "Usuario registrado.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración</title>
</head>
<body>
    <h1>Panel de Administración</h1>
    <h2>Lista de Usuarios</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Nickname</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['firstname'] ?></td>
            <td><?= $row['lastname'] ?></td>
            <td><?= $row['nickname'] ?></td>
            <td><?= $row['role'] ?></td>
            <td>
                <form method="POST" action="">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <input type="submit" name="delete" value="Eliminar">
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <h2>Registrar Nuevo Usuario</h2>
    <form method="POST" action="">
        Nombre: <input type="text" name="firstname" required><br>
        Apellido: <input type="text" name="lastname" required><br>
        Nickname: <input type="text" name="nickname" required><br>
        Contraseña: <input type="password" name="pw" required><br>
        Rol: 
        <select name="role">
            <option value="user">Usuario</option>
            <option value="admin">Administrador</option>
        </select><br>
        <input type="submit" name="register" value="Registrar">
    </form>
</body>
</html>
