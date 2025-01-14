<?php

// Conexión a la base de datos
$servername = "db";
$username = "mysql";
$password = "mysecret";
$dbname = "mydb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener productos de la base de datos
$products = [];
$sql = "SELECT * FROM PRODUCT";
$result = $conn->query($sql);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería de Productos</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="path/to/owl.carousel.min.css"> <!-- Asegúrate de incluir la hoja de estilos de Owl Carousel -->
    <link rel="stylesheet" href="path/to/owl.theme.default.min.css"> <!-- Si quieres usar el tema predeterminado de Owl Carousel -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="path/to/owl.carousel.min.js"></script> <!-- Asegúrate de incluir el JS de Owl Carousel -->
    <style>
        .product-img {
            width: 250px;
            height: 250px;
            object-fit: cover;
            margin: 10px;
        }
        .product-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
    </style>
</head>
<body>

<section class="health_section layout_padding">
    <div class="health_carousel-container">
        <h2 class="text-uppercase">
            Figuras & Precio
        </h2>
        <div class="carousel-wrap layout_padding2">
            <div class="owl-carousel">
                <?php foreach ($products as $product): ?>
                    <div class="item">
                        <div class="box">
                            <div class="btn_container">
                                <a href="#">
                                    Comprar ahora
                                </a>
                            </div>
                            <div class="img-box">
                                <?php if (!empty($product['image_url'])): ?>
                                    <img src="<?php echo $product['image_url']; ?>" alt="Imagen de <?php echo htmlspecialchars($product['name']); ?>" class="product-img">
                                <?php else: ?>
                                    <img src="default-image.jpg" alt="Imagen no disponible" class="product-img">
                                <?php endif; ?>
                            </div>
                            <div class="detail-box">
                                <div class="star_container">
                                    <!-- Estrellas dinámicas, agregar lógica de valoraciones si es necesario -->
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                </div>
                                <div class="text">
                                    <h6>Precio</h6>
                                    <h6 class="price">
                                        <span>€</span>
                                        <?php echo number_format($product['price'], 2); ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        <a href="#">Ver más</a>
    </div>
</section>

<script>
    // Inicia Owl Carousel
    $(document).ready(function(){
        $(".owl-carousel").owlCarousel({
            items: 4,  // Puedes ajustar el número de items visibles
            loop: true,
            margin: 10,
            autoplay: true,
            autoplayTimeout: 5000,  // Intervalo entre imágenes
            nav: true,  // Mostrar los controles de navegación
            dots: true   // Mostrar puntos de navegación
        });
    });
</script>

</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>
