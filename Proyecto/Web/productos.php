<?php 
include "sections/comprobacion_existencia_user.php";

// Simulación de datos de productos
$products = [
  ["id" => 1, "name" => "Figura Naruto", "category" => "Figura Anime", "price" => 50],
  ["id" => 2, "name" => "Camiseta One Piece", "category" => "Camiseta", "price" => 20],
  ["id" => 3, "name" => "Figura Goku", "category" => "Figura Anime", "price" => 60],
  ["id" => 4, "name" => "Camiseta Attack on Titan", "category" => "Camiseta", "price" => 25]
];

// Manejar filtro por categoría
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : 'Figura Anime';
$filteredProducts = array_filter($products, fn($product) => $product['category'] === $selectedCategory);
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
    <!--header section strats -->
    <?php include "sections/header.php";?>
    <?php include "sections/productos.php";?>
</div>
<div class="container mt-5">
    <h2 class="mb-4">Listado de Productos</h2>

    <!-- Filtro de Categoría -->
    <form method="GET" class="mb-3">
        <label for="category" class="form-label">Filtrar por Categoría:</label>
        <select name="category" id="category" class="form-select" onchange="this.form.submit()">
            <option value="Figura Anime" <?php if ($selectedCategory === "Figura Anime") echo "selected"; ?>>Figuras de Anime</option>
            <option value="Camiseta" <?php if ($selectedCategory === "Camiseta") echo "selected"; ?>>Camisetas</option>
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
        <?php if (!empty($filteredProducts)): ?>
            <?php foreach ($filteredProducts as $product): ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $product['category']; ?></td>
                    <td><?php echo "$" . number_format($product['price'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
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
