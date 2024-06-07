<?php
session_start();
require "../../models/usuarioModel.php";
$objUsuario = new Usuario();

// Verificar si se ha solicitado la eliminación de un usuario
if (isset($_POST['delete_id'])) {
    $idUsuario = $_POST['delete_id'];
    echo "<script>
    window.onload = function() {
        Swal.fire({
            title: '¡Éxito!',
            text: 'Usuario eliminado exitosamente',
            icon: 'success'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = './tablaUsuario.php';
            }
        });
    };
    </script>";
    $objUsuario->eliminarUsuario($idUsuario);
}

// Verificar si se recibieron datos del formulario al crear un usuario
if ($_POST && isset($_POST['TXTnombre'], $_POST['TXTapellido'], $_POST['TXTEmail'], $_POST['TXTdui'], $_POST['TXTcontraseña'], $_POST['TXTrol'])) {
    $nombre = $_POST['TXTnombre'];
    $apellido = $_POST['TXTapellido'];
    $email = $_POST['TXTEmail'];
    $dui = $_POST['TXTdui'];
    $contraseña = $_POST['TXTcontraseña'];
    $rol = $_POST['TXTrol'];
    
    if ($nombre != "" && $apellido != "" && $email != "" && $dui != "" && $contraseña != "" && $rol != "") {
        // Muestra un mensaje de éxito al crear un usuario y redirige a la tabla de usuarios (caso en php)
        echo "<script>
            window.onload = function() {
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'Usuario creado exitosamente',
                    icon: 'success'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './tablaUsuario.php';
                    }
                });
            };
        </script>";
        $data = $objUsuario->crearUsuario($nombre, $apellido, $email, $dui, $contraseña, $rol);
    }else if ($nombre == "" || $apellido == "" || $email == "" || $dui == "" || $contraseña == "" || $rol == ""){
        // Muestra un mensaje de error al crear un usuario y redirige a la tabla de usuarios (caso en php)
        echo "<script>
            window.onload = function() {
                Swal.fire({
                    title: '¡Error al crear usuario!',
                    text: 'Debe de completar todos los campos!',
                    icon: 'error'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './tablaUsuario.php';
                    }
                });
            };
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Dependencias de bootstrap-->
    <script src="../../resources/src/Bootstrap/js/bootstrap.bundle.js"></script>
    <script src="../../resources/src/Bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../../resources/src/Bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../resources/src/Bootstrap/css/lobibox.css">
    <link rel="stylesheet" href="../../resources/src/Bootstrap/css/select2.css">
    <link rel="stylesheet" href="../../resources/src/Bootstrap/css/datatables.css">
    <link rel="stylesheet" href="../../resources/src/Bootstrap/css/waitMe.css">
    <!--Dependencias de SweetAlert-->
    <script src="../../resources/src/SweetAlert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="../../resources/src/SweetAlert/sweetalert2.min.css">
    <!--Dependencias de terceros-->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.6/css/all.css">
    <title>Usuarios</title>
    <style>
        .action-buttons {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .btn-spacing {
            margin: 0 5px; /* Ajusta el margen según tus necesidades */
        }
        /* Estilo para centrar el enlace de Inicio */
        .navbar-center {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }
    </style>
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand navbar-center" href="../../index.php">Inicio</a>
            <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="menuInicio">Menú</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <?php if (!isset($_SESSION['Nombre'])): ?>
                        <li class="nav-item">
                            <a href="#" id="loginBtn" class="nav-link">Iniciar Sesión</a>
                        </li>
                        <?php else: ?>
                        <li class="nav-item">
                            <a href="#" id="loginBtn" class="nav-link">Panel de Control</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Administración
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" id="Usuarios" href="../../views/usuarios/tablaUsuario.php">Usuarios</a></li>
                                <li><a class="dropdown-item" id="Categorias" href="#">Categorias</a></li>
                                <li><a class="dropdown-item" id="Sucursales" href="#">Sucursales</a></li>
                                <li><a class="dropdown-item" id="Proveedores" href="#">Proveedores</a></li>
                                <li><a class="dropdown-item" id="Clientes" href="#">Clientes</a></li>
                                <li>
                                <hr class="dropdown-divider">
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="../../views/compras/tablaCompras.php" id="Compras" class="nav-link">Compras</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" id="Productos" class="nav-link">Productos</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" id="Ventas" class="nav-link">Ventas</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" id="Entradas" class="nav-link">Entradas</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" id="Salidas" class="nav-link">Salidas</a>
                        </li>
                        <li class="nav-item">
                            <a href="../../views/modifEmpresa/viewModifEmpresa.php" id="configurarEmpresa" class="nav-link">Configurar Empresa</a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <?php if (isset($_SESSION['Nombre'])): ?>
            <div class="dropdown ms-auto">
                <a class="navbar-brand dropdown-toggle" href="#" id="usuarioDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo $_SESSION['Nombre']; ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="usuarioDropdown">
                    <li><a class="dropdown-item" href="#">Rol: <?php echo $_SESSION['Rol']; ?></a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="../../logout.php">Cerrar Sesión</a></li>
                </ul>
            </div>
            <?php endif; ?>
        </div>
    </nav>
    <br><br><br>

    <!-- Contenido -->
    <div class="container mt-4 bg-white rounded p-4 shadow">
        <div class="row">
            <div class="col-md-8">
                <h1>USUARIOS</h1>
            </div>
            <div class="col-md-4 text-lg-center">
                <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#modal-agregar">
                    Agregar registro
                </button>
            </div>
        </div>
        <hr>
        <div class="table-responsive mt-2">
            <table class="table table-bordered table-hover" id="tabla-datos">
                <thead class="bg-primary text-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>DUI</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    // Obtener todos los datos de los usuarios
                    $data = $objUsuario->obtenerUsuarios();
                    foreach ($data as $objUsuario) {
                        $id = $objUsuario["idUsuario"];
                        ?>
                        <tr>
                            <td><?php echo $objUsuario["idUsuario"]; ?></td>
                            <td><?php echo $objUsuario["Nombre"]; ?></td>
                            <td><?php echo $objUsuario["Apellido"]; ?></td>
                            <td><?php echo $objUsuario["Email"]; ?></td>
                            <td><?php echo $objUsuario["DUI"]; ?></td>
                            <td><?php echo $objUsuario["Rol"]; ?></td>
                            <td class="action-buttons">
                                <!-- Formulario para la acción de editar -->
                                <form action="./viewModificarUsuario.php" method="post" style="display:inline;">
                                    <input type="hidden" name="idUsuario" value="<?php echo $id; ?>">
                                    <button type="submit" class="btn btn-warning btn-lg btn-spacing editar-btn">Editar</button>
                                </form>
                                <?php echo"</button><button class='btn btn-danger btn-lg btn-spacing eliminar-btn' data-id='".$objUsuario["idUsuario"]."'>Eliminar</button>"?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal para agregar un usuario -->
    <div class="modal fade" id="modal-agregar" tabindex="-1" aria-labelledby="modal-agregar-label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-agregar-label">Formulario de registro de Usuarios</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="./tablaUsuario.php" method="POST">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="TXTnombre" id="Nombre" placeholder="Nombre" require>
                            </div><br><br>
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="TXTapellido" id="Apellido" placeholder="Apellido" require>
                            </div><br><br>
                            <div class="form-group col-md-6">
                                <input type="email" class="form-control" name="TXTEmail" id="Email" placeholder="example@gmail.com" require>
                            </div><br><br>
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="TXTdui" id="DUI" placeholder="DUI" require>
                            </div><br><br>
                            <div class="form-group col-md-6">
                                <input type="password" class="form-control" name="TXTcontraseña" id="Contraseña" placeholder="Contraseña" require>
                            </div><br><br>
                            <div class="form-group col-md-6">
                                <select class="form-control" name="TXTrol" id="rol" required>
                                    <option value="">Seleccione un Rol</option>
                                    <option value="Administrador">Administrador</option>
                                    <option value="Empleado">Empleado</option>
                                    <option value="Empleado">Cajero</option>
                                </select>
                            </div><br><br>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Formulario oculto para eliminar usuario -->
    <form id="delete-form" action="./tablaUsuario.php" method="POST" style="display: none;">
        <input type="hidden" name="delete_id" id="delete_id">
    </form>
</body>
</body>
</body>
</body>

<!-- Bootstrap JS and dependencies -->
<script src="../../resources/src/Bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../resources/src/Bootstrap/js/bootstrap.min.js"></script>
<script src="../../resources/src/Bootstrap/js/datatables.js"></script>
<script src="../../resources/src/Bootstrap/js/datatables.min.js"></script>
<script src="../../resources/src/Bootstrap/js/waitMe.min.js"></script>
<script src="../../resources/src/Bootstrap/js/jquery.min.js"></script>
<script src="../../resources/src/Bootstrap/js/popper.min.js"></script>
<script src="../../resources/src/Bootstrap/js/lobibox.js"></script>
<script src="../../resources/src/Bootstrap/js/notifications.js"></script>
<script src="../../resources/src/Bootstrap/js/messageboxes.js"></script>
<script src="../../resources/src/Bootstrap/js/select2.js"></script>
<script>
$(document).ready(function() {
    // Inicializa DataTable
    $("#tabla-datos").DataTable();
    // Maneja el clic en el botón "Agregar registro"
    $('.btn-primary').click(function() {
        // Aquí puedes agregar código adicional si necesitas hacer algo antes de abrir el modal
        $('#modal-agregar').modal('show');
    });
});

// Maneja el clic en el botón "Guardar"
$('#modal-agregar').on('hidden.bs.modal', function () {
    limpiarCampos();
});

// Función para limpiar los campos del formulario
function limpiarCampos() {
    document.getElementById("Nombre").value = "";
    document.getElementById("Apellido").value = "";
    document.getElementById("Email").value = "";
    document.getElementById("DUI").value = "";
    document.getElementById("Contraseña").value = "";
    document.getElementById("Rol").value = "";
}

// Maneja el clic en el botón "Eliminar"
$('.eliminar-btn').click(function() {
        var userId = $(this).data('id');
        // Muestra un mensaje de confirmación antes de eliminar el usuario (caso en js)
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#delete_id').val(userId);
                $('#delete-form').submit();
            }
        });
    });

$('.dropdown-toggle').click(function() {
    $(this).next('.dropdown-menu').toggleClass('show');
});

$(document).click(function (e) {
    var container = $(".dropdown");
    if (!container.is(e.target) && container.has(e.target).length === 0) {
        container.find('.dropdown-menu').removeClass('show');
    }
});
</script>
</html>
