<?php
session_start();
require '../../models/ventasModel.php';
$objVenta = new Ventas();
$conn = conectar();

// obtener lista de ventas
$resultVentas = $objVenta->obtenerVentas();

if ($resultVentas) {
    $ventas = [];
    while ($row = $resultVentas->fetch_assoc()) {
        $ventas[] = $row;
    }
} else {
    echo "Error al obtener ventas: " . $conn->error;
}

//obtener lista de clientes
$sqlClientes = "CALL obtenerClientes();";
$resultClientes = $conn->query($sqlClientes);

if ($resultClientes) {
    $clientes = [];
    while ($row = $resultClientes->fetch_assoc()) {
        $clientes[] = $row;
    }
    // Libera el búfer de resultados
    $resultClientes->free();
    $conn->next_result();
} else {
    echo "Error al obtener clientes: " . $conn->error;
}

// Logica para agregar una venta y esta comenzara cuando el formulario sea enviado
if ($_POST && isset($_POST['FechaVenta'], $_POST['Cliente'])){
    //Obtener datos del formulario
    $FechaVenta = $_POST['FechaVenta'];
    $idCliente = $_POST['Cliente'];

    
    if ($FechaVenta != "" && $idCliente != "") {
        $objVenta->crearVenta($FechaVenta, $idCliente);
        echo "<script>
        window.onload = function() {
            Swal.fire({
                title: '¡Éxito!',
                text: 'Venta creada exitosamente',
                icon: 'success'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = './tablaVentas.php';
                }
            });
        };
        </script>";
    } else {
        echo "<script>
        window.onload = function() {
            Swal.fire({
                title: '¡Error!',
                text: 'Error al crear la venta',
                icon: 'error'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = './tablaVentas.php';
                }
            });
        };
        </script>";
    }

}

// Verificar si se ha solicitado la eliminación de una compra
if (isset($_POST['delete_id'])) {
    $idVenta = $_POST['delete_id'];
    $objVenta->eliminarVenta($idVenta);
    echo "<script>
    window.onload = function() {
        Swal.fire({
            title: '¡Éxito!',
            text: 'Venta eliminada exitosamente',
            icon: 'success'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = './tablaVentas.php';
            }
        });
    };
    </script>";
}

// Verificar si se ha solicitado la edicion de una venta

if ($_POST && isset($_POST['edit_id'], $_POST['FechaVentaEdit'], $_POST['ClienteEdit'])) {
    $idVentaEdit = $_POST['edit_id'];
    $fechaVentaEdit = $_POST['FechaVentaEdit'];
    $clienteEdit = $_POST['ClienteEdit'];
    
    // Validar los datos
    if ($fechaVentaEdit != "" && $clienteEdit != "") {
        $result = $objVenta->actualizarVenta($idVentaEdit, $fechaVentaEdit, $clienteEdit);
        if ($result) {
            echo "<script>
            window.onload = function() {
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'Venta editada exitosamente',
                    icon: 'success'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './tablaVentas.php';
                    }
                });
            };
            </script>";
        } else {
            echo "<script>
            window.onload = function() {
                Swal.fire({
                    title: '¡Error!',
                    text: 'Error al editar la venta',
                    icon: 'error'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './tablaVentas.php';
                    }
                });
            };
            </script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas</title>
    <!-- Dependencias de Bootstrap -->
    <link rel="stylesheet" href="../../resources/src/Bootstrap/css/bootstrap.min.css">
    <!-- Dependencias de SweetAlert -->
    <link rel="stylesheet" href="../../resources/src/SweetAlert/sweetalert2.min.css">
    <style>
        .action-buttons {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .btn-spacing {
            margin: 0 5px;
        }
        .navbar-center {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand navbar-center" href="../../index.php">Inicio</a>
            <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar"
                aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="menuInicio">Menú</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <?php if (!isset($_SESSION['Nombre'])): ?>
                        <li class="nav-item">
                            <a href="#" id="loginBtn" class="nav-link">Iniciar Sesión</a>
                        </li>
                        <?php else: ?>
                        <li class="nav-item">
                            <a href="../../views/panelControl/panelControl.php" id="loginBtn" class="nav-link">Panel de Control</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Administración
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" id="Usuarios" href="../../views/usuarios/tablaUsuario.php">Usuarios</a></li>
                                <li><a class="dropdown-item" id="Categorias" href="#">Categorias</a></li>
                                <li><a class="dropdown-item" id="Sucursales" href="#">Sucursales</a></li>
                                <li><a class="dropdown-item" id="Proveedores" href="../../views/Proveedores/tablaProveedor.php">Proveedores</a></li>
                                <li><a class="dropdown-item" id="Clientes" href="../../views/Clientes/tablaCliente.php">Clientes</a></li>
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
                            <a href="../../views/ventas/tablaVentas.php" id="Ventas" class="nav-link">Ventas</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" id="Entradas" class="nav-link">Entradas</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" id="Salidas" class="nav-link">Salidas</a>
                        </li>
                        <li class="nav-item">
                            <a href="../../views/modifEmpresa/viewModifEmpresa.php?" id="configurarEmpresa" class="nav-link">Configurar Empresa</a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <?php if (isset($_SESSION['Nombre'])): ?>
            <div class="dropdown ms-auto">
                <a class="navbar-brand dropdown-toggle" href="#" id="usuarioDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo $_SESSION['Nombre']; ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="usuarioDropdown">
                    <li><a class="dropdown-item" href="#">Rol: <?php echo $_SESSION['Rol']; ?></a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
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
                <h1>VENTAS</h1>
            </div>
            <div class="col-md-4 text-lg-center">
                <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#Modal-CrearVenta">
                    Agregar Venta
                </button>
            </div>
        </div>
        <hr>
        <div class="table-responsive mt-2">
            <table class="table table-bordered table-hover" id="tabla-datos">
                <thead class="bg-primary text-light">
                    <tr>
                        <th>ID</th>
                        <th>Fecha de Venta</th>
                        <th>Cliente</th>
                        <th>Total Venta</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <!-- Logica para obtener los datos de la tabla ventas -->
                <tbody>
                    <?php foreach ($ventas as $venta): ?>
                    <tr>
                        <td><?php echo $venta['idVenta']; ?></td>
                        <td><?php echo $venta['FechaVenta']; ?></td>
                        <td><?php echo $venta['NombreCliente']; ?></td>
                        <td><?php echo "$".$venta['TotalVenta']; ?></td>
                        <td class="action-buttons">
                            <form action="./tablaDetalleVentas-create.php" method="post" style="display:inline;">
                                <input type="hidden" name="idVenta" value="<?php echo $venta['idVenta']; ?>">
                                <button type="submit" class="btn btn-success btn-sm btn-spacing">Productos</button>
                            </form>
                            <!--Obtener un cliente en especifico-->
                            <?php
                            $nombreCliente = $venta['NombreCliente'];
                            $sqlCliente = "CALL obtenerClienteFiltro('','$nombreCliente','','');";
                            $resultCliente = $conn->query($sqlCliente);

                            if ($resultCliente) {
                                $cliente = [];
                                while ($row = $resultCliente->fetch_assoc()) {
                                    $cliente[] = $row;
                                }
                                // Libera el búfer de resultados
                                $resultCliente->free();
                                $conn->next_result();
                            } else {
                                echo "Error al obtener cliente: " . $conn->error;
                            }

                            //obtener una venta en especifico
                            $idVenta = $venta['idVenta'];
                            $sqlVentaFiltro = "CALL obtenerVentaFiltro('$idVenta','','');";
                            $resultVentaFiltro = $conn->query($sqlVentaFiltro);

                            if ($resultVentaFiltro) {
                                $VentaFiltro = [];
                                while ($row = $resultVentaFiltro->fetch_assoc()) {
                                    $VentaFiltro[] = $row;
                                }
                                // Libera el búfer de resultados
                                $resultVentaFiltro->free();
                                $conn->next_result();
                            } else {
                                echo "Error al obtener cliente: " . $conn->error;
                            }
                            ?>
                            <!-- Botón de edición en la tabla -->
                            <button class="btn btn-warning btn-sm btn-spacing btn-editar" 
                                data-idEditar="<?php echo $venta['idVenta']; ?>" 
                                data-fecha="<?php echo $VentaFiltro[0]['FechaVenta']; ?>" 
                                data-cliente="<?php echo $cliente[0]['idCliente'];?>" 
                                data-bs-toggle="modal" 
                                data-bs-target="#Modal-EditarVenta">Editar
                            </button>   
                            <button class="btn btn-danger btn-eliminar" data-id="<?php echo $venta['idVenta']; ?>">Eliminar</button>                      
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<!-- Modal Agregar -->
<div id="Modal-CrearVenta" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center w-100" id="modal-agregar-label">Formulario para crear pedido de venta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <div class="row">
                        <div class="form-group col-md-12 text-center">
                            <label for="FechaVenta" class="form-label">Fecha de Venta</label>
                            <input type="date" class="form-control" name="FechaVenta" id="FechaVenta" placeholder="Fecha de Venta" required>
                        </div><br><br><br>
                        <div class="form-group col-md-12 text-center">
                            <label for="Cliente" class="form-label">Cliente</label>
                            <select class="form-control" name="Cliente" id="Cliente" required>
                                <option value="">Seleccione un Cliente</option>
                                <?php foreach ($clientes as $cliente): ?>
                                    <option value="<?php echo $cliente['idCliente']; ?>"><?php echo $cliente['NombreCliente']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div><br><br><br>
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
<!-- Modal Editar -->
<div id="Modal-EditarVenta" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center w-100" id="modal-editar-label">Formulario para editar una venta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-editar-compra" action="" method="POST">
                    <input type="hidden" name="edit_id" id="edit_id">
                    <div class="row">
                        <div class="form-group col-md-12 text-center">
                            <label for="FechaVentaEdit" class="form-label">Fecha de Venta</label>
                            <input type="date" class="form-control" name="FechaVentaEdit" id="FechaVentaEdit" placeholder="Fecha de Venta" required>
                        </div><br><br><br>
                        <div class="form-group col-md-12 text-center">
                            <label for="ClienteEdit" class="form-label">Cliente</label>
                            <select class="form-control" name="ClienteEdit" id="ClienteEdit" required>
                                <option value="">Seleccione un Cliente</option>
                                <?php foreach ($clientes as $cliente): ?>
                                    <option value="<?php echo $cliente['idCliente']; ?>"><?php echo $cliente['NombreCliente']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div><br><br><br>
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

    <!-- Formulario oculto para eliminar una compra -->
    <?php
    echo "
    <form id='delete-form' action='./tablaVentas.php' method='POST' style='display: none;'>
        <input type='hidden' name='delete_id' id='delete_id'>
    </form>

    ";
    ?>

    <!-- Formulario oculto para editar una compra -->
    <?php
    echo "
    <form id='edit-form' action='./tablaVentas.php' method='POST' style='display: none;'>
        <input type='hidden' name='edit_id' id='edit_id'>
        <input type='hidden' name='FechaVentaEdit' id='FechaVentaEdit'>
        <input type='hidden' name='ClienteEdit' id='ClienteEdit'>
    </form>

    ";
    ?>

</body>
</html>

<!-- Bootstrap JS and dependencies -->
<script src="../../resources/src/Bootstrap/js/jquery.min.js"></script>
<script src="../../resources/src/Bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../resources/src/Bootstrap/js/bootstrap.min.js"></script>
<script src="../../resources/src/SweetAlert/sweetalert2.min.js"></script>
<script>
// Permite que se despliegue el dropdown
$('.dropdown-toggle').click(function() {
    $(this).next('.dropdown-menu').toggleClass('show');
});

// Permite que se despliegue el dropdown
$(document).click(function(e) {
    var container = $(".dropdown");
    if (!container.is(e.target) && container.has(e.target).length === 0) {
        container.find('.dropdown-menu').removeClass('show');
    }
});

// Maneja el clic en el botón "Eliminar"
$('.btn-eliminar').click(function() {
    var ventaId = $(this).data('id');
    // Muestra un mensaje de confirmación antes de eliminar la compra (caso en js)
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
            $('#delete_id').val(ventaId);  
            $('#delete-form').submit();
        }
    });
});

// Maneja el clic en el botón "Editar"
$('.btn-editar').click(function() {
    var VentaId = $(this).data('ideditar');
    var fechaVenta = $(this).data('fecha');
    var clienteId = $(this).data('cliente');
    
    // Establece los valores en el formulario de edición
    $('#edit_id').val(VentaId);
    $('#FechaVentaEdit').val(fechaVenta);
    $('#ClienteEdit').val(clienteId);

    // Abre el modal de edición
    $('#Modal-EditarVenta').modal('show');
});

</script>
