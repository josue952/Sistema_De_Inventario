<?php
session_start();
require "../../models/clienteModel.php";
$objCliente = new Cliente();

//Parte para obtener el id del cliente
$idCliente = $_GET['id'];
if (!$idCliente) {
    die("ID de cliente no proporcionado.");
}

//Parte para manejar la lógica para actualizar al cliente en la base de datos
if ($_POST) {
    $nombre = $_POST['NombreCliente'];
    $correo = $_POST['Correo'];
    $direccion = $_POST['Direccion'];
    $metodoDePago = $_POST['MetodoDePago'];
    $metodoEnvio = $_POST['MetodoEnvio'];

    $data = $objCliente->actualizarCliente($idCliente, $nombre, $correo, $direccion, $metodoDePago, $metodoEnvio);

    if ($data) {
        //limpiar las variables
        $nombre = '';
        $correo = '';
        $direccion = '';

        //se utiliza SweetAlert para mostrar un mensaje de éxito
        echo "<script>
        window.onload = function() {
            Swal.fire({
                title: '¡Éxito!',
                text: 'Cliente actualizado correctamente',
                icon: 'success'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = './tablaCliente.php';
                }
            });
        };
        </script>";
    } else {
        //se utiliza SweetAlert para mostrar un mensaje de error
        echo "<script>
        window.onload = function() {
            Swal.fire({
                title: '¡Error!',
                text: 'Algo salió mal!',
                icon: 'error'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = './tablaCliente.php';
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
    <!--Dependencias de Bootstrap-->
    <script src="../../resources/src/Bootstrap/js/bootstrap.bundle.js"></script>
    <script src="../../resources/src/Bootstrap/js/bootstrap.min.js"></script>
    <!--Dependencias de SweetAlert-->
    <script src="../../resources/src/SweetAlert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="../../resources/src/SweetAlert/sweetalert2.min.css">
    <title>Editar Cliente</title>
</head>
<body>
<!-- Modal para editar un cliente -->
<form action="./viewModificarCliente.php?id=<?php echo $idCliente; ?>" class="col-4 p-3 m-auto" method="post">
    <h5 class="text-center alert alert-secondary">Modificar Cliente</h5>
    <?php
    // Se obtienen los datos del cliente a partir de su ID
    $sql = $objCliente->obtenerClientesFiltro($idCliente, '');

    while ($datos = $sql->fetch_object()) { ?>
        <div class="mb-1">
            <label for="NombreCliente" class="form-label">Nombre</label>
            <input type="text" class="form-control" name="NombreCliente" id="NombreCliente" value="<?php echo $datos->NombreCliente; ?>" required>
        </div>
        <div class="mb-1">
            <label for="Correo" class="form-label">Correo</label>
            <input type="email" class="form-control" name="Correo" id="Correo" value="<?php echo $datos->Correo; ?>" required>
        </div>
        <div class="mb-1">
            <label for="Direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" name="Direccion" id="Direccion" value="<?php echo $datos->Direccion; ?>" required>
        </div>
        <div class="mb-1">
            <label for="MetodoDePago" class="form-label">Método de Pago</label>
            <select class="form-control" name="MetodoDePago" id="MetodoDePago" required>
                <option value="Efectivo" <?php echo ($datos->MetodoDePago == 'Efectivo') ? 'selected' : ''; ?>>Efectivo</option>
                <option value="Tarjeta" <?php echo ($datos->MetodoDePago == 'Tarjeta') ? 'selected' : ''; ?>>Tarjeta</option>
                <option value="Transferencia" <?php echo ($datos->MetodoDePago == 'Transferencia') ? 'selected' : ''; ?>>Transferencia</option>
            </select>
        </div>
        <div class="mb-1">
            <label for="MetodoEnvio" class="form-label">Método de Envío</label>
            <select class="form-control" name="MetodoEnvio" id="MetodoEnvio" required>
                <option value="Domicilio" <?php echo ($datos->MetodoEnvio == 'Domicilio') ? 'selected' : ''; ?>>Domicilio</option>
                <option value="Retiro" <?php echo ($datos->MetodoEnvio == 'Retiro') ? 'selected' : ''; ?>>Retiro</option>
            </select>
        </div>
        <br>
    <?php } ?>
    <button type="submit" class="btn btn-primary" name="btnEditar" value="ok">Editar Cliente</button>
    <!-- Botón para volver a la tabla de clientes -->
    <button type="button" class="btn btn-secondary"><a href="./tablaCliente.php" class="text-decoration-none text-dark">Volver</a></button>
</form>
</body>
</html>

