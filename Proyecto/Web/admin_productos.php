<?php
session_start();

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

// Procesar el formulario para añadir productos
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $name = htmlspecialchars($_POST['name']);
    $category = htmlspecialchars($_POST['category']);
    $price = htmlspecialchars($_POST['price']);
    $stock = htmlspecialchars($_POST['stock']);
    $manufacturer = htmlspecialchars($_POST['manufacturer']);
    $release_date = htmlspecialchars($_POST['release_date']);

    // Manejar la carga de la imagen
    $image_url = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // Ruta de destino para guardar la imagen
        $upload_dir = "uploads/";
        $image_name = basename($_FILES['image']['name']);
        $target_file = $upload_dir . $image_name;

        // Comprobar si la imagen se sube correctamente
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_url = $target_file;
        } else {
            echo "<script>alert('Error al cargar la imagen.');</script>";
        }
    }

    // Insertar producto en la base de datos con la URL de la imagen
    $sql = "INSERT INTO PRODUCT (name, category, price, stock, manufacturer, release_date, image_url) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdisss", $name, $category, $price, $stock, $manufacturer, $release_date, $image_url);

    if ($stmt->execute()) {
        echo "<script>alert('Producto añadido exitosamente');</script>";
    } else {
        echo "<script>alert('Error al añadir producto: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

// Manejar la eliminación de productos
if (isset($_GET['id']) && isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    $productId = intval($_GET['id']);  // Obtenemos el ID del producto a eliminar

    // Verificar si el ID del producto es válido
    if ($productId > 0) {
        $sql = "DELETE FROM PRODUCT WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $productId);

        if ($stmt->execute()) {
            echo "<script>alert('Producto eliminado exitosamente.');</script>";
            // Redirigir a la misma página para actualizar la lista de productos
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error al eliminar producto: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    }
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
    <title>Administración de Productos</title>
    <link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>
    <div class="container">
        <h2>Panel de Administración de Productos</h2>

        <h3>Añadir Producto</h3>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="category">Categoría</label>
                <input type="text" class="form-control" name="category" id="category" required>
            </div>
            <div class="form-group">
                <label for="price">Precio</label>
                <input type="number" class="form-control" name="price" id="price" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" class="form-control" name="stock" id="stock" required>
            </div>
            <div class="form-group">
                <label for="manufacturer">Fabricante</label>
                <input type="text" class="form-control" name="manufacturer" id="manufacturer" required>
            </div>
            <div class="form-group">
                <label for="release_date">Fecha de Lanzamiento</label>
                <input type="date" class="form-control" name="release_date" id="release_date" required>
            </div>
            <div class="form-group">
                <label for="image">Imagen del Producto</label>
                <input type="file" class="form-control" name="image" id="image" accept="image/*">
            </div>
            <button type="submit" name="add_product" class="btn btn-primary">Añadir Producto</button>
        </form>

        <h3>Lista de Productos</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Fabricante</th>
                    <th>Fecha de Lanzamiento</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo $product['id']; ?></td>
                            <td><?php echo $product['name']; ?></td>
                            <td><?php echo $product['category']; ?></td>
                            <td><?php echo $product['price']; ?></td>
                            <td><?php echo $product['stock']; ?></td>
                            <td><?php echo $product['manufacturer']; ?></td>
                            <td><?php echo $product['release_date']; ?></td>
                            <td>
                                <?php if (!empty($product['image_url'])): ?>
                                    <img src="<?php echo $product['image_url']; ?>" alt="Imagen del producto" width="100">
                                <?php else: ?>
                                    No disponible
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="?id=<?php echo $product['id']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?');" class="btn btn-danger btn-sm">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9">No hay productos registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>
