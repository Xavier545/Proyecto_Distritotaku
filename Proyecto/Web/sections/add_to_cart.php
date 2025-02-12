<?php
session_start();

// Verificar si se ha enviado el ID del producto
if (isset($_POST['product_id']) && isset($_POST['nombre'])) {
    $productId = $_POST['product_id'];
    $productName = $_POST['nombre'];

    // Inicializar la cesta si no existe
    if (!isset($_SESSION['cesta'])) {
        $_SESSION['cesta'] = [];
    }

    // Comprobar si el producto ya está en la cesta
    $found = false;
    foreach ($_SESSION['cesta'] as &$producto) {
        if ($producto['id'] == $productId) {
            $producto['cantidad']++; // Incrementar la cantidad
            $found = true;
            break;
        }
    }

    // Si el producto no está en la cesta, añadirlo
    if (!$found) {
        $_SESSION['cesta'][] = [
            'id' => $productId,
            'nombre' => $productName,
            'cantidad' => 1
        ];
    }

    // Respuesta de éxito
    echo json_encode(['status' => 'success', 'message' => 'Producto añadido a la cesta.']);
} else {
    // Respuesta de error
    echo json_encode(['status' => 'error', 'message' => 'Error al añadir el producto.']);
}
?>