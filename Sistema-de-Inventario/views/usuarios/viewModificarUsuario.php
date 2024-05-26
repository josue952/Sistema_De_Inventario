<?php
//Se incluye el modelo de usuario, que utiliza la conexion a la base de datos y los metodos necesarios
//para realizar las operaciones CRUD
include_once '../../models/usuarioModel.php';
//Se instancia la clase Usuario
$objUsuario = new Usuario();

//Parte para obtener el id del usuario
$idUsuario = $_GET['id'];
if (!$idUsuario) {
    die("ID de usuario no proporcionado.");
}

//Parte para manejar la logica para actualizar al usuario en la base de datos
if ($_POST) {
    $nombre = $_POST['Nombre'];
    $apellido = $_POST['Apellido'];
    $email = $_POST['Email'];
    $dui = $_POST['DUI'];
    $contraseña = $_POST['Contraseña'];
    $rol = $_POST['Rol'];

    $data = $objUsuario->actualizarUsuario($idUsuario, $nombre, $apellido, $email, $dui, $contraseña, $rol);

    if ($data) {
        echo "<script>alert('Usuario actualizado correctamente');</script>";
        echo "<script>window.location.href='./tablaUsuario.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar el usuario');</script>";
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
    <title>Editar Usuario</title>
</head>
<body>
<!--Modal para editar un usuario-->
    <form action="./viewModificarUsuario.php?id=<?php echo $idUsuario; ?>" class="col-4 p-3 auto" method="post">
        <h5 class="text-center alert alert-secondary">Modificar Usuario</h5>
        <?php
        $sql = $objUsuario->obtenerUsuariosFiltro($idUsuario, '', '');

        while ($datos = $sql->fetch_object()) {?>
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
                <input type="text" class="form-control" name="Rol" value="<?php echo $datos->Rol; ?>">
            </div><br>
        <?php } ?>
        <button type="submit" class="btn btn-primary" name="btnEditar" value="ok">Editar Usuario</button>
    </form>
</body>
</html>
