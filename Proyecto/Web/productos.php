<?php
// Iniciar sesión
session_start();

// Incluir el archivo de conexión a la base de datos
include "sections/comprobacion_existencia_user.php"; // Asegúrate de que este archivo esté correcto

// Consulta las categorías desde la base de datos
$categoriesQuery = "SELECT id, name FROM CATEGORY";
$categoriesResult = $conn->query($categoriesQuery);

if (!$categoriesResult) {
    die("Error al consultar categorías: " . $conn->error);
}

// Establece categoría por defecto
$selectedCategoryId = $_GET['category_id'] ?? 1;

// Consulta los productos según la categoría seleccionada
$productsQuery = "SELECT PRODUCT.id, PRODUCT.name, CATEGORY.name AS category, PRODUCT.price 
                   FROM PRODUCT 
                   JOIN CATEGORY ON PRODUCT.category_id = CATEGORY.id
                   WHERE CATEGORY.id = ?";
$stmt = $conn->prepare($productsQuery);
$stmt->bind_param("i", $selectedCategoryId);
$stmt->execute();
$productsResult = $stmt->get_result();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
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
<div>
    <!--header section-->
    <?php include "sections/header.php"; ?>
</div>
<?php include "sections/productos.php"; ?>
<?php include "sections/footer.php"; ?>
<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script>
  <script src="js/carrusel1.js"></script>
  <script src="js/carrusel2.js"></script>
</body>
</html>

