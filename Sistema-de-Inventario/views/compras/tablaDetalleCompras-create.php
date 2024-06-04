<?php 
session_start();

include '../../models/comprasModel.php';
$objCompra = new Compra();
$conn = conectar();

$idCompra = $_POST['idCompra'] ?? $_GET['idCompra'];
if (!$idCompra) {
    die("ID de compra no proporcionado.");
}

// Obtener los datos de la compra
$sqlCompras = $objCompra->obtenerCompraFiltro($idCompra, '', '', '');
$datosCompras = $sqlCompras->fetch_object();

// Obtener los productos de la compra (detalle de compra)
$sqlDetalleCompras = $objCompra->obtenerDetalleCompraFiltro($idCompra);

// verificar si el usuario ha solicitado la eliminacion de un producto

//obtener el todos los productos 
$productos = $objCompra->obtenerTodosLosProductos();
?>

<!DOCTYPE html>
<html lang="en">

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
    <!--Dependencias de JQuery-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
    <title>Agregar Productos</title>
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
                                aria-expanded="false">Administración</a>
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
                            <a href="./tablaCompras.php" id="Compras" class="nav-link">Compras</a>
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
                            <a href="../../views/modifEmpresa/viewModifEmpresa.php" id="configurarEmpresa"
                                class="nav-link">Configurar Empresa</a>
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
        <a class="btn btn-primary" href="./tablaCompras.php">Volver</a>

        <h1 class="text-center">Agregar Productos</h1><br>
        <!-- Logica para obtener el id, fecha y total de la compra seleccionada -->
        <hr>
        <table class="table table-striped table-responsive">
            <thead>
                <tr>
                    <th>N° Compra</th>
                    <th>Fecha de Compra</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $datosCompras->idCompra; ?></td>
                    <td><?php echo $datosCompras->FechaCompra; ?></td>
                    <td><?php echo $datosCompras->TotalCompra; ?></td>
                </tr>
            </tbody>
        </table>
        <div>
            <label>Agregar item a compra</label>
            <button class="btn" id="btn-agregar" data-bs-toggle="modal" data-bs-target="#Modal-agregarItem"><img
                    src="../../resources/Icons/agregar.svg"></button>
        </div>
        <!-- Obtener los productos de la compra -->
        <form id="form-guardar-productos" action="guardarProductos.php" method="POST">
            <input type="hidden" name="idCompra" value="<?php echo $datosCompras->idCompra; ?>">
            <table class="table table-striped table-responsive" id="tabla-productos">
                <thead>
                    <tr>
                        <th>Nombre Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Sub Total</th>
                        <th>Eliminar Item</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($sqlDetalleCompras->num_rows > 0): ?>
                    <?php while ($datosDetalleCompras = $sqlDetalleCompras->fetch_object()): ?>
                    <tr>
                        <td><?php echo $datosDetalleCompras->NombreProducto; ?></td>
                        <td><?php echo $datosDetalleCompras->Cantidad; ?></td>
                        <td><?php echo $datosDetalleCompras->Precio; ?></td>
                        <td><?php echo $datosDetalleCompras->SubTotal; ?></td>
                        <td>
                            <button class="btn btn-eliminar"><img src="../../resources/Icons/eliminar.svg"></button>
                    </tr>
                    <?php endwhile; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No se han insertado productos a esta compra.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <!--Modal para agregar productos o item a una compra-->
            <div id="Modal-agregarItem" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabel">Agregar Producto</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="form-agregar-item">
                                <div class="mb-3">
                                    <label for="NombreProducto" class="form-label">Nombre Producto</label>
                                    <input class="form-control" id="NombreProducto" name="NombreProducto">
                                    <br>
                                    <p class="text-center">O</p>
                                    <label for="SeleccionarProducto" class="form-label">Seleccionar Producto</label>
                                    <select class="form-select" id="NombreProductoSelect" name="NombreProductoSelect">
                                        <option value="">Seleccionar Producto</option>
                                        <?php foreach ($productos as $producto): ?>
                                        <option value="<?php echo $producto; ?>">
                                            <?php echo $producto; ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="Cantidad" class="form-label">Cantidad</label>
                                    <input type="number" class="form-control" id="Cantidad" name="Cantidad" required>
                                </div>
                                <div class="mb-3">
                                    <label for="Precio" class="form-label">Precio</label>
                                    <input type="number" class="form-control" id="Precio" name="Precio" required>
                                </div>
                                <div class="mb-3">
                                    <label for="SubTotal" class="form-label">Sub Total</label>
                                    <input type="number" class="form-control" id="SubTotal" name="SubTotal" disabled>
                                </div>
                                <button type="button" class="btn btn-primary" id="guardar-item">Guardar Item</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-success mt-3" id="guardar-cambios">Guardar Cambios</button>
    </div>
    <script src="../../resources/src/Bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../resources/src/Bootstrap/js/bootstrap.min.js"></script>
    <script src="../../resources/src/Bootstrap/js/jquery.min.js"></script>
    <script>
    // Calcular el subtotal automáticamente
    $('#Cantidad, #Precio').on('input', function() {
        var cantidad = $('#Cantidad').val();
        var precio = $('#Precio').val();
        var subtotal = cantidad * precio;
        $('#SubTotal').val(subtotal);
    });

    // Agregar item temporalmente a la tabla
    $('#guardar-item').on('click', function() {
        //Si el usaurio no selecciona un producto del select, se toma el valor del input
        if ($('#NombreProductoSelect').val() === '') {
            var nombreProducto = $('#NombreProducto').val();
        }else{
            var nombreProducto = $('#NombreProductoSelect').val();
        }
        var cantidad = $('#Cantidad').val();
        var precio = $('#Precio').val();
        var subtotal = $('#SubTotal').val();

        if (nombreProducto && cantidad && precio) {
            var nuevaFila = `
                <tr class="nuevo-producto">
                    <td>${nombreProducto}</td>
                    <td>${cantidad}</td>
                    <td>${precio}</td>
                    <td>${subtotal}</td>
                    <td>
                        <button type="button" class="btn btn-eliminarTemp"><img src="../../resources/Icons/eliminar.svg"></button>
                    </td>
                    <input type="hidden" name="productos[${nombreProducto}][nombreProducto]" value="${nombreProducto}">
                    <input type="hidden" name="productos[${nombreProducto}][cantidad]" value="${cantidad}">
                    <input type="hidden" name="productos[${nombreProducto}][precio]" value="${precio}">
                    <input type="hidden" name="productos[${nombreProducto}][subtotal]" value="${subtotal}">
                </tr>
                `;
            $('#tabla-productos tbody').append(nuevaFila);
            $('#NombreProducto').val(''); 
            $('#NombreProductoSelect').val('');
            $('#Cantidad').val('');
            $('#Precio').val('');
            $('#SubTotal').val('');
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Por favor, complete todos los campos.',
            });
        }
    });

    // Eliminar item de la tabla
    $(document).on('click', '.btn-eliminarTemp', function() {
        $(this).closest('tr').remove();
    });

    // Eliminar producto de la tabla
    $('#tabla-productos').on('click', '.btn-eliminarTemp', function() {
        $(this).closest('tr').remove();
    });

    // Guardar cambios (cuando se ingresa desde el input)
    $('#guardar-cambios').on('click', function(event) {
        var nuevosProductos = $('#tabla-productos tbody tr.nuevo-producto').length;
        if (nuevosProductos > 0) {
            event.preventDefault(); // Evitar el envío del formulario
            Swal.fire({
                title: 'Confirmar',
                text: 'Se agregarán ' + nuevosProductos + ' productos nuevos. ¿Desea continuar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, agregar',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form-guardar-productos').off('submit')
                .submit(); // Enviar el formulario después de la confirmación
                }
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No hay productos para guardar.',
            });
        }
    });

    // Mantener el idCompra al recargar la página
    $(document).ready(function() {
        if (typeof(Storage) !== 'undefined') {
            localStorage.setItem('idCompra', '<?php echo $idCompra; ?>');
        }
    });

    //permite que se despliegue el dropdown
    $('.dropdown-toggle').click(function() {
        $(this).next('.dropdown-menu').toggleClass('show');
    });
    
    //permite que se despliegue el dropdown
    $(document).click(function(e) {
        var container = $(".dropdown");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            container.find('.dropdown-menu').removeClass('show');
        }
    });

    //Logica para el buscador de productos
    $(document).ready(function() {
            var productos = <?php echo json_encode($productos); ?>;

            // Filtrar productos en el select cuando se escribe en el input
            $("#NombreProducto").on("input", function() {
                var searchTerm = $(this).val().toLowerCase();
                $("#NombreProductoSelect option").each(function() {
                    var optionText = $(this).text().toLowerCase();
                    if (optionText.includes(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            // Autocompletar para el input NombreProducto
            $("#NombreProducto").autocomplete({
                source: productos,
                minLength: 2
            });

            // Reset select options when input is cleared
            $("#NombreProducto").on("blur", function() {
                if ($(this).val() === "") {
                    $("#NombreProductoSelect option").show();
                }
            });
        });

    // Obtener precio del producto seleccionado
    $('#NombreProductoSelect').on('change', function() {
        var precio = $(this).find(':selected').data('precio');
        $('#precio').val(precio);
    });

    // Al abrir el modal, actualizar el precio con el producto seleccionado por defecto
    $('#Modal-agregarItem').on('shown.bs.modal', function() {
        var precio = $('#NombreProductoSelect').find(':selected').data('precio');
        $('#precio').val(precio);
    });

    
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>