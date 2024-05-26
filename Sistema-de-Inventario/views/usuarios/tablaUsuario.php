<?php
require "../../models/usuarioModel.php";
$objUsuario = new Usuario();

// Verificar si se recibieron datos del formulario al crear un usuario
if ($_POST) {
    // Obtener los valores enviados
    $nombre = $_POST['TXTnombre'];
    $apellido = $_POST['TXTapellido'];
    $email = $_POST['TXTEmail'];
    $dui = $_POST['TXTdui'];
    $contraseña = $_POST['TXTcontraseña'];
    $rol = $_POST['TXTrol'];
    
    // Verificar si la inserción fue exitosa
    if ($nombre != "" && $apellido != "" && $email != "" && $dui != "" && $contraseña != "" && $rol != "") {
        // Imprimir un script JavaScript que muestre el mensaje de alerta
        echo "<script>alert('Usuario Creado Exitosamente')</script>";
        $data = $objUsuario->crearUsuario($nombre, $apellido, $email, $dui, $contraseña, $rol);
    }
} else {
    // Si no se recibieron datos del formulario, no hacer nada
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../resources/src/Bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../resources/src/Bootstrap/css/lobibox.css">
    <link rel="stylesheet" href="../../resources/src/Bootstrap/css/select2.css">
    <link rel="stylesheet" href="../../resources/src/Bootstrap/css/datatables.css">
    <link rel="stylesheet" href="../../resources/src/Bootstrap/css/waitMe.css">
    <link href="../../resources/src/css/index.css" rel="stylesheet">
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
    </style>
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
        <a class="navbar-brand" href="#">Nombre del usuario</a>
        <a class="navbar-brand" href="../../index.php">Inicio</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
            <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="menuInicio">Menú</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                <li class="nav-item">
                <a href="#" id="loginBtn" class="nav-link">Iniciar Sesión</a>
                </li>
                
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Administración
                </a>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a class="dropdown-item" id="Usuarios" href="./views/usuarios/tablaUsuario.php">Usuarios</a></li>
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
                <a href="#" id="Compras" class="nav-link">Compras</a>
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
                <a href="#" id="configurarEmpresa" class="nav-link">Configurar Empresa</a>
                </li>
            </ul>
            </div>
        </div>
        </div>
    </nav>
    <br><br><br>
    <!-- Contenido -->
    <div class="container mt-4 bg-white rounded p-4 shadow">
        <div class="row">
            <div class="col-md-8">
                <h1>FORMULARIO PRUEBA</h1>
            </div>
            <div class="col-md-4 text-lg-center">
                <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#modal-agregar">
                    Agregar registro
                </button>
            </div>
        </div>
        <hr>
        <div class="table-responsive mt-5">
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
                    <!-- tu codigo php con los datos (for o foreach) -->
                    <?php
                    // Obtener los datos de los usuarios
                    $data=$objUsuario->obtenerUsuarios();
                    // Recorrer los datos y mostrarlos en la tabla
                    foreach( $data as $objUsuario){
                        echo"<tr>";
                        echo "<td>".$objUsuario["idUsuario"]."</td>";
                        echo "<td>".$objUsuario["Nombre"]."</td>";
                        echo "<td>".$objUsuario["Apellido"]."</td>";
                        echo "<td>".$objUsuario["Email"]."</td>";
                        echo "<td>".$objUsuario["DUI"]."</td>";
                        echo "<td>".$objUsuario["Rol"]."</td>";
                        $id = $objUsuario["idUsuario"];
                        echo "<td data-bs-toggle='modal' data-bs-target='#modal-editar' class='action-buttons'><button class='btn btn-warning btn-lg btn-spacing editar-btn'><a href='./viewModificarUsuario.php?id=$id'>Editar</a></button><button class='btn btn-danger btn-lg btn-spacing eliminar-btn' data-id='".$objUsuario["idUsuario"]."'>Eliminar</button></td>";
                        echo"</tr>";
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
                                <input type="text" class="form-control" name="TXTrol" id="Rol" placeholder="Rol" require>
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
</body>
</body>

<!-- Bootstrap JS and dependencies -->
<script src="../../resources/src/Bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5+5hb7O5PiA2d1W4cJ0eUO3qTAlye/vZn6vEx/j8" crossorigin="anonymous"></script>
<script src="../../resources/src/Bootstrap/js/waitMe.min.js"></script>
<script src="../../resources/src/Bootstrap/js/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="
    crossorigin="anonymous"></script>
<script src="../../resources/src/Bootstrap/js/bootstrap.min.js"></script>
<script src="../../resources/src/Bootstrap/js/popper.min.js"></script>
<script src="../../resources/src/Bootstrap/js/lobibox.js"></script>
<script src="../../resources/src/Bootstrap/js/notifications.js"></script>
<script src="../../resources/src/Bootstrap/js/messageboxes.js"></script>
<script src="../../resources/src/Bootstrap/js/datatables.min.js"></script>
<script src="../../resources/src/Bootstrap/js/datatables.js"></script>
<script src="../../resources/src/Bootstrap/js/select2.js"></script>
<script src="../../resources/src/Bootstrap/js/sweetalert.min.js"></script>
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
</script>
</html>
