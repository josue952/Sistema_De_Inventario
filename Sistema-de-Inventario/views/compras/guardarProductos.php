<?php
require '../../models/comprasModel.php';
$objCompra = new Compra();

// Lógica para agregar un producto o varios a la base de datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productos = $_POST['productos'];
    $idCompra = $_POST['idCompra'];
    $todosInsertados = true;

    // Logica para realizar o cear una normalizacion de nombres en un producto,
    // Por ejemplo si el usuario ingresa un producto con mayusculas o minusculas
    // Pero refiriendose al mismo producto, se debe normalizar el nombre para que
    // no se dupliquen productos en la base de datos
    function normalizarNombreProducto($nombre) {
        return strtolower(trim($nombre));
    }

    foreach ($productos as $producto) {
        $nombreProducto = normalizarNombreProducto($producto['nombreProducto']);
        $cantidad = $producto['cantidad'];
        $precio = $producto['precio'];
        $subtotal = $producto['subtotal'];
        //se deja en nulo $productoExistente
        $productoExistente = null;

        if ($objCompra->productoExiste($nombreProducto)) {
            // Obtener los detalles del producto existente
            $productoExistente = $objCompra->obtenerProductoPorNombre($nombreProducto);
            $cantidadExistente = $productoExistente['Cantidad'];
            $precioExistente = $productoExistente['Precio'];
            
            // Calcular la nueva cantidad
            $nuevaCantidad = $cantidadExistente + $cantidad;


            // Actualizar la cantidad del producto existente en la base de datos
            if ($productoExistente) {
                $resultProductoInCompra = $objCompra->gestionarProductoCompra($idCompra, $nombreProducto, $cantidad, $nuevaCantidad, $precioExistente);
                if (!$resultProductoInCompra) {
                    $todosInsertados = false;
                    break;
                }
            }
        } else {
            //Si se trata de un nuevo producto que no exista en la base de datos
            $resultProductoInCompra = $objCompra->agregarProductoACompra($idCompra, $nombreProducto, $cantidad, $precio, $subtotal);
            if (!$resultProductoInCompra) {
                $todosInsertados = false;
                break;
            }
        }
    }

    if ($productoExistente) {
        echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: '¡Atención!',
                    text: 'Hay uno o mas productos duplicados en la compra, se han sumado las cantidades.',
                    icon: 'warning'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './tablaDetalleCompras-create.php?idCompra=$idCompra';
                    }
                });
            });
        </script>
        ";
    }else if($todosInsertados){
        echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: '¡Éxito!',
                    text: '¡¡Productos Registrados correctamente!!',
                    icon: 'success'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './tablaDetalleCompras-create.php?idCompra=$idCompra';
                    }
                });
            });
        </script>
        ";
    } else {
        echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al añadir los productos.',
                    icon: 'error'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './tablaCompras.php';
                    }
                });
            });
        </script>
        ";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Dependencias de SweetAlert -->
    <script src="../../resources/src/SweetAlert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="../../resources/src/SweetAlert/sweetalert2.min.css">
    <title>Guardar Productos</title>
</head>
<body>
</body>
</html>
