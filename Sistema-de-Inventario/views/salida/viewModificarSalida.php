<?php
// Se incluye el modelo de salidaa, que utiliza la conexión a la base de datos y los métodos necesarios
include_once '../../models/salida.php';

// Se instancia la clase salida
$objSalida = new Salidas();

// Se obtiene el ID de la salida de la URL
$idSalida = $_GET['id'];
if (!$idSalida) {
    die("ID de Salida no proporcionado.");
}

// Manejo de la lógica para actualizar la Salida en la base de datos
if ($_POST) {
    $fechaSalida = $_POST['FechaSalida'];
    $idProducto = $_POST['idProducto'];
    $motivo = $_POST['Motivo'];
    $cantidad = $_POST['Cantidad'];
    $idCliente = isset($_POST['idCliente']) ? $_POST['idCliente'] : NULL;

    $data = $objSalida->actualizarSalida($idSalida, $fechaSalida, $idProducto, $motivo, $cantidad, $idSalida);

    if ($data) {
        // Limpiar las variables
        $fechaSalida = '';
        $idProducto = '';
        $motivo = '';
        $cantidad = '';
        $idCliente = '';

        // Mostrar un mensaje de éxito usando SweetAlert
        echo "<script>
        window.onload = function() {
            Swal.fire({
                title: '¡Éxito!',
                text: 'Entrada actualizada correctamente',
                icon: 'success'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = './tablaSalidas.php';
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
                    window.location.href = './tablaSalidas.php';
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
    <link rel="stylesheet" href="../../resources/src/Bootstrap/css/bootstrap.min.css">
    <!--Dependencias de bootstrap-->
    <script src="../../resources/src/Bootstrap/js/bootstrap.bundle.js"></script>
    <script src="../../resources/src/Bootstrap/js/bootstrap.min.js"></script>
    <!--Dependencias de SweetAlert-->
    <script src="../../resources/src/SweetAlert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="../../resources/src/SweetAlert/sweetalert2.min.css">
    <title>Editar Salida</title>
</head>
<body>
<!-- Modal para editar una salida -->
<form action="./viewModificarSalida.php?id=<?php echo $idSalida; ?>" class="col-4 p-3 m-auto" method="post">
    <h5 class="text-center alert alert-secondary">Modificar Salida</h5>
    <?php
    // Se obtienen los datos de la entrada a partir de su ID
    $sql = $objSalida->obtenerSalidasFiltro($idSalida, '');

    if ($datos = $sql->fetch_object()) { ?>
        <div class="mb-1">
            <label for="FechaSalida" class="form-label">Fecha de Salida</label>
            <input type="date" class="form-control" name="FechaSalida" value="<?php echo $datos->FechaSalida; ?>" required>
        </div>
        <div class="mb-1">
            <label for="idProducto" class="form-label">ID Producto</label>
            <input type="number" class="form-control" name="idProducto" value="<?php echo $datos->idProducto; ?>" required>
        </div>
        <div class="mb-1">
            <label for="Motivo" class="form-label">Motivo</label>
            <input type="text" class="form-control" name="Motivo" value="<?php echo $datos->Motivo; ?>" required>
        </div>
        <div class="mb-1">
            <label for="Cantidad" class="form-label">Cantidad</label>
            <input type="number" class="form-control" name="Cantidad" value="<?php echo $datos->Cantidad; ?>" required>
        </div>
        <div class="mb-1">
            <label for="idCliente class="form-label">ID Cliente (opcional)</label>
            <input type="number" class="form-control" name="idCliente" value="<?php echo $datos->idCliente; ?>">
        </div><br>
    <?php } else {
        echo "<p class='text-center'>No se encontró la salida con ID {$idSalida}</p>";
    } ?>
    <button type="submit" class="btn btn-primary" name="btnEditar" value="ok">Editar Salida</button>
    <!-- Botón para volver a la tabla de Salidas -->
    <button type="button" class="btn btn-secondary"><a href="./tablaSalidas.php" class="text-decoration-none text-dark">Volver</a></button>
</form>
</body>
</html>
