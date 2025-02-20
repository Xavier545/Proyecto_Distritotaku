<?php 
session_start();

include "sections/admin_prductos.php";?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            display: none; /* Ocultar por defecto */
            width: 300px; /* Ancho del alert */
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const message = "<?php echo $message; ?>";
            if (message) {
                const alertBox = document.createElement("div");
                alertBox.className = "alert alert-success alert-dismissible fade show";
                alertBox.role = "alert";
                alertBox.innerHTML = message + 
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                document.body.appendChild(alertBox);
                alertBox.style.display = "block"; // Mostrar el alert
                setTimeout(() => {
                    alertBox.classList.remove("show");
                    setTimeout(() => alertBox.remove(), 150); // Eliminar después de que se desvanezca
                }, 3000); // Desaparecer después de 3 segundos
            }
        });
    </script>
</head>
<body>
<div>
    <!--header section starts -->
    <?php include "sections/header_admin.php"; ?>
    <!-- end header section -->
</div>
<div class="container mt-5">
    <h2 class="mb-4">Panel de Administración de Productos</h2>

    <!-- Botón para abrir el modal de añadir producto -->
    <button class="btn btn-primary mb-3" type="button" data-bs-toggle="modal" data-bs-target="#addProductModal">
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
                        <div class="form-group mb-3">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="category">Categoría</label>
                            <select id="category" name="category" class="form-select" required>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="price">Precio</label>
                            <input type="number" class="form-control" name="price" id="price" step="0.01" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="stock">Stock</label>
                            <input type="number" class="form-control" name="stock" id="stock" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="manufacturer">Fabricante</label>
                            <input type="text" class="form-control" name="manufacturer" id="manufacturer" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="release_date">Fecha de Lanzamiento</label>
                            <input type="date" class="form-control" name="release_date" id="release_date" required>
                        </div>
                        <div class="form-group mb-3">
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

    <!-- Modal para editar producto -->
    <?php foreach ($products as $product): ?>
    <div class="modal fade" id="editProductModal<?php echo $product['id']; ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="existing_image" value="<?php echo $product['image_url']; ?>">
                        <div class="form-group mb-3">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" name="name" value="<?php echo $product['name']; ?>" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="category">Categoría</label>
                            <select id="category" name="category" class="form-select" required>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category['id']; ?>" <?php echo ($category['id'] == $product['category_id']) ? 'selected' : ''; ?>>
                                        <?php echo $category['name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="price">Precio</label>
                            <input type="number" class="form-control" name="price" value="<?php echo $product['price']; ?>" step="0.01" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="stock">Stock</label>
                            <input type="number" class="form-control" name="stock" value="<?php echo $product['stock']; ?>" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="manufacturer">Fabricante</label>
                            <input type="text" class="form-control" name="manufacturer" value="<?php echo $product['manufacturer']; ?>" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="release_date">Fecha de Lanzamiento</label>
                            <input type="date" class="form-control" name="release_date" value="<?php echo $product['release_date']; ?>" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="image">Imagen del Producto</label>
                            <input type="file" class="form-control" name="image" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" name="edit_product" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php endforeach; ?>

    <h3>Lista de Productos</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Fabricante</th>
                <th>Fecha de Lanzamiento</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo $product['category_name']; ?></td>
                        <td><?php echo $product['price']; ?></td>
                        <td><?php echo $product['stock']; ?></td>
                        <td><?php echo $product['manufacturer']; ?></td>
                        <td><?php echo $product['release_date']; ?></td>
                        <td>
                            <?php if (!empty($product['image_url'])): ?>
                                <img src="<?php echo $product['image_url']; ?>" alt="Imagen del producto" width="100">
                            <?php else: ?>
                                No disponible
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" 
                               data-bs-target="#editProductModal<?php echo $product['id']; ?>">Editar</a>
                            <a href="?delete_id=<?php echo $product['id']; ?>" class="btn btn-danger btn-sm" 
                               onclick="return confirm('¿Estás seguro de eliminar este producto?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9">No hay productos registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>