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

// Obtener las categorías de la base de datos
$query = "SELECT * FROM CATEGORY";
$result = $conn->query($query);
$categories = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

// Obtener productos con sus categorías
$query = "SELECT p.*, c.name AS category_name FROM PRODUCT p
          JOIN CATEGORY c ON p.category_id = c.id";
$result = $conn->query($query);
$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Mensaje de confirmación
$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Limpiar el mensaje después de mostrarlo
}

// Procesar la solicitud de añadir producto
if (isset($_POST['add_product'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $category_id = (int)$_POST['category'];
    $price = (float)$_POST['price'];
    $stock = (int)$_POST['stock'];
    $manufacturer = $conn->real_escape_string($_POST['manufacturer']);
    $release_date = $conn->real_escape_string($_POST['release_date']);
    
    // Manejo de la imagen
    $image_url = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $image_url = $target_file;
    }

    $query = "INSERT INTO PRODUCT (name, category_id, price, stock, manufacturer, release_date, image_url) 
              VALUES ('$name', $category_id, $price, $stock, '$manufacturer', '$release_date', '$image_url')";
    
    if ($conn->query($query) === TRUE) {
        $_SESSION['message'] = "Producto añadido exitosamente.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Procesar la solicitud de editar producto
if (isset($_POST['edit_product'])) {
    $id = (int)$_POST['id'];
    $name = $conn->real_escape_string($_POST['name']);
    $category_id = (int)$_POST['category'];
    $price = (float)$_POST['price'];
    $stock = (int)$_POST['stock'];
    $manufacturer = $conn->real_escape_string($_POST['manufacturer']);
    $release_date = $conn->real_escape_string($_POST['release_date']);
    $existing_image = $conn->real_escape_string($_POST['existing_image']);
    
    // Manejo de la imagen
    $image_url = $existing_image; // Mantener la imagen existente por defecto
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $image_url = $target_file; // Actualizar la imagen si se subió una nueva
    }

    $query = "UPDATE PRODUCT SET 
              name='$name', 
              category_id=$category_id, 
              price=$price, 
              stock=$stock, 
              manufacturer='$manufacturer', 
              release_date='$release_date', 
              image_url='$image_url' 
              WHERE id=$id";
    
    if ($conn->query($query) === TRUE) {
        $_SESSION['message'] = "Producto editado exitosamente.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Procesar la solicitud de eliminar producto
if (isset($_GET['delete_id'])) {
    $id = (int)$_GET['delete_id'];
    
    // Eliminar el producto
    $query = "DELETE FROM PRODUCT WHERE id=$id";
    
    if ($conn->query($query) === TRUE) {
        $_SESSION['message'] = "Producto eliminado exitosamente.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            display: none; /* Ocultar por defecto */
            width: 300px; /* Ancho del alert */
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const message = "<?php echo $message; ?>";
            if (message) {
                const alertBox = document.createElement("div");
                alertBox.className = "alert alert-success alert-dismissible fade show";
                alertBox.role = "alert";
                alertBox.innerHTML = message + 
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                document.body.appendChild(alertBox);
                alertBox.style.display = "block"; // Mostrar el alert
                setTimeout(() => {
                    alertBox.classList.remove("show");
                    setTimeout(() => alertBox.remove(), 150); // Eliminar después de que se desvanezca
                }, 3000); // Desaparecer después de 3 segundos
            }
        });
    </script>
</head>
<body>
<div>
    <!--header section starts -->
    <?php include "sections/header_admin.php"; ?>
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
                            <select id="category" name="category" class="form-select" required>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
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
                            <select id="category" name="category" class="form-select" required>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category['id']; ?>" <?php echo ($category['id'] == $product['category_id']) ? 'selected' : ''; ?>>
                                        <?php echo $category['name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
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
                        <td><?php echo $product['category_name']; ?></td>
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