<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h3>Productos en la Cesta (Total: <?php echo count(obtenerProductosEnCesta()); ?>)</h3>
        <span class="close-btn" onclick="toggleSidebar()">&times;</span>
    </div>
    <div class="sidebar-body">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Nombre del Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $productosEnCesta = obtenerProductosEnCesta();
                if (count($productosEnCesta) > 0): 
                    foreach ($productosEnCesta as $product): 
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['nombre']); ?></td>
                        <td><?php echo $product['cantidad']; ?></td>
                        <td>€ <?php echo number_format($product['precio'], 2); ?></td>
                        <tr><td><form method="POST" class="add-to-cart-form" action="tienda.php">
                            <button type="sumbit" id="btnSuma" class="bg-success">+</button>
                            <button id="btnResta" class="bg-danger" >-</button>
                        </form>
                    </td>
                </tr>
                    </tr>
                <?php 
                    endforeach; 
                else: 
                ?>
                    <tr>
                        <td colspan="3">No hay productos en la cesta.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>  