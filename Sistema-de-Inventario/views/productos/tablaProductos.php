<?php

 session_start();
require "../../models/productoModel.php";

//cpnexion de la base de datos
$conn = new mysqli("localhost", "root", "", "inventario");

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



$objProducto = new productoModel($conn);

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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="../../resources/src/SweetAlert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="../../resources/src/SweetAlert/sweetalert2.min.css">
    <title>Productos</title>
</head>

<body class="bg-light">

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
                    $data = $objUsuario->obtenerUsuarios();
                    foreach ($data as $objUsuario) {
                        $id = $objUsuario["idUsuario"];
                        ?>
                        <tr>
                            <td><?php echo $objUsuario["idProducto"]; ?></td>
                            <td><?php echo $objUsuario["NombreProducto"]; ?></td>
                            <td><?php echo $objUsuario["Cantidad"]; ?></td>
                            <td><?php echo $objUsuario["Precio"]; ?></td>
                            <td><?php echo $objUsuario["Foto"]; ?></td>
                            <td><?php echo $objUsuario["idCategoria"]; ?></td>
                            <td><?php echo $objUsuario["idSucursal"]; ?></td>
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




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/js/bootstrap.min.js"></script>
</body>

</body>

</html>