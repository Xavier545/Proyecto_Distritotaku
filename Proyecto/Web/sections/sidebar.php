<?php

if(isset ($_REQUEST['product_id'], $_REQUEST['nombre'])){
    echo "HOLA";
     if(!isset ($_SESSION['carrito'])){
        $carrito = $_SESSION['carrito'] = [];
    };
    foreach($_SESSION['carrito'] as &$productos){
        if($productos['product_id'] == $_REQUEST['product_id']){
            $productos['cantidad']++;
            return;
        }
    }
    array_push($_SESSION['carrito'], ['product_id' => $_REQUEST['product_id'], 'nombre' => $_REQUEST['nombre'], 'cantidad' => 1]);
}
$productosEnCesta = obtenerProductosEnCesta();

?>
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h3>Productos en la Cesta (Total: <?php echo count($productosEnCesta); ?>)</h3>
        <span class="close-btn" onclick="toggleSidebar()">&times;</span>
    </div>
    <div class="sidebar-body">
        <?php if (count($productosEnCesta) > 0): ?>
            <ul>
                <?php foreach ($$_SESSION['carrito'] as $products):
                     echo "<li>" . htmlspecialchars($products['nombre']); $products['cantidad'] . "</li>";
                endforeach; ?>
                    


            </ul>
        <?php else: ?>
            <p>No hay productos en la cesta.</p>
        <?php endif; ?>
    </div>
</div>