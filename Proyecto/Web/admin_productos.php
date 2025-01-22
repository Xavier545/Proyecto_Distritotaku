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

// Crear carpeta "uploads" si no existe
$upload_dir = "uploads/";
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
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
        $image_name = basename($_FILES['image']['name']);
        $target_file = $upload_dir . $image_name;

        // Validar tipo de archivo
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($_FILES['image']['type'], $allowed_types)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $image_url = $target_file;
            } else {
                $_SESSION['error'] = 'Error al cargar la imagen. Verifica los permisos del directorio.';
            }
        } else {
            $_SESSION['error'] = 'Formato de imagen no permitido. Usa JPEG, PNG o GIF.';
        }
    }

    // Insertar producto en la base de datos con la URL de la imagen
    if (!isset($_SESSION['error'])) {
        $sql = "INSERT INTO PRODUCT (name, category, price, stock, manufacturer, release_date, image_url) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdisss", $name, $category, $price, $stock, $manufacturer, $release_date, $image_url);

        if ($stmt->execute()) {
            $_SESSION['success'] = 'Producto añadido exitosamente.';
        } else {
            $_SESSION['error'] = 'Error al añadir producto: ' . $stmt->error;
        }

        $stmt->close();
    }

    // Redirigir para evitar reenvío del formulario
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Procesar eliminación de productos
if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) {
    $productId = intval($_GET['delete_id']);

    if ($productId > 0) {
        $sql = "DELETE FROM PRODUCT WHERE id = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Error al preparar la consulta: " . $conn->error);
        }

        $stmt->bind_param("i", $productId);
        if ($stmt->execute()) {
            $_SESSION['success'] = 'Producto eliminado exitosamente.';
        } else {
            $_SESSION['error'] = 'Error al ejecutar la consulta: ' . $stmt->error;
        }

        $stmt->close();
    }

    // Redirigir para evitar problemas de reenvío
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Procesar actualización de productos
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_product'])) {
    $id = intval($_POST['id']);
    $name = htmlspecialchars($_POST['name']);
    $category = htmlspecialchars($_POST['category']);
    $price = htmlspecialchars($_POST['price']);
    $stock = htmlspecialchars($_POST['stock']);
    $manufacturer = htmlspecialchars($_POST['manufacturer']);
    $release_date = htmlspecialchars($_POST['release_date']);

    $image_url = $_POST['existing_image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_name = basename($_FILES['image']['name']);
        $target_file = $upload_dir . $image_name;

        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($_FILES['image']['type'], $allowed_types)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $image_url = $target_file;
            } else {
                $_SESSION['error'] = 'Error al cargar la imagen.';
            }
        } else {
            $_SESSION['error'] = 'Formato de imagen no permitido.';
        }
    }

    if (!isset($_SESSION['error'])) {
        $sql = "UPDATE PRODUCT SET name=?, category=?, price=?, stock=?, manufacturer=?, release_date=?, image_url=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdisssi", $name, $category, $price, $stock, $manufacturer, $release_date, $image_url, $id);

        if ($stmt->execute()) {
            $_SESSION['success'] = 'Producto actualizado exitosamente.';
        } else {
            $_SESSION['error'] = 'Error al actualizar producto: ' . $stmt->error;
        }

        $stmt->close();
    }

    // Redirigir para evitar problemas de reenvío
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="hero_area">
    <!--header section strats -->
    <?php include "sections/header_admin.php";?>
    <!-- end header section -->
    
</div>
    <div class="container mt-5">
        <h2 class="mb-4">Panel de Administración de Productos</h2>

        <!-- Botón para abrir el modal de añadir producto -->
        <button class="btn btn-primary mb-3" type="button" data-bs-toggle="modal" data-bs-target="#addProductModal">
            Añadir Producto
        </button>

        <!-- Modal para añadir producto -->
        <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addProductModalLabel">Añadir Producto</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="name">Nombre</label>
                                <input type="text" class="form-control" name="name" id="name" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="category">Categoría</label>
                                <input type="text" class="form-control" name="category" id="category" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="price">Precio</label>
                                <input type="number" class="form-control" name="price" id="price" step="0.01" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="stock">Stock</label>
                                <input type="number" class="form-control" name="stock" id="stock" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="manufacturer">Fabricante</label>
                                <input type="text" class="form-control" name="manufacturer" id="manufacturer" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="release_date">Fecha de Lanzamiento</label>
                                <input type="date" class="form-control" name="release_date" id="release_date" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="image">Imagen del Producto</label>
                                <input type="file" class="form-control" name="image" id="image" accept="image/*">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" name="add_product" class="btn btn-primary">Guardar Producto</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal para editar producto -->
        <?php foreach ($products as $product): ?>
        <div class="modal fade" id="editProductModal<?php echo $product['id']; ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Editar Producto</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                            <input type="hidden" name="existing_image" value="<?php echo $product['image_url']; ?>">
                            <div class="form-group mb-3">
                                <label for="name">Nombre</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $product['name']; ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="category">Categoría</label>
                                <input type="text" class="form-control" name="category" value="<?php echo $product['category']; ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="price">Precio</label>
                                <input type="number" class="form-control" name="price" value="<?php echo $product['price']; ?>" step="0.01" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="stock">Stock</label>
                                <input type="number" class="form-control" name="stock" value="<?php echo $product['stock']; ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="manufacturer">Fabricante</label>
                                <input type="text" class="form-control" name="manufacturer" value="<?php echo $product['manufacturer']; ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="release_date">Fecha de Lanzamiento</label>
                                <input type="date" class="form-control" name="release_date" value="<?php echo $product['release_date']; ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="image">Imagen del Producto</label>
                                <input type="file" class="form-control" name="image" accept="image/*">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" name="edit_product" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php endforeach; ?>

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
                                <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" 
                                   data-bs-target="#editProductModal<?php echo $product['id']; ?>">Editar</a>
                                <a href="?delete_id=<?php echo $product['id']; ?>" class="btn btn-danger btn-sm" 
                                   onclick="return confirm('¿Estás seguro de eliminar este producto?')">Eliminar</a>
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
