<?php
// Se incluye el modelo de proveedor, que utiliza la conexión a la base de datos y los métodos necesarios
include_once '../../models/proveedorModel.php';

// Se instancia la clase Proveedor
$objProveedor = new Proveedor();

// Se obtiene el ID del proveedor de la URL
$idProveedor = $_GET['id'];
if (!$idProveedor) {
    die("ID de proveedor no proporcionado.");
}

// Manejo de la lógica para actualizar al proveedor en la base de datos
if ($_POST) {
    $nombreProveedor = $_POST['NombreProveedor'];
    $correoProveedor = $_POST['CorreoProveedor'];
    $telefonoProveedor = $_POST['TelefonoProveedor'];
    $metodoDePagoAceptado = $_POST['MetodoDePagoAceptado'];

    $data = $objProveedor->actualizarProveedor($idProveedor, $nombreProveedor, $correoProveedor, $telefonoProveedor, $metodoDePagoAceptado);

    if ($data) {
        // Limpiar las variables
        $nombreProveedor = '';
        $correoProveedor = '';
        $telefonoProveedor = '';
        $metodoDePagoAceptado = '';

        // Mostrar un mensaje de éxito usando SweetAlert
        echo "<script>
        window.onload = function() {
            Swal.fire({
                title: '¡Éxito!',
                text: 'Proveedor actualizado correctamente',
                icon: 'success'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = './tablaProveedor.php';
                }
            });
        };
        </script>";
    } else {
        // Mostrar un mensaje de error usando SweetAlert
        echo "<script>
        window.onload = function() {
            Swal.fire({
                title: '¡Error!',
                text: 'Algo salió mal',
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
    <title>Editar Proveedor</title>
</head>
<body>
<!-- Modal para editar un proveedor -->
<form action="./viewModificarProveedor.php?id=<?php echo $idProveedor; ?>" class="col-4 p-3 m-auto" method="post">
    <h5 class="text-center alert alert-secondary">Modificar Proveedor</h5>
    <?php
    // Se obtienen los datos del proveedor a partir de su ID
    $sql = $objProveedor->obtenerProveedoresFiltro($idProveedor, '');

    while ($datos = $sql->fetch_object()) {?>
        <div class="mb-1">
            <label for="" class="form-label">Nombre</label>
            <input type="text" class="form-control" name="NombreProveedor" value="<?php echo $datos->NombreProveedor; ?>">
        </div>
        <div class="mb-1">
            <label for="" class="form-label">Correo</label>
            <input type="text" class="form-control" name="CorreoProveedor" value="<?php echo $datos->CorreoProveedor; ?>">
        </div>
        <div class="mb-1">
            <label for="" class="form-label">Teléfono</label>
            <input type="text" class="form-control" name="TelefonoProveedor" value="<?php echo $datos->TelefonoProveedor; ?>">
        </div>
        <div class="mb-1">
            <label for="" class="form-label">Método de Pago Aceptado</label>
            <input type="text" class="form-control" name="MetodoDePagoAceptado" value="<?php echo $datos->MetodoDePagoAceptado; ?>">
        </div><br>
    <?php } ?>
    <button type="submit" class="btn btn-primary" name="btnEditar" value="ok">Editar Proveedor</button>
    <!-- Botón para volver a la tabla de proveedores -->
    <button type="submit" class="btn btn-secondary" name="btnEditar" value="ok"><a href="./tablaProveedor.php" class="text-decoration-none text-dark">Volver</a></button>
</form>
</body>
</html>
