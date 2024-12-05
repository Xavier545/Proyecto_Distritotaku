<?php 

session_start();
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

<body>
  <div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container pt-3">
          <a class="navbar-brand" href="landing_page.php">
            <img src="images/logo.png" alt="">
            <span>
              Medion
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
                  <a class="nav-link" href="landing_page.php">Inicio <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="about.html"> Sobre </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="buy.html"> Compra Online </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="news.html"> Noticias </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="contact.html">Contacto</a>
                </li>
              </ul>
              <form class="form-inline ">
                <input type="search" placeholder="Search">
                <button class="btn  my-2 my-sm-0 nav_search-btn" type="submit"></button>
              </form>
              <div class="login_btn-contanier ml-0 ml-lg-5">
              <?php if (isset($_SESSION['nickname'])):  ?>
                   
                        <a href="#"><?php echo htmlspecialchars($_SESSION['nickname']);?></a>
                    
                <?php else: ?>
                <a href="login.php">
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
    <!-- slider section -->
    <section class=" slider_section position-relative">
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="container">
              <div class="row">
                <div class="col-md-4">
                  <div class="img-box">
                    <img src="images/narutobaryon.png" alt="">
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="detail-box">
                    <h1>
                      Bienvenido/a a <br>
                      <span>
                        DISTRITOTAKU
                      </span>

                    </h1>
                    <p>
                      Tenemos una gran variedad de productos de tu manga/anime favorito!!!
                      Todo lo que busques lo encontrarás aquí!!!
                    </p>
                    <div>
                      <a href="">
                        Compra ahora
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="container">
              <div class="row">
                <div class="col-md-4">
                  <div class="img-box">
                    <img src="images/luffygear5.png" alt="">
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="detail-box">
                    <h1>
                      Bienvenido/a a <br>
                      <span>
                        DISTRITOTAKU
                      </span>

                    </h1>
                    <p>
                      Tenemos una gran variedad de productos de tu manga/anime favorito!!!
                      Todo lo que busques lo encontrarás aquí!!!
                    </p>
                    <div>
                      <a href="">
                        Compra ahora
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="container">
              <div class="row">
                <div class="col-md-4">
                  <div class="img-box">
                    <img src="images/gokussj4.png" alt="">
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="detail-box">
                    <h1>
                      Bienvenido/a a <br>
                      <span>
                        DISTRITOTAKU
                      </span>

                    </h1>
                    <p>
                      Tenemos una gran variedad de productos de tu manga/anime favorito!!!
                      Todo lo que busques lo encontrarás aquí!!!
                    </p>
                    <div>
                      <a href="">
                        Compra ahora
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="sr-only">Previo</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="sr-only">Siguiente</span>
        </a>
      </div>


    </section>
    <!-- end slider section -->
  </div>

  <section class="feature_section  layout_padding">
    <div class="container">
      <div class="feature_container">
        <div class="box">
          <div class="img-box">
            <img src = images/icono_db.png width="73" height="73">
          </div>
          <div class="detail-box">
            <h5>
              Figuras de Dragon Ball
            </h5>
            <p>
              Todo lo que buscas de Dragon Ball está Aquí!!!
            </p>
          </div>
        </div>
        <div class="box">
          <div class="img-box">
          <img src = images/icono_one_piece.png width="73" height="73">
          </div>
          <div class="detail-box">
            <h5>
              Figuras de One Piece
            </h5>
            <p>
              Todo lo que buscas de One Piece está Aquí!!!
            </p>
          </div>
        </div>
        <div class="box">
          <div class="img-box">
          <img src = images/icono_naruto.png width="73" height="73">
          </div>
          <div class="detail-box">
            <h5>
              Figuras de Naruto
            </h5>
            <p>
            Todo lo que buscas de Naruto está Aquí!!!
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end feature section -->

  <!-- discount section -->

  <section class="discount_section">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-3 col-md-5 offset-md-2">
          <div class="detail-box">
            <h2>
              La Sección<br>
               de Noticias<br>
               recientes
              <span>
                Sobre Anime
              </span>

            </h2>
            <p>
              Aquí encontrarás noticias recientes sobre tus animes favoritos!!!
            </p>
            <div>
              <a href="">
                Figuras
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-7 col-md-5">
          <div class="img-box">
            <section class="client_section layout_padding">
              <div class="container">
                <div class="custom_heading-container ">
                  <h2>
                    Noticias!
                  </h2>
                </div>
                <div id="carouselExample2Indicators" class="carousel slide" data-ride="carousel">
                  <ol class="carousel-indicators">
                    <li data-target="#carouselExample2Indicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExample2Indicators" data-slide-to="1"></li>
                    <li data-target="#carouselExample2Indicators" data-slide-to="2"></li>
                  </ol>
                  <div class="carousel-inner">
                    <div class="carousel-item active">
                      <div class="client_container layout_padding2">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/PBzsCsHgqgQ?si=wW1hzWVT9RwITuC5" 
                          title="YouTube video player" frameborder="0" 
                          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                          referrerpolicy="strict-origin-when-cross-origin" 
                          allowfullscreen>
                        </iframe>
                      </div>
                    </div>
                    <div class="carousel-item">
                      <div class="client_container layout_padding2">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/0yzrlTxVxzg?si=7avxfZhJFuzvVFKQ" title="YouTube video player" 
                          frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                          referrerpolicy="strict-origin-when-cross-origin" 
                          allowfullscreen>
                        </iframe>
                      </div>
                    </div>
                    <div class="carousel-item">
                      <div class="client_container layout_padding2">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/3mOTQcQrPkY?si=LwCKi-ib6lflHJZA" title="YouTube video player" 
                          frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                          referrerpolicy="strict-origin-when-cross-origin" 
                          allowfullscreen>
                        </iframe>
                      </div>
                    </div>
                  </div>
                </div>


              </div>
            </section>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- end discount section -->

  <!-- health section -->

  <section class="health_section layout_padding">
    <div class="health_carousel-container">
      <h2 class="text-uppercase">
        Figuras & Health

      </h2>
      <div class="carousel-wrap layout_padding2">
        <div class="owl-carousel">
          <div class="item">
            <div class="box">
              <div class="btn_container">
                <a href="">
                  Figuras
                </a>
              </div>
              <div class="img-box">
                <img src="images/p-1.jpg" alt="">
              </div>
              <div class="detail-box">
                <div class="star_container">
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star-o" aria-hidden="true"></i>

                </div>
                <div class="text">
                  <h6>
                    Health
                  </h6>
                  <h6 class="price">
                    <span>
                      $
                    </span>
                    30
                  </h6>
                </div>
              </div>
            </div>
            <div class="box">
              <div class="btn_container">
                <a href="">
                  Compra ahora
                </a>
              </div>
              <div class="img-box">
                <img src="images/p-5.jpg" alt="">
              </div>
              <div class="detail-box">
                <div class="star_container">
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star-o" aria-hidden="true"></i>

                </div>
                <div class="text">
                  <h6>
                    Health
                  </h6>
                  <h6 class="price">
                    <span>
                      $
                    </span>
                    30
                  </h6>
                </div>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="box">
              <div class="btn_container">
                <a href="">
                  Compra ahora
                </a>
              </div>
              <div class="img-box">
                <img src="images/p-2.jpg" alt="">
              </div>
              <div class="detail-box">
                <div class="star_container">
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star-o" aria-hidden="true"></i>

                </div>
                <div class="text">
                  <h6>
                    Health
                  </h6>
                  <h6 class="price">
                    <span>
                      $
                    </span>
                    30
                  </h6>
                </div>
              </div>
            </div>
            <div class="box">
              <div class="btn_container">
                <a href="">
                  Compra ahora
                </a>
              </div>
              <div class="img-box">
                <img src="images/p-5.jpg" alt="">
              </div>
              <div class="detail-box">
                <div class="star_container">
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star-o" aria-hidden="true"></i>

                </div>
                <div class="text">
                  <h6>
                    Health
                  </h6>
                  <h6 class="price">
                    <span>
                      $
                    </span>
                    30
                  </h6>
                </div>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="box">
              <div class="btn_container">
                <a href="">
                  Compra ahora
                </a>
              </div>
              <div class="img-box">
                <img src="images/p-3.jpg" alt="">
              </div>
              <div class="detail-box">
                <div class="star_container">
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star-o" aria-hidden="true"></i>

                </div>
                <div class="text">
                  <h6>
                    Health
                  </h6>
                  <h6 class="price">
                    <span>
                      $
                    </span>
                    30
                  </h6>
                </div>
              </div>
            </div>
            <div class="box">
              <div class="btn_container">
                <a href="">
                  Compra ahora
                </a>
              </div>
              <div class="img-box">
                <img src="images/p-5.jpg" alt="">
              </div>
              <div class="detail-box">
                <div class="star_container">
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star-o" aria-hidden="true"></i>

                </div>
                <div class="text">
                  <h6>
                    Health
                  </h6>
                  <h6 class="price">
                    <span>
                      $
                    </span>
                    30
                  </h6>
                </div>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="box">
              <div class="btn_container">
                <a href="">
                  Compra ahora
                </a>
              </div>
              <div class="img-box">
                <img src="images/p-4.jpg" alt="">
              </div>
              <div class="detail-box">
                <div class="star_container">
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star-o" aria-hidden="true"></i>

                </div>
                <div class="text">
                  <h6>
                    Health
                  </h6>
                  <h6 class="price">
                    <span>
                      $
                    </span>
                    30
                  </h6>
                </div>
              </div>
            </div>
            <div class="box">
              <div class="btn_container">
                <a href="">
                  Compra ahora
                </a>
              </div>
              <div class="img-box">
                <img src="images/p-5.jpg" alt="">
              </div>
              <div class="detail-box">
                <div class="star_container">
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star-o" aria-hidden="true"></i>

                </div>
                <div class="text">
                  <h6>
                    Health
                  </h6>
                  <h6 class="price">
                    <span>
                      $
                    </span>
                    30
                  </h6>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="health_carousel-container">
      <h2 class="text-uppercase">
        Vitamins & Supplements


      </h2>
      <div class="carousel-wrap layout_padding2">
        <div class="owl-carousel owl-2">
          <div class="item">
            <div class="box">
              <div class="btn_container">
                <a href="">
                  Compra ahora
                </a>
              </div>
              <div class="img-box">
                <img src="images/p-6.jpg" alt="">
              </div>
              <div class="detail-box">
                <div class="star_container">
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star-o" aria-hidden="true"></i>

                </div>
                <div class="text">
                  <h6>
                    Figuras
                  </h6>
                  <h6 class="price">
                    <span>
                      $
                    </span>
                    30
                  </h6>
                </div>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="box">
              <div class="btn_container">
                <a href="">
                  Compra ahora
                </a>
              </div>
              <div class="img-box">
                <img src="images/p-6.jpg" alt="">
              </div>
              <div class="detail-box">
                <div class="star_container">
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star-o" aria-hidden="true"></i>

                </div>
                <div class="text">
                  <h6>
                    Figuras
                  </h6>
                  <h6 class="price">
                    <span>
                      $
                    </span>
                    30
                  </h6>
                </div>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="box">
              <div class="btn_container">
                <a href="">
                  Compra ahora
                </a>
              </div>
              <div class="img-box">
                <img src="images/p-6.jpg" alt="">
              </div>
              <div class="detail-box">
                <div class="star_container">
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star-o" aria-hidden="true"></i>

                </div>
                <div class="text">
                  <h6>
                    Figuras
                  </h6>
                  <h6 class="price">
                    <span>
                      $
                    </span>
                    30
                  </h6>
                </div>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="box">
              <div class="btn_container">
                <a href="">
                  Compra ahora
                </a>
              </div>
              <div class="img-box">
                <img src="images/p-6.jpg" alt="">
              </div>
              <div class="detail-box">
                <div class="star_container">
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star" aria-hidden="true"></i>
                  <i class="fa fa-star-o" aria-hidden="true"></i>

                </div>
                <div class="text">
                  <h6>
                    Figuras
                  </h6>
                  <h6 class="price">
                    <span>
                      $
                    </span>
                    30
                  </h6>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="d-flex justify-content-center">
      <a href="">
        Ver más
      </a>
    </div>
  </section>

  <!-- end health section -->

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
          Dsitrito Otaku es una tienda online que se dedica a vender productos sobre anime.
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
                      <button type="submit" class="">Registrarse</butto>
                    </a>
                </div>
              </div>
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
</body>

</html>