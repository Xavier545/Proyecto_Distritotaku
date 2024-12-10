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
</head>

<body class="sub_page">
  <div class="hero_area">
    <!-- header section strats -->
         
     <?php include "sections/header.php";?>
    
    <!-- end header section -->
  </div>
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
                          <?php if(isset($alertuser) && $alertuser == true):?>
                            <span style="color: red;"><?php echo "Usuario inexistente o contraseña incorrecta ";?></span>
                          <?php endif;?>
                      </div>
                      <button type="submit" class="">Iniciar Sesión</button>
                  </form>
                  
                    <a href="register.php" class="register"><button type="submit" class="">Registrarse</button></a>
                          <!-- cambiar como un enlace y no un boton o un btn mas simple-->
                  
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



  <!-- footer section -->
  <?php include "sections/footer.php";?>
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
