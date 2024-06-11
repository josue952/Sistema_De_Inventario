<?php
//Se incluye el modelo de Categoria, que utiliza la conexion a la base de datos y los metodos necesarios
//para realizar las operaciones CRUD
include_once '../../models/CategoriasModel.php';
//Se instancia la clase Categoria
$objCategoria = new Categoria();

//Parte para obtener el id de la Categoria
$idCategoria= $_GET['id'];
if (!$idCategoria) {
    die("ID de la Categoria no proporcionado.");
}

//Parte para manejar la logica para actualizar al Categoria en la base de datos
if ($_POST) {
    $nombreCategoria = $_POST['NombreCategoria'];
    $descripcion = $_POST['Descripcion'];
    $metodo = $_POST['Metodo'];

    $data = $objCategoria->actualizarCategoria($idCategoria, $nombreCategoria, $descripcion, $metodo);

    if ($data) {
        //limpiar las variables
        $nombreCategoria = '';
        $descripcion = '';
        $metodo = '';
        
        //se utiliza sweetalert para mostrar un mensaje de exito
        echo "<script>
        window.onload = function() {
            Swal.fire({
                title: '¡Éxito!',
                text: 'Categoria actualizada correctamente',
                icon: 'success'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = './tablaCategoria.php';
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
                    window.location.href = './tablaCategoria.php';
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
    <title>Editar Categoria</title>
</head>
<body>
<!--Modal para editar una Categoria-->
    <form action="./viewModificarCategoria.php?id=<?php echo $idCategoria; ?>" class="col-4 p-3 m-auto" method="post">
        <h5 class="text-center alert alert-secondary">Modificar Categoria</h5>
        <?php
        $sql = $objCategoria->obtenerCategoriaFiltro($idCategoria, '', '');

        while ($datos = $sql->fetch_object()) {?>
            <div class="mb-1">
                <label for="" class="form-label">Nombre Categoria</label>
                <input type="text" class="form-control" name="NombreCategoria" value="<?php echo $datos->Categoria; ?>">
            </div>
            <div class="mb-1">
                <label for="" class="form-label">Descripcion</label>
                <input type="text" class="form-control" name="Descripcion" value="<?php echo $datos->Descripcion; ?>">
            </div>
            <div class="mb-1">
                <label for="" class="form-label">Metodo de Inventario</label>
                <select name="Metodo" id="Metodo" class="form-control" required="required">
                <!--Respuesta predeterminada-->
                <option value="<?php echo $datos->MetodoInventario; ?>"><?php echo $datos->MetodoInventario; ?></option>
                <!--Opciones de método de pago-->
                <option value="PEPS">PEPS</option>
                <option value="UEPS">UEPS</option>
                <option value="Promedio">Promedio</option>
            </select>
            </div><br>
           
        <?php } ?>
        <button type="submit" class="btn btn-primary" name="btnEditar" value="ok">Editar Categoria</button>

        <button type="submit" class="btn btn-secondary" name="btnEditar" value="ok"><a href="./tablaCategoria.php" class="text-decoration-none text-dark">Volver</a></button>
    </form>
</body>
</html>