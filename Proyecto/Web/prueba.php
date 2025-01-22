<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <!-- Botón para abrir el modal de añadir producto -->
<button class="btn btn-secondary mb-3" type="button" data-bs-toggle="modal" data-bs-target="#addProductModal">
    Añadir Producto
</button>

<!-- Modal para añadir producto -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Añadir Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="category">Categoría</label>
                        <input type="text" class="form-control" name="category" id="category" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Precio</label>
                        <input type="number" class="form-control" name="price" id="price" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="stock">Stock</label>
                        <input type="number" class="form-control" name="stock" id="stock" required>
                    </div>
                    <div class="form-group">
                        <label for="manufacturer">Fabricante</label>
                        <input type="text" class="form-control" name="manufacturer" id="manufacturer" required>
                    </div>
                    <div class="form-group">
                        <label for="release_date">Fecha de Lanzamiento</label>
                        <input type="date" class="form-control" name="release_date" id="release_date" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Imagen del Producto</label>
                        <input type="file" class="form-control" name="image" id="image" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" name="add_product" class="btn btn-primary">Guardar Producto</button>
                </div>
            </div>
        </form>
    </div>
</div>

</body>
</html>