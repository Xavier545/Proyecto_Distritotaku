<?php
include "sections/comprobacion_existencia_user.php";

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

// Obtener categorías desde la base de datos
$categoriesQuery = "SELECT id, name FROM CATEGORY";
$categoriesResult = $conn->query($categoriesQuery);

// Establecer categoría por defecto
$selectedCategoryId = $_GET['category_id'] ?? 1;

// Obtener productos de la base de datos según la categoría seleccionada
$products = [];
$sql = "SELECT * FROM PRODUCT WHERE category_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $selectedCategoryId);
$stmt->execute();
$result = $stmt->get_result();
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Función para obtener los productos en la cesta
function obtenerProductosEnCesta() {
    return isset($_SESSION['cesta']) ? $_SESSION['cesta'] : [];
}

// Inicializar la cesta si no existe
if (!isset($_SESSION['cesta'])) {
    $_SESSION['cesta'] = [];
}

$productosEnCesta = obtenerProductosEnCesta();
$cantidadTotalProductos = 0;

// Contar la cantidad total de productos en la cesta
foreach ($productosEnCesta as $producto) {
    $cantidadTotalProductos += $producto['cantidad']; // Asumiendo que 'cantidad' es un campo en el array del producto
}

// Incluir el sidebar después de definir la variable
include "sections/sidebar.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería de Productos</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.theme.default.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/owl.carousel.min.js"></script>
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
        .add-product-btn {
            background-color: red; /* Color de fondo rojo */
            color: white; /* Color del texto blanco */
            border: none; /* Sin borde */
            padding: 10px 20px; /* Espaciado interno */
            cursor: pointer; /* Cambiar el cursor al pasar el mouse */
            transition: background-color 0.3s; /* Transición suave */
        }
    </style>
</head>
<body>

<!-- Filtro de Categoría -->
<div class="container mt-5">
    <form method="GET" class="mb-3">
        <label for="category" class="form-label">Filtrar por Categoría:</label>
        <select name="category_id" id="category" class="form-select" onchange="this.form.submit()">
            <?php while ($category = $categoriesResult->fetch_assoc()): ?>
                <option value="<?php echo $category['id']; ?>" 
                    <?php if ($selectedCategoryId == $category['id']) echo "selected"; ?>>
                    <?php echo $category['name']; ?>
                </option>
            <?php endwhile; ?>
        </select>
    </form>
</div>

<!-- Sección de Productos -->
<section class="health_section layout_padding">
    <div class="health_carousel-container">
        <h2 class="text-uppercase">
            <?php
            // Mostrar el título según la categoría seleccionada
            $categoryTitleQuery = "SELECT name FROM CATEGORY WHERE id = ?";
            $stmt = $conn->prepare($categoryTitleQuery);
            $stmt->bind_param("i", $selectedCategoryId);
            $stmt->execute();
            $categoryResult = $stmt->get_result();
            $category = $categoryResult->fetch_assoc();
            echo htmlspecialchars($category['name']) . " & Precio";
            ?>
        </h2>
        <div class="carousel-wrap layout_padding2">
            <div class="owl-carousel">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="item">
                            <div class="box">
                                <div class="btn_container">
                                    <button class="add-product-btn" 
                                            data-id="<?php echo $product['id']; ?>" 
                                            data-nombre="<?php echo htmlspecialchars($product['name']); ?>">
                                        Añadir Producto
                                    </button>
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
                <?php else: ?>
                    <div class="item">
                        <h5>No hay productos disponibles en esta categoría.</h5>
                    </div>
                <?php endif; ?>
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

        // Manejar el evento de clic en el botón "Añadir Producto"
        $('.add-product-btn').on('click', function() {
            const productId = $(this).data('id');
            const productName = $(this).data('nombre');

            // Enviar la solicitud AJAX para añadir el producto a la cesta
            $.ajax({
                url: 'add_to_cart.php', // Archivo que manejará la adición a la cesta
                type: 'POST',
                data: {
                    product_id: productId,
                    nombre: productName
                },
                success: function(response) {
                    const result = JSON.parse(response); // Asegúrate de parsear la respuesta JSON
                    if (result.status === 'success') {
                        alert(result.message); // Mostrar mensaje de éxito
                    } else {
                        alert(result.message); // Mostrar mensaje de error
                    }
                },
                error: function() {
                    alert('Error al añadir el producto a la cesta.');
                }
            });
        });
    });
</script>

</body>
</html>