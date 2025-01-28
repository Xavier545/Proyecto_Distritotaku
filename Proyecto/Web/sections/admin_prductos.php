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