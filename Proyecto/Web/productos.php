<?php 
// Iniciar sesión
session_start();
include "sections/comprobacion_existencia_user.php";

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

<div class="container mt-5">
    <h2 class="mb-4">Listado de Productos</h2>

    <!-- Filtro de Categoría -->
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

    <!-- Tabla de Productos -->
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Precio</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($productsResult->num_rows > 0): ?>
            <?php while ($product = $productsResult->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $product['category']; ?></td>
                    <td><?php echo "$" . number_format($product['price'], 2); ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">No hay productos disponibles en esta categoría.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include "sections/footer.php"; ?>

</body>
</html>

