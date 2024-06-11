<?php
session_start();
require "../../models/salida.php"; // Suponiendo que tienes un modelo para manejar las salidas
$objSalida = new Salidas();

//obtener el todos los productos 
$productos = $objSalida->obtenerTodosLosProductos();

//obtener el todos los clientes 
$clientes = $objSalida->obtenerClientes();

// Verificar si se recibieron datos del formulario al crear una salida
if ($_POST && isset($_POST['FechaSalida'], $_POST['idProducto'], $_POST['Motivo'], $_POST['Cantidad'])) {
    $FechaSalida = $_POST['FechaSalida'];
    $idProducto = $_POST['idProducto'];
    $motivo = $_POST['Motivo'];
    $cantidad = $_POST['Cantidad'];
    $idCliente = $_POST['idCliente'];

    if ($FechaSalida!= "" && $idProducto != "" && $motivo != "" && $cantidad != "" && $idCliente!= "") {
        // Muestra un mensaje de éxito al crear una salidas y redirige a la tabla de salidas
        echo "<script>
            window.onload = function() {
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'Salida creada exitosamente',
                    icon: 'success'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './tablaSalidas.php';
                    }
                });
            };
        </script>";
        $data = $objSalida->crearSalida($FechaSalida, $idProducto, $motivo, $cantidad, $idCliente);
    } else {
        // Muestra un mensaje de error al crear una salida y redirige a la tabla de salidas
        echo "<script>
            window.onload = function() {
                Swal.fire({
                    title: '¡Error al crear salida!',
                    text: 'Debe completar todos los campos obligatorios!',
                    icon: 'error'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './tablaSalidas.php';
                    }
                });
            };
        </script>";
    }
}
// Verificar si se ha solicitado la eliminación de una salida
if (isset($_POST['delete_id'])) {
    $idSalida = $_POST['delete_id'];
    echo "<script>
    window.onload = function() {
        Swal.fire({
            title: '¡Éxito!',
            text: 'Salida eliminada exitosamente',
            icon: 'success'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = './tablaSalidas.php';
            }
        });
    };
    </script>";
    $objSalida->eliminarSalida($idSalida);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Dependencias de bootstrap -->
    <script src="../../resources/src/Bootstrap/js/bootstrap.bundle.js"></script>
    <script src="../../resources/src/Bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../../resources/src/Bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../resources/src/Bootstrap/css/lobibox.css">
    <link rel="stylesheet" href="../../resources/src/Bootstrap/css/select2.css">
    <link rel="stylesheet" href="../../resources/src/Bootstrap/css/datatables.css">
    <link rel="stylesheet" href="../../resources/src/Bootstrap/css/waitMe.css">
    <!-- Dependencias de SweetAlert -->
    <script src="../../resources/src/SweetAlert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="../../resources/src/SweetAlert/sweetalert2.min.css">
    <!-- Dependencias de terceros -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.6/css/all.css">
    <title>Salidas</title>
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
                            <a href="../../views/entrada/viewModificarEntrada.php" id="Entradas" class="nav-link">Entradas</a>
                        </li>
                        <li class="nav-item">
                            <a href="../../views/salida/viewModificarSalida.php" id="Salidas" class="nav-link">Salidas</a>
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
                <h1>Salidas</h1>
            </div>
            <div class="col-md-4 text-lg-center">
                <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#modal-agregar">
                    Agregar registro
                </button>
            </div>
        </div>
        <hr>
        <div class="table-responsive mt-2">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Fecha de Salida</th>
                        <th>ID de producto</th>
                        <th>Motivo</th>
                        <th>Cantidad</th>
                        <th>ID Cliente</th>
                        <th></th>

                    </tr>
                </thead>
                <tbody class="text-center">
                <?php
                        // Obtener todos los datos de los proveedores
                        $data=$objSalida->obtenerSalidas();
                        // Recorrer cada dato que existe y mostrarlos en la tabla
                        foreach ($data as $objSalida) {
                            echo "<tr>";
                            echo "<td>".$objSalida["FechaSalida"]."</td>";
                            echo "<td>".$objSalida["NombreProducto"]."</td>";
                            echo "<td>".$objSalida["Motivo"]."</td>";
                            echo "<td>".$objSalida["Cantidad"]."</td>";
                            echo "<td>".$objSalida["NombreCliente"]."</td>";
                            $id = $objSalida["idSalida"];
                            echo "<td data-bs-toggle='modal' data-bs-target='#modal-editar' class='action-buttons'>
                            <button class='btn btn-warning btn-lg btn-spacing editar-btn'><a class='text-decoration-none text-dark' href='./viewModificarSalida.php?id=$id'>Editar</a>
                            </button><button class='btn btn-danger btn-lg btn-spacing eliminar-btn' data-id='".$objSalida["idSalida"]."'>Eliminar</button>
                            </td>";
                            echo"</tr>";
                        }
                        ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para agregar una salida -->
    <div class="modal fade" id="modal-agregar" tabindex="-1" aria-labelledby="modal-agregar-label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-agregar-label">Agregar Salida</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="./tablaSalidas.php" method="POST">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="FechaSalida">Fecha de Salida</label>
                                <input type="date" class="form-control" name="FechaSalida" id="FechaSalida" required>
                            </div><br><br>
                            <div class="form-group col-md-6">
                                <label for="idProducto">Producto</label>
                                <!--Agregar un select para seleccionar el producto-->
                                <select class="form-select" id="idProducto" name="idProducto" required>
                                        <option value="">Seleccionar Producto</option>
                                        <?php foreach ($productos as $producto): ?>
                                            <option value="<?php echo $producto['idProducto']; ?>">
                                                <?php echo $producto['NombreProducto']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                </select>
                            </div><br><br>
                            <div class="form-group col-md-6">
                                <label for="Motivo">Motivo</label>
                                <input type="text" class="form-control" name="Motivo" id="Motivo" placeholder="Motivo" required>
                            </div><br><br>
                            <div class="form-group col-md-6">
                                <label for="Cantidad">Cantidad</label>
                                <input type="number" class="form-control" name="Cantidad" id="Cantidad" placeholder="Cantidad" required>
                            </div><br><br>
                            <div class="form-group col-md-12">
                                <label for="idCliente">Cliente (Opcional)</label>
                                <!--Agregar un select para seleccionar el producto-->
                                <select class="form-select" id="idCliente" name="idCliente" required>
                                        <option value="">Seleccionar Proveedor</option>
                                        <?php foreach ($clientes as $cliente): ?>
                                            <option value="<?php echo $cliente['idCliente']; ?>">
                                                <?php echo $cliente['NombreCliente']; ?>
                                            </option>
                                        <?php endforeach; ?>
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

    <!-- Formulario oculto para enviar la solicitud de eliminación -->
    <form id="delete-form" method="POST" action="./tablaSalidas.php">
        <input type="hidden" name="delete_id" id="delete_id" value="">
    </form>

    <!-- Dependencias de JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>

    <!-- Inicializar DataTable -->
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

    // Función para limpiar los campos del formulario de proveedores
    function limpiarCamposSalidas() {
        document.getElementById("FechaSalida").value = "";
        document.getElementById("idProducto").value = "";
        document.getElementById("Motivo").value = "";
        document.getElementById("Cantidad").value = "";
        document.getElementById("idClienye").value = "";
    }

    // Maneja el clic en el botón "Eliminar"
    $('.eliminar-btn').click(function() {
            var idSalida = $(this).data('id');
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
                    $('#delete_id').val(idSalida);
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
</body>
</html>
