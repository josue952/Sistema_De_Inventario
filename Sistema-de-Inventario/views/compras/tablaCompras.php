<?php
session_start();

require '../../models/comprasModel.php';
$objCompra = new Compra();
$conn = conectar();

// Obtener lista de proveedores
$sqlProveedores = "CALL obtenerProveedores();";
$resultProveedores = $conn->query($sqlProveedores);

// Cuando hay 2 o mas consultas en un procedimiento almacenado, se debe liberar el búfer de resultados
if ($resultProveedores) {
    $proveedores = [];
    while ($row = $resultProveedores->fetch_assoc()) {
        $proveedores[] = $row;
    }
    // Libera el búfer de resultados
    $resultProveedores->free();
    $conn->next_result();
} else {
    echo "Error al obtener proveedores: " . $conn->error;
}

// Obtener lista de sucursales
$sqlSucursales = "CALL obtenerSucursales();";
$resultSucursales = $conn->query($sqlSucursales);

if ($resultSucursales) {
    $sucursales = [];
    while ($row = $resultSucursales->fetch_assoc()) {
        $sucursales[] = $row;
    }
    // Libera el búfer de resultados
    $resultSucursales->free();
    $conn->next_result();
} else {
    echo "Error al obtener sucursales: " . $conn->error;
}

// obtener lista de compras
$resultCompras = $objCompra->obtenerCompras();

if ($resultCompras) {
    $compras = [];
    while ($row = $resultCompras->fetch_assoc()) {
        $compras[] = $row;
    }
} else {
    echo "Error al obtener compras: " . $conn->error;
}

// Logica para agregar una compra
if ($_POST){
    // Obtener datos del formulario
    $FechaCompra = $_POST['FechaCompra'];
    $Proveedor = $_POST['Proveedor'];
    $Sucursal = $_POST['Sucursal'];

    
    if ($FechaCompra != "" && $Proveedor != "" && $Sucursal != "") {
        $objCompra->crearCompra($FechaCompra, $Proveedor, $Sucursal);
        echo "<script>
        window.onload = function() {
            Swal.fire({
                title: '¡Éxito!',
                text: 'Compra creada exitosamente',
                icon: 'success'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = './tablaCompras.php';
                }
            });
        };
        </script>";
    } else {
        echo "<script>
        window.onload = function() {
            Swal.fire({
                title: '¡Error!',
                text: 'Error al crear la compra',
                icon: 'error'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = './tablaCompras.php';
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
    <!-- Dependencias de Bootstrap -->
    <script src="../../resources/src/Bootstrap/js/bootstrap.bundle.js"></script>
    <script src="../../resources/src/Bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../../resources/src/Bootstrap/css/bootstrap.min.css">
    <!-- Dependencias de SweetAlert -->
    <script src="../../resources/src/SweetAlert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="../../resources/src/SweetAlert/sweetalert2.min.css">
    <style>
        .action-buttons {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .btn-spacing {
            margin: 0 5px;
            /* Ajusta el margen según tus necesidades */
        }
        /* Estilo para centrar el enlace de Inicio */
        .navbar-center {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }
    </style>
    <title>Compras</title>
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
                            <a href="#" id="loginBtn" class="nav-link">Panel de Control</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Administración
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" id="Usuarios"
                                        href="../../views/usuarios/tablaUsuario.php">Usuarios</a></li>
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
                <h1>COMPRAS</h1>
            </div>
            <div class="col-md-4 text-lg-center">
                <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#Modal-CrearCompra">
                    Agregar Compra
                </button>
            </div>
        </div>
        <hr>
        <div class="table-responsive mt-2">
            <table class="table table-bordered table-hover" id="tabla-datos">
                <thead class="bg-primary text-light">
                    <tr>
                        <th>ID</th>
                        <th>Fecha de Compra</th>
                        <th>Proveedor</th>
                        <th>Sucursal</th>
                        <th>Total Compra</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <!-- Logica para obtener los datos de la tabla compras -->
                <tbody>
                    <?php foreach ($compras as $compra): ?>
                    <tr>
                        <td><?php echo $compra['idCompra']; ?></td>
                        <td><?php echo $compra['FechaCompra']; ?></td>
                        <td><?php echo $compra['NombreProveedor']; ?></td>
                        <td><?php echo $compra['NombreSucursal']; ?></td>
                        <td><?php echo $compra['TotalCompra']; ?></td>
                        <td class="action-buttons">
                            <!--Se inicializa como formulario para no mostrar el id en la url por seguridad-->
                            <form action="./tablaDetalleCompras-create.php" method="post" style="display:inline;">
                                <input type="hidden" name="idCompra" value="<?php echo $compra['idCompra']; ?>">
                                <button type="submit" class="btn btn-success btn-sm btn-spacing">Productos</button>
                            </form>
                            <a href="#" class="btn btn-warning btn-sm btn-spacing">Editar</a>
                            <a href="#" class="btn btn-danger btn-sm btn-spacing">Eliminar</a>                        
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal Agregar -->
    <div id="Modal-CrearCompra" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-agregar-label">Formulario para crear pedido de compra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <input type="date" class="form-control" name="FechaCompra" id="FechaCompra" placeholder="Fecha de Compra" required>
                            </div><br><br>
                            <div class="form-group col-md-6">
                                <select class="form-control" name="Proveedor" id="Proveedor" required>
                                    <option value="">Seleccione un proveedor</option>
                                    <?php foreach ($proveedores as $proveedor): ?>
                                        <option value="<?php echo $proveedor['idProveedor']; ?>"><?php echo $proveedor['NombreProveedor']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div><br><br>
                            <div class="form-group col-md-12">
                                <select class="form-control" name="Sucursal" id="Sucursal" required>
                                    <option value="">Seleccione una sucursal</option>
                                    <?php foreach ($sucursales as $sucursal): ?>
                                        <option value="<?php echo $sucursal['idSucursal']; ?>"><?php echo $sucursal['NombreSucursal']; ?></option>
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
</body>
</html>
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
$('.dropdown-toggle').click(function() {
    $(this).next('.dropdown-menu').toggleClass('show');
});

$(document).click(function(e) {
    var container = $(".dropdown");
    if (!container.is(e.target) && container.has(e.target).length === 0) {
        container.find('.dropdown-menu').removeClass('show');
    }
});
</script>
