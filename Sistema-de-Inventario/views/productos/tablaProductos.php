<?php

 session_start();
require "../../models/productoModel.php";


// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$objProducto = new productoModel();

//cpnexion de la base de datos
$conn = conectar();


// Verificar si se ha solicitado la eliminación de un producto
if (isset($_POST['delete_id'])) {
    $idProducto = $_POST['delete_id'];
    echo "<script>
    window.onload = function() {
        Swal.fire({
            title: '¡Éxito!',
            text: 'Producto eliminado exitosamente',
            icon: 'success'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = './tablaProducto.php';
            }
        });
    };
    </script>";
    $objProducto->eliminar($idProducto);
}

// Verificar si se recibieron datos del formulario al crear un producto
if ($_POST && isset($_POST['TXTNombreproducto'], $_POST['TXTCantidad'], $_POST['TXTPrecio'], $_POST['TXTFoto'], $_POST['TXTCategoria'], $_POST['TXTSucursal'])) {
    $Nombreproducto = $_POST['TXTNombreproducto'];
    $Cantidad = $_POST['TXTCantidad'];
    $Precio = $_POST['TXTPrecio'];
    $Foto = $_POST['TXTFoto'];
    $idCategoria = $_POST['TXTCategoria'];
    $idSucursal = $_POST['TXTSucursal'];

    if ($Nombreproducto != "" && $Cantidad != "" && $Precio != "" && $Foto != "" && $idCategoria != "" && $idSucursal != "") {
        // Muestra un mensaje de éxito al crear un producto y redirige a la tabla de productos
        echo "<script>
            window.onload = function() {
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'Producto creado exitosamente',
                    icon: 'success'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './tablaProducto.php';
                    }
                });
            };
        </script>";
        $data = $objProducto->agregar($Nombreproducto, $Cantidad, $Precio, $Foto, $idCategoria, $idSucursal);
    } else {
        // Muestra un mensaje de error al crear un producto y redirige a la tabla de productos
        echo "<script>
            window.onload = function() {
                Swal.fire({
                    title: '¡Error al crear producto!',
                    text: 'Debe de completar todos los campos!',
                    icon: 'error'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './tablaProducto.php';
                    }
                });
            };
        </script>";
    }
}

// obtener productos
$productos = $objProducto->mostrar(); 


?>


<!DOCTYPE html>
< lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="../../resources/src/Bootstrap/js/bootstrap.bundle.js"></script>
    <script src="../../resources/src/Bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../../resources/src/Bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../resources/src/Bootstrap/css/lobibox.css">
    <link rel="stylesheet" href="../../resources/src/Bootstrap/css/select2.css">
    <link rel="stylesheet" href="../../resources/src/Bootstrap/css/datatables.css">
    <link rel="stylesheet" href="../../resources/src/Bootstrap/css/waitMe.css">
    <script src="../../resources/src/SweetAlert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="../../resources/src/SweetAlert/sweetalert2.min.css">
    <!--Dependencias de terceros-->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.6/css/all.css">
    <title>Productos</title>
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

    <h1 class="text-center p-4">Tabla Productos</h1>



    <div class="container mt-4 bg-white rounded p-4 shadow">
        <!-- Modal -->
        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Registrar
        </button>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo Registro</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <input type="number" class="form-control" name="TXTidProducto" id="idProducto"
                                        placeholder="idProducto" require>
                                </div><br><br>
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" name="TXTnombreProducto" id="NombreProducto"
                                        placeholder="Nombre del producto" require>
                                </div><br><br>
                                <div class="form-group col-md-6">
                                    <input type="number" class="form-control" name="TXTcantidad" id="Cantidad"
                                        placeholder="Cantidad" require>
                                </div><br><br>
                                <div class="form-group col-md-6">
                                    <input type="number" class="form-control" name="TXTprecio" id="Precio"
                                        placeholder="Precio" require>
                                </div><br><br>
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" name="TXTcategoria" id="Categoria"
                                        placeholder="Categoria" require>
                                </div><br><br>
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" name="TXTsucursal" id="Sucursal"
                                        placeholder="Sucursal" require>
                                </div><br><br>
                            </div>
                            <input type="text" class="form-control" name="imagen">
                            <input type="submit" value="Registrar" name="btnRegistrar"
                                class="form-control btn btn-success">

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Agregar</button>
                    </div>
                </div>
            </div>
        </div>


        <table class="table table-hover table-stripped" id="tablaProductos>"


        <?php

        

        ?>
            <thead class="bg-dark text-white">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre del Producto</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Imagen</th>
                    <th scope="col">idCategoria</th>
                    <th scope="col">idSucursal</th>
                    <th scope="col">Botones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                        // obtener todos los datos de los usuarios
                        $resultProductos = $objProducto->mostrar();

                        if ($resultProductos) {
                            $Productos = [];
                            while ($row = $resultProductos->fetch_assoc()) {
                                $Productos[] = $row;
                            }
                        } else {
                            echo "Error al obtener Productos: " . $conn->error;
                        }   
                        foreach ($Productos as $producto) {
                        ?>
                        <tr>
                            <td><?php echo $producto["idProducto"]; ?></td>
                            <td><?php echo $producto["NombreProducto"]; ?></td>
                            <td><?php echo $producto["Cantidad"]; ?></td>
                            <td><?php echo $producto["Precio"]; ?></td>
                            <td><?php echo $producto["Foto"]; ?></td>
                            <td><?php echo $producto["idCategoria"]; ?></td>
                            <td><?php echo $producto["idSucursal"]; ?></td>
                            <td class="action-buttons">
                                <?php $id = $producto["idProducto"];?>
                                <!-- Formulario para la acción de editar -->
                                <form action="./viewModificarUsuario.php" method="post" style="display:inline;">
                                    <input type="hidden" name="idProducto" value="<?php echo $id; ?>">
                                    <button type="submit" class="btn btn-warning btn-lg btn-spacing editar-btn">Editar</button>
                                </form>
                                
                                <?php echo"</button><button class='btn btn-danger btn-lg btn-spacing eliminar-btn' data-id='".$producto["idProducto"]."'>Eliminar</button>"?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
        </table>
    </div>




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
</body>
</body>
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