<?php
// Se incluye el modelo de entrada, que utiliza la conexión a la base de datos y los métodos necesarios
include_once '../../models/entrada.php';

// Se instancia la clase Entrada
$objEntrada = new Entradas();

// Se obtiene el ID de la entrada de la URL
$idEntrada = $_GET['id'];
if (!$idEntrada) {
    die("ID de entrada no proporcionado.");
}

// Manejo de la lógica para actualizar la entrada en la base de datos
if ($_POST) {
    $fechaEntrada = $_POST['FechaEntrada'];
    $idProducto = $_POST['idProducto'];
    $motivo = $_POST['Motivo'];
    $cantidad = $_POST['Cantidad'];
    $idProveedor = isset($_POST['idProveedor']) ? $_POST['idProveedor'] : NULL;

    $data = $objEntrada->actualizarEntrada($idEntrada, $fechaEntrada, $idProducto, $motivo, $cantidad, $idProveedor);

    if ($data) {
        // Limpiar las variables
        $fechaEntrada = '';
        $idProducto = '';
        $motivo = '';
        $cantidad = '';
        $idProveedor = '';

        // Mostrar un mensaje de éxito usando SweetAlert
        echo "<script>
        window.onload = function() {
            Swal.fire({
                title: '¡Éxito!',
                text: 'Entrada actualizada correctamente',
                icon: 'success'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = './tablaEntradas.php';
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
                    window.location.href = './tablaEntradas.php';
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
    <title>Editar Entrada</title>
</head>
<body>
<!-- Modal para editar una entrada -->
<form action="./viewModificarEntrada.php?id=<?php echo $idEntrada; ?>" class="col-4 p-3 m-auto" method="post">
    <h5 class="text-center alert alert-secondary">Modificar Entrada</h5>
    <?php
    // Se obtienen los datos de la entrada a partir de su ID
    $sql = $objEntrada->obtenerEntradasFiltro($idEntrada, '');

    if ($datos = $sql->fetch_object()) { ?>
        <div class="mb-1">
            <label for="FechaEntrada" class="form-label">Fecha de Entrada</label>
            <input type="date" class="form-control" name="FechaEntrada" value="<?php echo $datos->FechaEntrada; ?>" required>
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
            <label for="idProveedor" class="form-label">ID Proveedor (opcional)</label>
            <input type="number" class="form-control" name="idProveedor" value="<?php echo $datos->idProveedor; ?>">
        </div><br>
    <?php } else {
        echo "<p class='text-center'>No se encontró la entrada con ID {$idEntrada}</p>";
    } ?>
    <button type="submit" class="btn btn-primary" name="btnEditar" value="ok">Editar Entrada</button>
    <!-- Botón para volver a la tabla de entradas -->
    <button type="button" class="btn btn-secondary"><a href="./tablaEntradas.php" class="text-decoration-none text-dark">Volver</a></button>
</form>
</body>
</html>
