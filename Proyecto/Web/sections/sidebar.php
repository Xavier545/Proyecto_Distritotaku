<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h3>Productos en la Cesta</h3>
        <span class="close-btn" onclick="toggleSidebar()">&times;</span>
    </div>
    <div class="sidebar-body">
        <?php if (count($productosEnCesta) > 0): ?>
            <ul>
                <?php foreach ($productosEnCesta as $producto): ?>
                    <li><?php echo $producto['nombre']; ?> - <?php echo $producto['cantidad']; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No hay productos en la cesta.</p>
        <?php endif; ?>
    </div>
</div>