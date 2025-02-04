<!-- header section strats -->
<header class="header_section">
<script src="js/carritoSideBar.js"></script>
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
                  <a class="nav-link" href="landing_page.php">Inicio <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="about.html"> Sobre </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="tienda.php"> Compra Online </a>
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
              <?php if (isset($_SESSION['nickname'])): ?>
              <a  class="ml-2" >
                    <img src="images/cart_icon.png" alt="Carrito"  style="width: 50px; height: 50px;">
              </a>
              <?php endif; ?>
              <div class="login_btn-contanier ml-0 ml-lg-5">
                <?php if (isset($_SESSION['nickname'])): ?>
                  <a href="user.php"><?php echo htmlspecialchars($_SESSION['nickname']); ?></a>
                <?php else: ?>
                  <a href="login.php">
                    <img src="images/user.png" alt="">
                    <span>
                      Login
                    </span>
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>

        </nav>
      </div>
      
</header>
<!-- end header section -->