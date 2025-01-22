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
                echo "<script>alert('Error al cargar la imagen. Verifica los permisos del directorio.');</script>";
            }
        } else {
            echo "<script>alert('Formato de imagen no permitido. Usa JPEG, PNG o GIF.');</script>";
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
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error al ejecutar la consulta: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    }
}

// Procesar edición de productos
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_product'])) {
    $id = htmlspecialchars($_POST['id']);
    $name = htmlspecialchars($_POST['name']);
    $category = htmlspecialchars($_POST['category']);
    $price = htmlspecialchars($_POST['price']);
    $stock = htmlspecialchars($_POST['stock']);
    $manufacturer = htmlspecialchars($_POST['manufacturer']);
    $release_date = htmlspecialchars($_POST['release_date']);

    // Actualizar producto
    $sql = "UPDATE PRODUCT SET name = ?, category = ?, price = ?, stock = ?, manufacturer = ?, release_date = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdissi", $name, $category, $price, $stock, $manufacturer, $release_date, $id);

    if ($stmt->execute()) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Error al actualizar producto: " . $stmt->error . "');</script>";
    }

    $stmt->close();
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

// Obtener datos del producto para editar
$edit_product = null;
if (isset($_GET['edit_id']) && is_numeric($_GET['edit_id'])) {
    $edit_id = intval($_GET['edit_id']);
    $sql = "SELECT * FROM PRODUCT WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_product = $result->fetch_assoc();
    $stmt->close();
}
?>