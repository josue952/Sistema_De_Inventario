<?php
include_once '../../models/productoModel.php';
$objProducto = new productoModel();

$idProducto = isset($_POST['idProducto']) ? $_POST['idProducto'] : (isset($_GET['id']) ? $_GET['id'] : null);
if (!$idProducto) {
    die("ID de producto no proporcionado.");
}

//este apartado se ejecuta cuando hay una imagen que se enviara
if (isset($_POST['btnEditar'], $_POST['NombreProducto'], $_POST['Cantidad'], $_POST['Precio'], $_POST['idCategoria'], $_POST['idSucursal'])){
    //obtiene el archivo temporal
    $imgProducto = $_FILES['Foto']['tmp_name'];
    //obtiene el nombre del archivo
    $nombreImgProducto = $_FILES['Foto']['name'];
    //obtiene la extensión del archivo
    $tipoImagenProducto = strtolower(pathinfo($nombreImgProducto, PATHINFO_EXTENSION));
    //permite obtener el tamaño del archivo en bytes
    $sizeImagenProducto = $_FILES['Foto']['size'];
    //directorio donde se guardara el archivo
    $directorio = 'resources/Productos_img/';
    //ruta donde se guardara el archivo con el nombre de la imagen  
    $ruta = $directorio.$nombreImgProducto;

    //obtenemos los campos del formulario
    $NombreProducto = $_POST['NombreProducto'];
    $Cantidad = $_POST['Cantidad'];
    $Precio = $_POST['Precio'];
    $Categoria = $_POST['idCategoria'];
    $Sucursal = $_POST['idSucursal'];

    //valida que el archivo sea de tipo jpg, jpeg, png o gif
    if ($tipoImagenProducto == 'jpg' || $tipoImagenProducto == 'jpeg' || $tipoImagenProducto == 'png' || $tipoImagenProducto == 'gif'){
            //almacenar el archivo en la carpeta resources/images
            if (move_uploaded_file($imgProducto, '../../'.$ruta)){
                //llama al metodo de la clase productoModel para insertar un producto
                $data = $objProducto->actualizarProducto($NombreProducto, $Cantidad, $Precio, $ruta, $Categoria, $Sucursal);
                echo "<script>
                window.onload = function() {
                    Swal.fire({
                        title: 'Exito!',
                        text: 'Producto Actualizado Correctamente',
                        icon: 'success'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '../../views/productos/tablaProductos.php';
                        }
                    });
                };
                </script>";
            }else{
                echo "<script>
                window.onload = function() {
                    Swal.fire({
                        title: '¡Error!',
                        text: 'No se ha Registrar el Producto',
                        icon: 'error'
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
    <link rel="stylesheet" href="../../resources/src/Bootstrap/css/bootstrap.min.css">
    <script src="../../resources/src/Bootstrap/js/bootstrap.bundle.js"></script>
    <script src="../../resources/src/Bootstrap/js/bootstrap.min.js"></script>
    <script src="../../resources/src/SweetAlert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="../../resources/src/SweetAlert/sweetalert2.min.css">
    <title>Editar Producto</title>
</head>

<body class="bg-light">

    <form action="./viewModificarProducto.php?id=<?php echo $idProducto; ?>" class="col-4 p-3 m-auto" method="post" enctype="multipart/form-data">
        <h5 class="text-center alert alert-secondary">Modificar Producto</h5>
        <?php
        $sql = $objProducto->obtenerProductosFiltro($idProducto, '');
        while ($datos = $sql->fetch_object()) { ?>
            <div class="mb-1">
                <label for="" class="form-label">Nombre del Producto</label>
                <input type="text" class="form-control" name="NombreProducto" value="<?php echo $datos->NombreProducto; ?>">
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
                <label for="" class="form-label">Imagen Actual</label>
                <img src="../../<?php echo $datos->Foto; ?>" alt="Producto" style="width: 25%; height: auto;">
                <label for="" class="form-label">Nueva Imagen</label>
                <input type="file" class="form-control" name="Foto" value="<?php echo $datos->Foto; ?>">
            </div>
            <div class="mb-1">
                <label for="" class="form-label">Categoría</label>
                <select name="idCategoria" id="idCategoria" class="form-control" required="required">
                    <option value="<?php echo $datos->idCategoria; ?>"><?php echo $datos->NombreCategoria; ?></option>
                    <?php
                    $conn = conectar();
                    $sqlCategorias = "SELECT idCategoria, Categoria FROM categorias";
                    $resultCategorias = $conn->query($sqlCategorias);
                    foreach ($resultCategorias as $categoria) {
                    ?>
                        <option value="<?php echo $categoria['idCategoria']; ?>"><?php echo $categoria['Categoria']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-1">
                <label for="" class="form-label">ID Sucursal</label>
                <select name="idSucursal" id="idSucursal" class="form-control" required="required">
                    <option value="<?php echo $datos->idSucursal; ?>"><?php echo $datos->NombreSucursal; ?></option>
                    <?php
                    $sqlSucursales = "SELECT idSucursal, NombreSucursal FROM sucursales";
                    $resultSucursales = $conn->query($sqlSucursales);
                    foreach ($resultSucursales as $sucursal) {
                    ?>
                        <option value="<?php echo $sucursal['idSucursal']; ?>"><?php echo $sucursal['NombreSucursal']; ?></option>
                    <?php } ?>
                </select>
            </div><br>
        <?php } ?>
        <button type="submit" class="btn btn-primary" name="btnEditar" value="ok">Editar Producto</button>
        <button type="button" class="btn btn-secondary"><a href="./tablaProductos.php" class="text-decoration-none text-dark">Volver</a></button>
    </form>

</body>

</html>
