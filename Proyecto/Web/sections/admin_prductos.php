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