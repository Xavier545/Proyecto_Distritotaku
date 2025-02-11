<?php

// Inicializar la cesta si no existe
if (!isset($_SESSION['cesta'])) {
    $_SESSION['cesta'] = [];
}

// Añadir producto a la cesta
if (isset($_POST['product_id']) && isset($_POST['nombre'])) {
    $productId = $_POST['product_id'];
    $nombre = $_POST['nombre'];
    $cantidad = 1; // Puedes ajustar esto si deseas permitir que el usuario elija la cantidad

    // Comprobar si el producto ya existe en la cesta
    $productoExistente = false;
    foreach ($_SESSION['cesta'] as &$producto) {
        if ($producto['id'] == $productId) {
            $producto['cantidad'] += $cantidad; // Aumentar la cantidad
            $productoExistente = true;
            break;
        }
    }

    // Si el producto no existe, añadirlo a la cesta
    if (!$productoExistente) {
        $productoNuevo = [
            'id' => $productId,
            'nombre' => $nombre,
            'cantidad' => $cantidad
        ];
        $_SESSION['cesta'][] = $productoNuevo;
    }

    // Responder con un mensaje de éxito
    echo json_encode(['status' => 'success', 'message' => 'Producto añadido a la cesta.']);
} else {
    // Responder con un mensaje de error
    echo json_encode(['status' => 'error', 'message' => 'Datos inválidos.']);
}
?>