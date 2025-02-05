<?php
session_start();
include "sections/comprobacion_existencia_user.php";

// Función para obtener los productos en la cesta
function obtenerProductosEnCesta() {
    // Aquí deberías implementar la lógica para obtener los productos de la cesta del usuario
    // Por ejemplo, podrías tener una variable de sesión que almacene los productos en la cesta
    return isset($_SESSION['cesta']) ? $_SESSION['cesta'] : [];
}
$productosEnCesta = obtenerProductosEnCesta();
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
<body>
  <div class="hero_area">
    <!--header section strats -->
    <?php include "sections/header.php";?>
    <!-- end header section -->
    <!-- slider section -->
    <?php include "sections/slider.php";?>
    <!-- end slider section -->
  </div>
  <!-- feature section -->
  <?php include "sections/feature.php";?>
  <!-- end feature section -->
  <!-- discount section -->
  <?php include "sections/discount.php";?>
  <!-- end discount section -->
  <!-- products section -->
  <?php include "sections/productos.php";?>
  <!-- end products section -->
  <!-- about section -->
  <section class="about_section layout_padding">
    <div class="container">
      <div class="custom_heading-container ">
        <h2>
          Conócenos
        </h2>
      </div>

      <div class="img-box">
        <img src="images/distritootaku_logo_2.png" alt="">
      </div>
      <div class="detail-box">
        <p>
          Distrito Otaku es una tienda online que se dedica a vender productos sobre anime.
          Somos recientes en el mercado y tenemos tanto buen material como buenas ofertas.
        </p>
        <div class="d-flex justify-content-center">
          <a href="">
            Saber más
          </a>
        </div>
      </div>
    </div>
  </section>
  <!-- end about section -->
  <!-- footer section -->
  <?php include "sections/footer.php";?>
  <!-- footer section -->
  <!-- Sidebar para la cesta -->
  <?php include "sections/sidebar.php";?>
  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script>
  <script src="js/carrusel1.js"></script>
  <script src="js/carrusel2.js"></script>
</body>
</html>