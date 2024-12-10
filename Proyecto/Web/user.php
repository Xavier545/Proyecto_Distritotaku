<?php
session_start();

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
$sql = "SELECT firstname, lastname, nickname FROM USER WHERE nickname = ?";
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
$conn->close();

// Manejar logout
if (isset($_GET['logout'])) {
    session_destroy();  //la sesion se destruye
    header("Location: landing_page.php"); //me envia a la landing page
    exit();
}
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
        <!-- header section strats -->
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container pt-3">
          <a class="navbar-brand" href="landing_page.php">
            <img src="images/nube_akatsuki.png" alt="">
            <span>
              DISTRITOTAKU
            </span>
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="d-flex  flex-column flex-lg-row align-items-center w-100 justify-content-between">
              <ul class="navbar-nav  ">
                <li class="nav-item active">
                  <a class="nav-link" href="landing_page.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="about.html"> About </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="medicine.html"> Medicine </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="buy.html"> Online Buy </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="news.html"> News </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="contact.html">Contact us</a>
                </li>
              </ul>
              <form class="form-inline ">
                <input type="search" placeholder="Search">
                <button class="btn  my-2 my-sm-0 nav_search-btn" type="submit"></button>
              </form>
              <div class="login_btn-contanier ml-0 ml-lg-5">
                <?php if (isset($_SESSION['nickname'])):  ?>
                        <a href="user.php"><?php echo htmlspecialchars($_SESSION['nickname']);?></a>
                <?php else: ?>
                <a href="user.php">
                  <img src="images/user.png" alt="">
                  <span>
                    Login
                  </span>
                  <?php endif; ?>
                </a>
              </div>
            </div>
          </div>

        </nav>
      </div>
    </header>
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
                    <div class="form_contaier">
                        <h3>Información Personal</h3>
                        <p><strong>Nombre:</strong> <?= htmlspecialchars($user['firstname']) ?></p>
                        <p><strong>Apellido:</strong> <?= htmlspecialchars($user['lastname']) ?></p>
                        <p><strong>Usuario:</strong> <?= htmlspecialchars($user['nickname']) ?></p>
                        <a href="?logout=true" class="btn btn-danger mt-3">Cerrar Sesión</a>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="detail-box">
                        <h3>Bienvenido, <?= htmlspecialchars($user['firstname']) ?>!</h3>
                        <p>Revisa tus datos y disfruta de las funcionalidades de tu cuenta.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End User Info Section -->

 <!-- info section -->
 <section class="info_section layout_padding2">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <div class="info_contact">
            <h4>
              Contact
            </h4>
            <div class="box">
              <div class="img-box">
                <img src="images/telephone-symbol-button.png" alt="">
              </div>
              <div class="detail-box">
                <h6>
                  +01 123567894
                </h6>
              </div>
            </div>
            <div class="box">
              <div class="img-box">
                <img src="images/email.png" alt="">
              </div>
              <div class="detail-box">
                <h6>
                  demo@gmail
                </h6>
              </div>
            </div>
            <div class="box">
              <div class="img-box">
                <img src="images/instagram.png" alt="">
              </div>
              <div class="detail-box">
                <h6>
                  Instagram
                </h6>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="info_menu">
            <h4>
              Menú
            </h4>
            <ul class="navbar-nav  ">
              <li class="nav-item active">
                <a class="nav-link" href="landing_page.php">Inicio <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="about.html"> Sobre </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="medicine.html"> Figuras </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="buy.html"> Compra Online </a>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-md-6">
          <div class="info_news">
            <h4>
              Eres Nuevo?
            </h4>
              <div class="col-md-5">
                <div class="form_contaier_footer">
                    <a href="register.php">
                      Registrarse
                    </a>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- end info section -->


    <!-- Footer -->
    <section class="container-fluid footer_section">
        <p>&copy; 2024 All Rights Reserved.</p>
    </section>

    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
</body>

</html>