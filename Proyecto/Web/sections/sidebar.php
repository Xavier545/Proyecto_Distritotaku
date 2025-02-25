<?php
$productosEnCesta = isset($_SESSION['cesta']) ? $_SESSION['cesta'] : [];
if(isset ($_REQUEST['product_id'], $_REQUEST['name'])){
    if(!isset ($_SESSION['carrito'])){
        $_SESSION['carrito'] = [];
    } 
    foreach($_SESSION['carrito'] as &$productos){
        if($productos['product_id'] == $_REQUEST['product_id']){
            $productos['cantidad']++;
            return;
        }
    }
    array_push($_SESSION['carrito'], ['product_id' => $_REQUEST['product_id'], 'name' => $_REQUEST['name'], 'cantidad' => 1]);
}

?>
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h3>Productos en la Cesta (Total: <?php echo count($productosEnCesta); ?>)</h3>
        <span class="close-btn" onclick="toggleSidebar()">&times;</span>
    </div>
    <div class="sidebar-body">
        <?php if (count($productosEnCesta) > 0): ?>
            <ul>
                <?php foreach ($$_SESSION['carrito'] as $products): ?>
                    <li><?php echo htmlspecialchars($products['nombre']); ?> - <?php echo $products['cantidad']; ?></li>
                <?php endforeach; ?>
                    


            </ul>
        <?php else: ?>
            <p>No hay productos en la cesta.</p>
        <?php endif; ?>
    </div>
</div>