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

// Crear la tabla USER si no existe

$sql = "CREATE TABLE IF NOT EXISTS USER (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    nickname VARCHAR(30) NOT NULL,
    pw VARCHAR(50) NOT NULL
);";
$conn->query($sql);

// Insertar usuarios si la tabla está vacía
$sql = "SELECT * FROM USER;";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    $users = [
        ["Adrian", "Callejas", "carcaj", "cisco"],
        ["Gabriel", "Silva", "grubusp", "cisco"],
        ["Laura", "Ventis", "Lyra", "cisco"],
        ["Juan", "Cortinas", "Kaox", "cisco"]
    ];
    
    foreach ($users as $user) {
        $sql = "INSERT INTO USER (firstname, lastname, nickname, pw) 
                VALUES ('" . $user[0] . "', '" . $user[1] . "', '"  . $user[2] . "', '" . $user[3] . "');";
        $conn->query($sql);
    }
}

// Recojo los datos del form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nickname = htmlspecialchars($_REQUEST['nickname']);
    $pw = htmlspecialchars($_REQUEST['pw']);

    // Reviso la tabla de la bbdd
    $sql = "SELECT * FROM USER WHERE nickname = ? AND pw = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nickname, $pw); //le doy lo que he recogido del form
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si el usuario existe
    if ($result->num_rows > 0) {
        $_SESSION['nickname'] = $nickname;
        header('Location: landing_page.php');
        exit();
    } else {
        echo "Usuario no encontrado.";
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

  <title>Medion</title>

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
                <a href="">
                  <img src="images/user.png" alt="">
                  <span>
                    Login
                  </span>
                </a>
              </div>
            </div>
          </div>

        </nav>
      </div>
    </header>
    <!-- end header section -->
  </div>



  <!-- contact section -->
  <!-- login section -->
<section class="contact_section layout_padding">
  <div class="container">
      <div class="row">
          <div class="custom_heading-container ">
              <h2>
                  Iniciar Sesión
              </h2>
          </div>
      </div>
  </div>
  <div class="container layout_padding2">
      <div class="row">
          <div class="col-md-5">
              <div class="form_contaier">
                  <form method="POST" action="">
                      <div class="form-group">
                          <label for="exampleInputName1">Usuario</label>
                          <input type="text" class="form-control" id="exampleInputName1" name="nickname" required>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputNumber1">Contraseña</label>
                          <input type="password" class="form-control" id="exampleInputNumber1" name="pw" required>
                      </div>
                      <button type="submit" class="">Iniciar Sesión</button>
                  </form>
                  
                    <a href="register.php" class="register"><button type="submit" class="">Registrarse</button></a>
                  
                  
              </div>
          </div>
          <div class="col-md-7">
              <div class="detail-box">
                  <h3>
                      Accede a tu cuenta
                  </h3>
                  <p>
                      Inicia sesión con tu usuario y contraseña para gestionar tus pedidos y acceder a nuestras funciones exclusivas.
                  </p>
              </div>
          </div>
      </div>
  </div>
</section>
<!-- end login section -->


  <!-- end contact section -->

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
              Menu
            </h4>
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
            </ul>
          </div>
        </div>
        <div class="col-md-6">
          <div class="info_news">
            <h4>
              newsletter
            </h4>
            <form action="">
              <input type="text" placeholder="Enter Your email">
              <div class="d-flex justify-content-center justify-content-md-end mt-3">
                <button>
                  Subscribe
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- end info section -->

  <!-- footer section -->
  <section class="container-fluid footer_section">
    <p>
      &copy; 2019 All Rights Reserved. Design by
      <a href="https://html.design/">Free Html Templates</a>
    </p>
  </section>
  <!-- footer section -->

  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js">
  </script>
  <script type="text/javascript">
    $(".owl-carousel").owlCarousel({
      loop: true,
      margin: 10,
      nav: true,
      navText: [],
      autoplay: true,
      responsive: {
        0: {
          items: 1
        },
        600: {
          items: 2
        },
        1000: {
          items: 4
        }
      }
    });
  </script>
  <script type="text/javascript">
    $(".owl-2").owlCarousel({
      loop: true,
      margin: 10,
      nav: true,
      navText: [],
      autoplay: true,

      responsive: {
        0: {
          items: 1
        },
        600: {
          items: 2
        },
        1000: {
          items: 4
        }
      }
    });
  </script>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
       $("#loginForm").on("submit", function (e) {
           e.preventDefault(); // Evitar recarga de página

           $.ajax({
               url: "login_handler.php",
               type: "POST",
               data: $(this).serialize(),
               success: function (response) {
                   const res = JSON.parse(response);
                   if (res.status === "success") {
                       alert(res.message);
                       window.location.href = "landing_page.php"; // Redirigir si es exitoso
                   } else {
                       alert(res.message);
                   }
               },
               error: function () {
                   alert("Error en la conexión con el servidor.");
               }
           });
       });
   </script>
</body>

</html>
