<?php
//Se incluye el modelo de Sucursal, que utiliza la conexion a la base de datos y los metodos necesarios
//para realizar las operaciones CRUD
include_once '../../models/SucursalModel.php';
//Se instancia la clase Sucursal
$objSucursal = new Sucursal();

//Parte para obtener el id de la Sucursal
$idSucursal = $_GET['id'];
if (!$idSucursal) {
    die("ID de la Sucursal no proporcionado.");
}

//Parte para manejar la logica para actualizar al Sucursal en la base de datos
if ($_POST) {
    $nombreS = $_POST['NombreSucursal'];
    $ubicacion = $_POST['Ubicacion'];
    $departamento = $_POST['Departamento'];
    $municipio = $_POST['Municipio'];

    $data = $objSucursal->actualizarSucursal($idSucursal, $nombreS, $ubicacion, $departamento, $municipio);

    if ($data) {
        //limpiar las variables
        $nombreS = '';
        $ubicacion = '';
        $departamento = '';
        $municipio = '';
        
        //se utiliza sweetalert para mostrar un mensaje de exito
        echo "<script>
        window.onload = function() {
            Swal.fire({
                title: '¡Éxito!',
                text: 'Sucursal actualizada correctamente',
                icon: 'success'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = './tablaSucursal.php';
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
                    window.location.href = './tablaSucursal.php';
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
    <title>Editar Sucursal</title>
</head>
<body>
<!--Modal para editar una Sucursal-->
    <form action="./viewModificarSucursal.php?id=<?php echo $idSucursal; ?>" class="col-4 p-3 m-auto" method="post">
        <h5 class="text-center alert alert-secondary">Modificar Sucursal</h5>
        <?php
        // Se obtienen los datos del Sucursal a partir de su ID
        $sql = $objSucursal->obtenerSucursalesFiltro($idSucursal, '', '', '');

        while ($datos = $sql->fetch_object()) {?>
            <div class="mb-1">
                <label for="" class="form-label">Nombre Sucursal</label>
                <input type="text" class="form-control" name="NombreSucursal" value="<?php echo $datos->NombreSucursal; ?>">
            </div>
            <div class="mb-1">
                <label for="" class="form-label">Ubicacion</label>
                <input type="text" class="form-control" name="Ubicacion" value="<?php echo $datos->Ubicacion; ?>">
            </div>
            <div class="mb-1">
                <label for="" class="form-label">Departamento</label>
                <select class="form-select" name="Departamento" id="Departamento" placeholder="Departamento" require>
                    <option selcted disable value="<?php echo $datos->Departamento; ?>"><?php echo $datos->Departamento; ?></option>
                    <option value="Ahuachapan">Ahuachapan</option>
                    <option value="Sonsonate">Sonsonate</option>
                    <option value="Santa Ana">Santa Ana</option>
                    <option value="La Libertad">La Libertad</option>
                    <option value="Chalatengo">Chalatenango</option>
                    <option value="Cabañas">Cabañas</option>
                    <option value="Cuscatlan">Cuscatlan</option>
                    <option value="San Salvador">San Salvador</option>
                    <option value="La Paz">La Paz</option>
                    <option value="San Vicente">San Vicente</option>
                    <option value="Usulutan">Usulutan</option>
                    <option value="Morazan">Morazan</option>
                    <option value="San Miguel">San Miguel</option>
                    <option value="La Union">La Union</option>
                </select>            
            </div>
            <div class="mb-1">
                <label for="" class="form-label">Municipio</label>
                <input type="text" class="form-control" name="Municipio" value="<?php echo $datos->Municipio; ?>">
            </div><br>
        <?php } ?>
        <button type="submit" class="btn btn-primary" name="btnEditar" value="ok">Editar Sucursal</button>
        <!-- Botón para volver a la tabla de proveedores -->
        <button type="submit" class="btn btn-secondary" name="btnEditar" value="ok"><a href="./tablaSucursal.php" class="text-decoration-none text-dark">Volver</a></button>
    </form>
</body>
</html>