<?php
include "sections/admin.php"
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro y Administración</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</head>
<body>
<div>
    <!--header section strats -->
    <?php include "sections/header_admin.php";?>
    <!-- end header section -->
    
</div>
    <div class="container">
        <!-- Formulario de inicio de sesión -->
        <h2>Iniciar Sesión como Administrador</h2>
        <?php if (isset($login_error)): ?>
            <div class="alert alert-danger"><?php echo $login_error; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Usuario</label>
                <input type="text" class="form-control" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <button type="submit" name="admin_login" class="btn btn-primary">Iniciar Sesión</button>
        </form>

        <!-- Opciones de administración -->
        <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
            <h2 class="mt-5">Opciones de Administración</h2>

            <!-- Botón para mostrar el formulario de registro en un popup -->
            <button class="btn btn-secondary mb-3" type="button" data-bs-toggle="modal" data-bs-target="#registerModal">
                Registrar Usuario
            </button>

            <!-- Modal para registro de usuario -->
            <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST" action="">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="registerModalLabel">Registrar Usuario</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="firstname">Nombre</label>
                                    <input type="text" class="form-control" name="firstname" required>
                                </div>
                                <div class="form-group">
                                    <label for="lastname">Apellido</label>
                                    <input type="text" class="form-control" name="lastname" required>
                                </div>
                                <div class="form-group">
                                    <label for="nickname">Nickname</label>
                                    <input type="text" class="form-control" name="nickname" required>
                                </div>
                                <div class="form-group">
                                    <label for="pw">Contraseña</label>
                                    <input type="password" class="form-control" name="pw" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="direccion">Dirección</label>
                                    <input type="text" class="form-control" name="direccion" required>
                                </div>
                                <div class="form-group">
                                    <label for="ciudad">Ciudad</label>
                                    <input type="text" class="form-control" name="ciudad" required>
                                </div>
                                <div class="form-group">
                                    <label for="codigoPostal">Código Postal</label>
                                    <input type="text" class="form-control" name="codigoPostal" required>
                                </div>
                                <div class="form-group">
                                    <label for="date">Fecha de Nacimiento</label>
                                    <input type="date" class="form-control" name="date" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" name="register" class="btn btn-primary">Registrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <h2 class="mt-5">Usuarios Registrados</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Nickname</th>
                        <th>Email</th>
                        <th>Dirección</th>
                        <th>Ciudad</th>
                        <th>Código Postal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo $user['id']; ?></td>
                                <td><?php echo $user['firstname']; ?></td>
                                <td><?php echo $user['lastname']; ?></td>
                                <td><?php echo $user['nickname']; ?></td>
                                <td><?php echo $user['email']; ?></td>
                                <td><?php echo $user['address']; ?></td>
                                <td><?php echo $user['city']; ?></td>
                                <td><?php echo $user['postal_code']; ?></td>
                                <td>
                                    <a href="?delete&id=<?php echo $user['id']; ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">Eliminar</a>
                                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $user['id']; ?>">Editar</button>

                                    <!-- Modal para editar usuario -->
                                    <div class="modal fade" id="editModal<?php echo $user['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo $user['id']; ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form method="POST" action="">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel<?php echo $user['id']; ?>">Editar Usuario</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                                        <div class="form-group">
                                                            <label for="firstname">Nombre</label>
                                                            <input type="text" class="form-control" name="firstname" value="<?php echo $user['firstname']; ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="lastname">Apellido</label>
                                                            <input type="text" class="form-control" name="lastname" value="<?php echo $user['lastname']; ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="nickname">Nickname</label>
                                                            <input type="text" class="form-control" name="nickname" value="<?php echo $user['nickname']; ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">Email</label>
                                                            <input type="email" class="form-control" name="email" value="<?php echo $user['email']; ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="address">Dirección</label>
                                                            <input type="text" class="form-control" name="address" value="<?php echo $user['address']; ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="city">Ciudad</label>
                                                            <input type="text" class="form-control" name="city" value="<?php echo $user['city']; ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="postal_code">Código Postal</label>
                                                            <input type="text" class="form-control" name="postal_code" value="<?php echo $user['postal_code']; ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="new_pw">Nueva Contraseña</label>
                                                            <input type="password" class="form-control" name="new_pw">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                        <button type="submit" name="update_user" class="btn btn-primary">Guardar Cambios</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>


