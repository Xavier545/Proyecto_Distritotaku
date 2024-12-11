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

// Procesar el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $nickname = htmlspecialchars($_POST['nickname']);
    $pw = htmlspecialchars($_POST['pw']);
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
        // Insertar nuevo usuario
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

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Distrititotaku</title>

    <!-- slider stylesheet -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />

    <!-- font awesome style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

    <!-- fonts style -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700|Roboto:400,700&display=swap" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet" />
    <!-- responsive style -->
    <link href="css/responsive.css" rel="stylesheet" />

    <link rel="shortcut icon" href="images/nube_akatsuki.ico" />
</head>

<body class="sub_page">
    <div class="hero_area">
        <!-- header section starts -->
        <?php include "sections/header.php";?>
        <!-- end header section -->
    </div>

    <!-- register section -->
    <section class="contact_section layout_padding">
        <div class="container">
            <div class="row">
                <div class="custom_heading-container">
                    <h2>
                        Registro de Usuario
                    </h2>
                </div>
            </div>
        </div>
        <div class="container layout_padding2">
            <div class="row">
                <div class="col-md-5">
                    <div class="form_container">
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
                            <button type="submit" id="registrar" class="btn btn-primary">Registrar</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="detail-box">
                        <h3>
                            Únete a Nosotros
                        </h3>
                        <p>
                            Regístrate para acceder a nuestros servicios y obtener beneficios exclusivos.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end register section -->
    <!-- footer section -->
    <?php include "sections/footer.php";?>
    <!-- footer section -->

    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script>
    <?php
        include "functions/sweetalert.php";
        sweetalert();
    ?>
    <script src="js/registerForm.js"></script>
    <script src="js/direccion.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>