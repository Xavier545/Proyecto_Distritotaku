<?php
session_start();

// Verificar si el usuario está solicitando cerrar sesión
if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
    session_destroy();
    header("Location: landing_page.php"); // Redirigir a la landing page después de cerrar sesión
    exit();
}

// Verificar si el usuario está logueado
if (!isset($_SESSION['nickname'])) {
    header("Location: index.php"); // Redirigir al login si no está logueado
    exit();
}

// Conexión a la base de datos
$servername = "db";
$username = "mysql";
$password = "mysecret";
$dbname = "mydb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error al conectar con la base de datos: " . $conn->connect_error);
}

// Obtener información del usuario
$nickname = $_SESSION['nickname'];
$sql = "SELECT firstname, lastname, nickname, email, birthdate, address, pw FROM USER WHERE nickname = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nickname);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Error: Usuario no encontrado.";
    exit();
}

$user = $result->fetch_assoc();
$stmt->close();

// Procesar la edición de datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $new_nickname = htmlspecialchars($_POST['nickname']);
    $email = htmlspecialchars($_POST['email']);
    $birthdate = htmlspecialchars($_POST['birthdate']);
    $address = htmlspecialchars($_POST['address']);
    $new_password = $_POST['password'];

    // Verificar si el nuevo nickname ya existe
    if ($new_nickname !== $nickname) {
        $sql = "SELECT * FROM USER WHERE nickname = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $new_nickname);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('El nickname ya está en uso. Elige otro.');</script>";
        } else {
            // Actualizar la información del usuario
            $sql = "UPDATE USER SET firstname = ?, lastname = ?, nickname = ?, email = ?, birthdate = ?, address = ? WHERE nickname = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssss", $firstname, $lastname, $new_nickname, $email, $birthdate, $address, $nickname);

            if ($stmt->execute()) {
                $_SESSION['nickname'] = $new_nickname;
                echo "<script>alert('Información actualizada correctamente.');</script>";
                $nickname = $new_nickname;
            } else {
                echo "Error al actualizar la información: " . $stmt->error;
            }
        }
    } else {
        // Actualizar la información sin cambiar el nickname
        $sql = "UPDATE USER SET firstname = ?, lastname = ?, email = ?, birthdate = ?, address = ? WHERE nickname = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $firstname, $lastname, $email, $birthdate, $address, $nickname);

        if ($stmt->execute()) {
            echo "<script>alert('Información actualizada correctamente.');</script>";
        } else {
            echo "Error al actualizar la información: " . $stmt->error;
        }
    }

    // Actualizar la contraseña si se proporciona
    if (!empty($new_password)) {
        $sql = "UPDATE USER SET pw = ? WHERE nickname = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $new_password, $nickname);
        if ($stmt->execute()) {
            echo "<script>alert('Contraseña actualizada correctamente.');</script>";
        } else {
            echo "Error al actualizar la contraseña: " . $stmt->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>

    <!-- Slider stylesheet -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />

    <!-- Font awesome style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

    <!-- Custom styles -->
    <link rel="stylesheet" href="css/style.css">

    <link rel="shortcut icon" href="images/nube_akatsuki.ico" />
</head>

<body class="sub_page">
    <div class="hero_area">
        <!-- header section starts -->
        <?php include "sections/header.php" ?>
        <!-- end header section -->
    </div>

    <!-- User Info Section -->
    <section class="contact_section layout_padding">
        <div class="container">
            <div class="custom_heading-container ">
                <h2>Perfil de Usuario</h2>
            </div>
        </div>
        <div class="container layout_padding2">
            <div class="row">
                <div class="col-md-5">
                    <div class="form_container">
                        <h3>Información Personal</h3>
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="firstname">Nombre</label>
                                <input type="text" class="form-control" name="firstname" id="firstname"
                                    value="<?= htmlspecialchars($user['firstname']) ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="lastname">Apellido</label>
                                <input type="text" class="form-control" name="lastname" id="lastname"
                                    value="<?= htmlspecialchars($user['lastname']) ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="nickname">Nickname</label>
                                <input type="text" class="form-control" name="nickname" id="nickname"
                                    value="<?= htmlspecialchars($user['nickname']) ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Correo</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    value="<?= htmlspecialchars($user['email']) ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="birthdate">Fecha de nacimiento</label>
                                <input type="date" class="form-control" name="birthdate" id="birthdate"
                                    value="<?= htmlspecialchars($user['birthdate']) ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Dirección</label>
                                <input type="text" class="form-control" name="address" id="address"
                                    value="<?= htmlspecialchars($user['address']) ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Nueva Contraseña</label>
                                <input type="password" class="form-control" name="password" id="password">
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Actualizar Información</button>
                        </form>
                        <a href="?logout=true" class="btn btn-danger mt-3">Cerrar Sesión</a>
                    </div>
                </div>
                <div class="col-md-7">
                    <h3>Bienvenido, <?= htmlspecialchars($user['firstname']) ?>!</h3>
                    <p>Revisa tus datos y disfruta de las funcionalidades de tu cuenta.</p>
                    <div class="detail-box"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- End User Info Section -->

    <!-- info section -->
    <?php include "sections/footer.php" ?>

    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
</body>

</html>
