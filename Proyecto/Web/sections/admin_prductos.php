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

// Procesar la solicitud de añadir producto
if (isset($_POST['add_product'])) {
    // Aquí iría la lógica para añadir un producto
    // Asegúrate de validar y sanitizar los datos antes de insertarlos en la base de datos
}

// Procesar la solicitud de editar producto
if (isset($_POST['edit_product'])) {
    // Aquí iría la lógica para editar un producto
    // Asegúrate de validar y sanitizar los datos antes de actualizarlos en la base de datos
}

// Procesar la solicitud de eliminar producto
if (isset($_GET['delete_id'])) {
    // Aquí iría la lógica para eliminar un producto
    // Asegúrate de validar y sanitizar el ID antes de eliminarlo
}

// Cerrar la conexión
$conn->close();
?>