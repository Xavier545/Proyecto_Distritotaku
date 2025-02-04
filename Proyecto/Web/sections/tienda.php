<?php
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

?>