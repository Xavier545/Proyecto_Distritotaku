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

// Recojo los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nickname = htmlspecialchars($_REQUEST['nickname']);
    $pw = htmlspecialchars($_REQUEST['pw']);

    // Consulta a la base de datos
    $sql = "SELECT * FROM USER WHERE nickname = ? AND pw = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nickname, $pw);
    $stmt->execute();
    $result = $stmt->get_result();
    $alertuser = false;

    // Verificar si el usuario existe
    if ($result->num_rows > 0) {
        $_SESSION['nickname'] = $nickname;
        header('Location: landing_page.php');
        exit();
    } else {
        $alertuser = true;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>Distrititotaku</title>

  <!-- slider stylesheet -->
  <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />

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

  <style>
    /* Botones alineados horizontalmente */
    .button-group {
      display: flex;
      justify-content: space-between;
    }

    /* Detalles centrados */
    .detail-box-under {
      text-align: center;
      margin-top: 20px;
    }

    .form_container {
      margin-bottom: 30px;
    }
  </style>
</head>

<body class="sub_page">
  <div class="hero_area">
    <!-- header section starts -->
    <?php include "sections/header.php"; ?>
    <!-- header section ends -->
  </div>
  <!-- login section -->
  <section class="contact_section layout_padding">
    <div class="container">
      <div class="row justify-content-center">
        <div class="custom_heading-container">
          <h2>Iniciar Sesión</h2>
        </div>
      </div>
    </div>
    <div class="container layout_padding2">
      <!-- Formulario en la parte superior -->
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="form_container">
            <form method="POST" action="">
              <div class="form-group">
                <label for="exampleInputName1">Usuario</label>
                <input type="text" class="form-control" id="exampleInputName1" name="nickname" required>
              </div>
              <div class="form-group">
                <label for="exampleInputNumber1">Contraseña</label>
                <input type="password" class="form-control" id="exampleInputNumber1" name="pw" required>
                <?php if (isset($alertuser) && $alertuser == true): ?>
                  <span style="color: red;"><?php echo "Usuario inexistente o contraseña incorrecta "; ?></span>
                <?php endif; ?>
              </div>
              <!-- Botones alineados horizontalmente -->
              <div class="button-group">
                <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                <a href="register.php" class="btn btn-secondary">Registrarse</a>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Imagen y mensaje en la parte inferior centrados -->
      <div class="row justify-content-center align-items-center mt-5">
        <div class="col-md-6 text-center">
          <div class="detail-box-under">
            <h3>Accede a tu cuenta</h3>
            <p>Inicia sesión con tu usuario y contraseña para gestionar tus pedidos y acceder a nuestras funciones
              exclusivas.</p>
          </div>
          <!-- Aquí puedes agregar una imagen si deseas -->
          <img src="images/Simulacrum_Liu_Huo_Prototype.png" alt="Imagen decorativa" class="img-fluid mt-3">
        </div>
      </div>
    </div>
  </section>
  <!-- end login section -->

  <!-- footer section -->
  <?php include "sections/footer.php"; ?>
  <!-- footer section -->

  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>
  <script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>
