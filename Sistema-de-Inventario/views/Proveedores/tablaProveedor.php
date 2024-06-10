<?php
    session_start();
    require "../../models/proveedorModel.php";
    $objProveedor = new Proveedor(); 

    // Verificar si se recibieron datos del formulario al agregar un Proveedor
    if ($_POST && isset($_POST['NombreProveedor'], $_POST['CorreoProveedor'], $_POST['TelefonoProveedor'], $_POST['TelefonoProveedor'], $_POST['MetodoDePagoAceptado'])) {
        $nombre = $_POST['NombreProveedor'];
        $correo = $_POST['CorreoProveedor'];
        $telefono = $_POST['TelefonoProveedor'];
        $metodoPago = $_POST['MetodoDePagoAceptado'];
    
        
        if ($nombre != "" && $correo != "" && $telefono != "" && $metodoPago != "") {
            // Muestra un mensaje de éxito al agregar un Proveedor y redirige a la tabla de proveedores (caso en php)
            echo "<script>
                window.onload = function() {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: 'Proveedor agregado exitosamente',
                        icon: 'success'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = './tablaProveedor.php';
                        }
                    });
                };
            </script>";
            $data = $objProveedor->agregarProveedor($nombre, $correo, $telefono, $metodoPago);
        }else{
            // Muestra un mensaje de error al agregar un proveedor y redirige a la tabla de proveedores (caso en php)
            echo "<script>
                window.onload = function() {
                    Swal.fire({
                        title: '¡Error al agregar proveedor!',
                        text: 'Debe de completar todos los campos!',
                        icon: 'error'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = './tablaProveedor.php';
                        }
                    });
                };
            </script>";
        }
    }

    // Verificar si se ha solicitado la eliminación de un proveedor
    if (isset($_POST['delete_id'])) {
        $idProveedor = $_POST['delete_id'];
        echo "<script>
        window.onload = function() {
            Swal.fire({
                title: '¡Éxito!',
                text: 'Proveedor eliminado exitosamente',
                icon: 'success'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = './tablaProveedor.php';
                }
            });
        };
        </script>";
        $objProveedor->eliminarProveedor($idProveedor); 
    }
    ?>

    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--Dependencias de bootstrap-->
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
        <title>Proveedores</title>
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
                                <a href="../../views/panelControl/panelControl.php" class="nav-link">Panel de Control</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                                <a href="../../views/compras/guardarProductos.php" id="Compras" class="nav-link">Compras</a>
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
                    <h1>PROVEEDORES</h1>
                </div>
                <div class="col-md-4 text-lg-center">
                    <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#modal-agregar">
                        Agregar Proveedor
                    </button>
                    <a class="btn btn-success btn-lg" href="../../views/Reportes/ReporteProveedores.php" target="blank">Generar Reporte</a>
                </div>
            </div>
            <hr>
            <div class="table-responsive mt-2">
                <table class="table table-bordered table-hover" id="tabla-datos">
                    <thead class="bg-primary text-light">
                        <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Método de Pago</th>
                        <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- tu codigo php con los datos (for o foreach) -->
                        <?php
                        // Obtener todos los datos de los proveedores
                        $data=$objProveedor->obtenerProveedores();
                        // Recorrer cada dato que existe y mostrarlos en la tabla
                        foreach ($data as $objProveedor) {
                            echo "<tr>";
                            echo "<td>".$objProveedor["idProveedor"]."</td>";
                            echo "<td>".$objProveedor["NombreProveedor"]."</td>";
                            echo "<td>".$objProveedor["CorreoProveedor"]."</td>";
                            echo "<td>".$objProveedor["TelefonoProveedor"]."</td>";
                            echo "<td>".$objProveedor["MetodoDePagoAceptado"]."</td>";
                            $id = $objProveedor["idProveedor"];
                            echo "<td data-bs-toggle='modal' data-bs-target='#modal-editar' class='action-buttons'>
                            <button class='btn btn-warning btn-lg btn-spacing editar-btn'><a class='text-decoration-none text-dark' href='./viewModificarProveedor.php?id=$id'>Editar</a>
                            </button><button class='btn btn-danger btn-lg btn-spacing eliminar-btn' data-id='".$objProveedor["idProveedor"]."'>Eliminar</button>
                            </td>";
                            echo"</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Modal para agregar un proveedor -->
        <div class="modal fade" id="modal-agregar" tabindex="-1" aria-labelledby="modal-agregar-label" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-agregar-label">Agregar Proveedor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="./tablaProveedor.php" method="POST">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" name="NombreProveedor" placeholder="Nombre" required>
                                </div><br><br>
                                <div class="form-group col-md-6">
                                    <input type="email" class="form-control" name="CorreoProveedor" placeholder="Correo" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" name="TelefonoProveedor" placeholder="Teléfono" required>
                                </div>
                                <br><br>
                                <div class="form-group col-md-6">
                                    <select class="form-select" name="MetodoDePagoAceptado" required>
                                        <option selected disabled>-- Seleccione Método de Pago --</option>
                                        <option value="Efectivo">Efectivo</option>
                                        <option value="Transferencia">Transferencia</option>
                                        <option value="Deposito">Depósito</option>
                                    </select>
                                </div>
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

        <!-- Formulario oculto para eliminar proveedor -->
        <form id="delete-form" action="./tablaProveedor.php" method="POST" style="display: none;">
            <input type="hidden" name="delete_id" id="delete_id">
        </form>


    <!-- Bootstrap JS and dependencies -->
    <script src="../../resources/src/Bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../resources/src/Bootstrap/js/waitMe.min.js"></script>
    <script src="../../resources/src/Bootstrap/js/jquery.min.js"></script>
    <script src="../../resources/src/Bootstrap/js/bootstrap.min.js"></script>
    <script src="../../resources/src/Bootstrap/js/popper.min.js"></script>
    <script src="../../resources/src/Bootstrap/js/lobibox.js"></script>
    <script src="../../resources/src/Bootstrap/js/notifications.js"></script>
    <script src="../../resources/src/Bootstrap/js/messageboxes.js"></script>
    <script src="../../resources/src/Bootstrap/js/datatables.min.js"></script>
    <script src="../../resources/src/Bootstrap/js/datatables.js"></script>
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

    // Función para limpiar los campos del formulario de proveedores
    function limpiarCamposProveedores() {
        document.getElementById("NombreProveedor").value = "";
        document.getElementById("CorreoProveedor").value = "";
        document.getElementById("TelefonoProveedor").value = "";
        document.getElementById("MetodoDePagoAceptado").value = "";
    }

    // Maneja el clic en el botón "Eliminar"
    $('.eliminar-btn').click(function() {
            var idProveedor = $(this).data('id');
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
                    $('#delete_id').val(idProveedor);
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
