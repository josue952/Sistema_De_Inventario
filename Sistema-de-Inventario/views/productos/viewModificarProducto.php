<?php
//Se incluye el modelo de usuario, que utiliza la conexion a la base de datos y los metodos necesarios
//para realizar las operaciones CRUD
include_once '../../models/productoModel.php';
//Se instancia la clase Usuario
$objProducto = new productoModel();

//Parte para obtener el id del usuario
$idProducto = $_POST['idProducto'];
if (!$idProducto) {
    die("ID de producto no proporcionado.");
}

//Parte para manejar la logica para actualizar al usuario en la base de datos

//Si se presiona el boton de editar
if (isset($_POST['btnEditar'])) {
    $idProducto = $_POST['idProducto'];
    $Nombreproducto = $_POST['Nombreproducto'];
    $Cantidad = $_POST['Cantidad'];
    $Precio = $_POST['Precio'];
    $Foto = $_POST['Foto'];
    $idCategoria = $_POST['idCategoria'];
    $idSucursal = $_POST['idSucursal'];

    $data = $objProducto->actualizarProducto($NombreProducto, $Cantidad, $Precio, $Foto, $idCategoria, $idSucursal);

    // Si se actualiza el producto
    if ($data) {
        // Limpiar las variables
        $NombreProducto = '';
        $Cantidad = '';
        $Precio = '';
        $Foto = '';
        $idCategoria = '';
        $idSucursal = '';

        //se utiliza sweetalert para mostrar un mensaje de exito
        echo "<script>
        window.onload = function() {
            Swal.fire({
                title: '¡Éxito!',
                text: 'Usuario actualizado correctamente',
                icon: 'success'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = './tablaUsuario.php';
                }
            });
        };
        </script>";
    } else {
        //se utiliza sweetalert para mostrar un mensaje de error
        echo "<script>
        window.onload = function() {
            Swal.fire({
                title: '¡Error!',
                text: 'Algo salio mal!',
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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../resources/src/Bootstrap/css/bootstrap.min.css">
    <!--Dependencias de bootstrap-->
    <script src="../../resources/src/Bootstrap/js/bootstrap.bundle.js"></script>
    <script src="../../resources/src/Bootstrap/js/bootstrap.min.js"></script>
    <!--Dependencias de SweetAlert-->
    <script src="../../resources/src/SweetAlert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="../../resources/src/SweetAlert/sweetalert2.min.css">
    <title>Editar Usuario</title>
</head>

<body class="bg-light">


    <!--Modal para editar un Producto-->

    <form action="./viewModificarProducto.php?id=<?php echo $idProducto; ?>" class="col-4 p-3 m-auto" method="post">
        <h5 class="text-center alert alert-secondary">Modificar Producto</h5>
        <?php
        // Obtener los datos del producto con un filtro por ID
        $sql = $objProducto->obtenerProductosFiltro($idProducto, $NombreProducto, $idCategoria);

        while ($datos = $sql->fetch_object()) { ?>
            <div class="mb-1">
                <label for="" class="form-label">Nombre del Producto</label>
                <input type="text" class="form-control" name="Nombreproducto" value="<?php echo $datos->NombreProducto; ?>">
            </div>
            <div class="mb-1">
                <label for="" class="form-label">Cantidad</label>
                <input type="text" class="form-control" name="Cantidad" value="<?php echo $datos->Cantidad; ?>">
            </div>
            <div class="mb-1">
                <label for="" class="form-label">Precio</label>
                <input type="text" class="form-control" name="Precio" value="<?php echo $datos->Precio; ?>">
            </div>
            <div class="mb-1">
                <label for="" class="form-label">Foto</label>
                <input type="text" class="form-control" name="Foto" value="<?php echo $datos->Foto; ?>">
            </div>
            <div class="mb-1">
                <label for="" class="form-label">ID Categoría</label>
                <input type="text" class="form-control" name="idCategoria" value="<?php echo $datos->idCategoria; ?>">
            </div>
            <div class="mb-1">
                <label for="" class="form-label">ID Sucursal</label>
                <input type="text" class="form-control" name="idSucursal" value="<?php echo $datos->idSucursal; ?>">
            </div><br>
        <?php } ?>
        <button type="submit" class="btn btn-primary" name="btnEditar" value="ok">Editar Producto</button>

        <button type="button" class="btn btn-secondary"><a href="./tablaProducto.php"
                class="text-decoration-none text-dark">Volver</a></button>
    </form>

</body>

</html>