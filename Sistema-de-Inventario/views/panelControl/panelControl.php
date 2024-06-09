<?php
session_start();
require '../../Conexion-Base-de-Datos/dbConnection.php';

$conn = conectar();

$filterEntradas = "";
$orderByEntradas = "";
$filterSalidas = "";
$orderBySalidas = "";

if ($_POST) {
    // Filtros para entradas
    if (isset($_POST['buscarFecha']) || isset($_POST['buscarPrecio']) || isset($_POST['buscarCantidad']) || isset($_POST['buscarProveedor']) || isset($_POST['buscarTipo'])) {
        $opcionFecha = $_POST['buscarFecha'];
        $opcionPrecio = $_POST['buscarPrecio'];
        $opcionCantidad = $_POST['buscarCantidad'];
        $opcionProveedor = $_POST['buscarProveedor'];
        $opcionTipo = $_POST['buscarTipo'];

        $conditions = array();
        $orderBy = array();

        if ($opcionFecha) {
            $conditions[] = "Fecha = '$opcionFecha' COLLATE utf8mb4_general_ci";
        }
        if ($opcionPrecio) {
            if ($opcionPrecio == 'Mayor') {
                $orderBy[] = "PrecioUnitario DESC";
            } else {
                $orderBy[] = "PrecioUnitario ASC";
            }
        }
        if ($opcionCantidad) {
            if ($opcionCantidad == 'Mayor') {
                $orderBy[] = "Cantidad DESC";
            } else {
                $orderBy[] = "Cantidad ASC";
            }
        }
        if ($opcionProveedor) {
            $conditions[] = "Proveedor LIKE '%$opcionProveedor%' COLLATE utf8mb4_general_ci";
        }
        if ($opcionTipo == 'Compra') {
            $conditions[] = "Tipo = 'Compra' COLLATE utf8mb4_general_ci";
        } else if ($opcionTipo == 'Entrada') {
            $conditions[] = "Tipo = '$opcionTipo' COLLATE utf8mb4_general_ci";
        }

        if (count($conditions) > 0) {
            $filterEntradas = " WHERE " . implode(" AND ", $conditions);
        }
        if (count($orderBy) > 0) {
            $orderByEntradas = " ORDER BY " . implode(", ", $orderBy);
        }
    }

    // Filtros para salidas
    if (isset($_POST['buscarFechaSalida']) || isset($_POST['buscarPrecioSalida']) || isset($_POST['buscarCantidadSalida']) || isset($_POST['buscarCliente']) || isset($_POST['buscarTipoSalida'])) {
        $opcionFechaSalida = $_POST['buscarFechaSalida'];
        $opcionPrecioSalida = $_POST['buscarPrecioSalida'];
        $opcionCantidadSalida = $_POST['buscarCantidadSalida'];
        $opcionCliente = $_POST['buscarCliente'];
        $opcionTipoSalida = $_POST['buscarTipoSalida'];

        $conditionsSalida = array();
        $orderBySalida = array();

        if ($opcionFechaSalida) {
            $conditionsSalida[] = "Fecha = '$opcionFechaSalida' COLLATE utf8mb4_general_ci";
        }
        if ($opcionPrecioSalida) {
            if ($opcionPrecioSalida == 'Mayor') {
                $orderBySalida[] = "PrecioUnitario DESC";
            } else {
                $orderBySalida[] = "PrecioUnitario ASC";
            }
        }
        if ($opcionCantidadSalida) {
            if ($opcionCantidadSalida == 'Mayor') {
                $orderBySalida[] = "Cantidad DESC";
            } else {
                $orderBySalida[] = "Cantidad ASC";
            }
        }
        if ($opcionCliente) {
            $conditionsSalida[] = "Cliente LIKE '%$opcionCliente%' COLLATE utf8mb4_general_ci";
        }
        if ($opcionTipoSalida) {
            $conditionsSalida[] = "Tipo = '$opcionTipoSalida' COLLATE utf8mb4_general_ci";
        }

        if (count($conditionsSalida) > 0) {
            $filterSalidas = " WHERE " . implode(" AND ", $conditionsSalida);
        }
        if (count($orderBySalida) > 0) {
            $orderBySalidas = " ORDER BY " . implode(", ", $orderBySalida);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de control</title>
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
                        <?php if (!isset($_SESSION['Nombre'])) : ?>
                            <li class="nav-item">
                                <a href="#" id="loginBtn" class="nav-link">Iniciar Sesión</a>
                            </li>
                        <?php else : ?>
                            <li class="nav-item">
                                <a href="../../views/panelControl/panelControl.php" id="loginBtn" class="nav-link">Panel de Control</a>
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
            <?php if (isset($_SESSION['Nombre'])) : ?>
                <div class="dropdown ms-auto">
                    <a class="navbar-brand dropdown-toggle" href="#" id="usuarioDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-11">
                <!-- Tabla entrada de productos -->
                <table class="table">
                    <h2>Entrada de productos</h2>
                    <!-- Buscador  -->
                    <div class="inline-search">
                        <form method="post" id="EntradaProductos">
                            <label for="buscarFecha">Buscar por fecha:</label>
                            <input type="date" id="buscarFecha" name="buscarFecha" class="col-md-1">
                            <label for="buscarPrecio">Buscar por precio:</label>
                            <select id="buscarPrecio" name="buscarPrecio" class="col-md-1">
                                <option></option>
                                <option>Mayor</option>
                                <option>Menor</option>
                            </select>
                            <label for="buscarCantidad">Buscar por cantidad:</label>
                            <select id="buscarCantidad" name="buscarCantidad" class="col-md-1">
                                <option></option>
                                <option>Mayor</option>
                                <option>Menor</option>
                            </select>
                            <label for="buscarProveedor">Buscar por proveedor:</label>
                            <input type="text" id="buscarProveedor" name="buscarProveedor" class="col-md-1">
                            <label for="buscarTipo">Buscar por tipo:</label>
                            <select id="buscarTipo" name="buscarTipo" class="col-md-1 m-1">
                                <option></option>
                                <option>Compra</option>
                                <option>Entrada</option>
                            </select>
                            <button class="btn btn-primary col-md-1" type="submit">Filtrar Entradas</button>

                            <button class="btn btn-primary" type="button"><a class="text-decoration-none text-white" href="./panelControl.php">Limpiar Filtros</a></button>
                        </form>
                    </div>
                    <!--Cuerpo de la tabla -->
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Subtotal</th>
                            <th>Proveedor</th>
                            <th>Tipo</th>
                        </tr>
                    </thead>
                    <tbody id="tablaEntradas">
                        <?php
                        // Consulta para obtener las entradas de productos
                        $sql = "SELECT * FROM EntradasDeProductos $filterEntradas $orderByEntradas";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["Fecha"] . "</td>";
                                echo "<td>" . $row["Producto"] . "</td>";
                                echo "<td>" . $row["Cantidad"] . "</td>";
                                echo "<td>" . $row["PrecioUnitario"] . "</td>";
                                echo "<td>" . $row["SubTotal"] . "</td>";
                                echo "<td>" . $row["Proveedor"] . "</td>";
                                echo "<td>" . $row["Tipo"] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No hay datos disponibles</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-11">
                <!-- Tabla salida de productos -->
                <table class="table">
                    <h2>Salida de productos</h2>
                    <!-- Buscador  -->
                    <div class="inline-search">
                        <form method="post" id="SalidaProductos">
                            <label for="buscarFechaSalida">Buscar por fecha:</label>
                            <input type="date" id="buscarFechaSalida" name="buscarFechaSalida" class="col-md-1">
                            <label for="buscarPrecioSalida">Buscar por precio:</label>
                            <select id="buscarPrecioSalida" name="buscarPrecioSalida" class="col-md-1">
                                <option></option>
                                <option>Mayor</option>
                                <option>Menor</option>
                            </select>
                            <label for="buscarCantidadSalida">Buscar por cantidad:</label>
                            <select id="buscarCantidadSalida" name="buscarCantidadSalida" class="col-md-1">
                                <option></option>
                                <option>Mayor</option>
                                <option>Menor</option>
                            </select>
                            <label for="buscarCliente">Buscar por cliente:</label>
                            <input type="text" id="buscarCliente" name="buscarCliente" class="col-md-1">
                            <label for="buscarTipoSalida">Buscar por tipo:</label>
                            <select id="buscarTipoSalida" name="buscarTipoSalida" class="col-md-1 m-2">
                                <option></option>
                                <option>Venta</option>
                                <option>Salida</option>
                            </select>
                            <button class="btn btn-primary col-md-1" type="submit">Filtrar Salidas</button>

                            <button class="btn btn-primary col-md-1" type="button"><a class="text-decoration-none text-white" href="./panelControl.php">Limpiar Filtros</a></button>
                        </form>
                    </div>
                    <!--cuerpo de la tabla -->
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Subtotal</th>
                            <th>Cliente</th>
                            <th>Tipo</th>
                        </tr>
                    </thead>
                    <tbody id="tablaSalidas">
                        <?php
                        // Consulta para obtener las salidas de productos
                        $sql = "SELECT * FROM SalidasDeProductos $filterSalidas $orderBySalidas";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["Fecha"] . "</td>";
                                echo "<td>" . $row["Producto"] . "</td>";
                                echo "<td>" . $row["Cantidad"] . "</td>";
                                echo "<td>" . $row["PrecioUnitario"] . "</td>";
                                echo "<td>" . $row["SubTotal"] . "</td>";
                                echo "<td>" . $row["Cliente"] . "</td>";
                                echo "<td>" . $row["Tipo"] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No hay datos disponibles</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
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
</script>
