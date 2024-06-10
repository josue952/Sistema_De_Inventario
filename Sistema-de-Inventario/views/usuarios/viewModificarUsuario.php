<?php
include_once '../../models/usuarioModel.php';
$objUsuario = new Usuario();

// Parte para obtener el id del usuario
$idUsuario = isset($_POST['idUsuario']) ? $_POST['idUsuario'] : (isset($_GET['id']) ? $_GET['id'] : null);
if (!$idUsuario) {
    die("ID de usuario no proporcionado.");
}

// Parte para manejar la lógica para actualizar al usuario en la base de datos
if (isset($_POST['btnEditar'])) {
    $nombre = $_POST['Nombre'];
    $apellido = $_POST['Apellido'];
    $email = $_POST['Email'];
    $dui = $_POST['DUI'];
    $contraseña = $_POST['Contraseña'];
    $rol = $_POST['Rol'];

    if ($objUsuario->verificarDUIExistente($dui, $idUsuario)) {
        echo "<script>
            window.onload = function() {
                Swal.fire({
                    title: '¡Error!',
                    text: 'El DUI ya está registrado',
                    icon: 'error'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './viewModificarUsuario.php?id=$idUsuario';
                    }
                });
            };
        </script>";
    } else {
        $data = $objUsuario->actualizarUsuario($idUsuario, $nombre, $apellido, $email, $dui, $contraseña, $rol);
        if ($data) {
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
            echo "<script>
            window.onload = function() {
                Swal.fire({
                    title: '¡Error!',
                    text: 'Algo salió mal!',
                    icon: 'error'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './viewModificarUsuario.php?id=$idUsuario';
                    }
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
    <title>Editar Usuario</title>
</head>
<body>
    <form action="./viewModificarUsuario.php?id=<?php echo $idUsuario; ?>" class="col-4 p-3 m-auto" method="post">
        <h5 class="text-center alert alert-secondary">Modificar Usuario</h5>
        <?php
        $sql = $objUsuario->obtenerUsuariosFiltro($idUsuario, '', '');

        while ($datos = $sql->fetch_object()) { ?>
            <div class="mb-1">
                <label for="" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="Nombre" value="<?php echo $datos->Nombre; ?>">
            </div>
            <div class="mb-1">
                <label for="" class="form-label">Apellido</label>
                <input type="text" class="form-control" name="Apellido" value="<?php echo $datos->Apellido; ?>">
            </div>
            <div class="mb-1">
                <label for="" class="form-label">Email</label>
                <input type="text" class="form-control" name="Email" value="<?php echo $datos->Email; ?>">
            </div>
            <div class="mb-1">
                <label for="" class="form-label">DUI</label>
                <input type="text" class="form-control" name="DUI" value="<?php echo $datos->DUI; ?>">
            </div>
            <div class="mb-1">
                <label for="" class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="Contraseña" value="<?php echo $datos->Contraseña; ?>">
            </div>
            <div class="mb-1">
                <label for="" class="form-label">Rol</label>
                <select name="MetodoDePagoAceptado" id="MetodoDePagoAceptado" class="form-control" required="required">
                <!--Respuesta predeterminada-->
                <option value="<?php echo $datos->Rol; ?>"><?php echo $datos->Rol; ?></option>
                <!--Opciones de Roles-->
                <option value="Administrador">Administrador</option>
                <option value="Empleado">Empleado</option>
                <option value="Cajero">Cajero</option>
            </select>

            </div><br>
            <input type="hidden" name="idUsuario" value="<?php echo $idUsuario; ?>">
        <?php } ?>
        <button type="submit" class="btn btn-primary" name="btnEditar" value="ok">Editar Usuario</button>
        <button type="button" class="btn btn-secondary"><a href="./tablaUsuario.php" class="text-decoration-none text-dark">Volver</a></button>
    </form>
</body>
</html>
