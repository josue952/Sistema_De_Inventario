<?php
require '../../models/ventasModel.php';
$objVenta = new Ventas();

// Lógica para agregar un producto o varios a la base de datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productos = $_POST['productos'];
    $idVenta = $_POST['idVenta'];
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
        $idSucursal = $producto['sucursal'];
        $subtotal = $producto['subtotal'];
        //se deja en nulo $productoExistente
        $productoExistente = null;


        if ($objVenta->productoExiste($nombreProducto)) {
            // Obtener los detalles del producto existente
            $productoExistente = $objVenta->obtenerProductoPorNombre($nombreProducto);
            $idProducto = $productoExistente['idProducto'];
            $cantidadActual = $productoExistente['Cantidad'];
            $precioExistente = $productoExistente['Precio'];
            
            //logica para ver si la cantidad a vender del producto en detalleVenta es mayor a la cantidad en productos
            if ($cantidad > $cantidadActual) {
                $productoExistente = null;
            }

            // Actualizar la cantidad del producto existente en la base de datos
            // al ser venta, se debe restar la cantidad existente con la cantidad nueva
            if ($productoExistente) {
                $resultProductoInCompra = $objVenta->gestionarProductoVenta($idVenta, $idProducto, $nombreProducto, $cantidad, $precioExistente, $idSucursal);
            }
            
        }
    }

    if ($productoExistente) {
        echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: '¡Exito!',
                    text: 'Item añadido correctamente, se ha actualizado el Stock.',
                    icon: 'success'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './tablaDetalleVentas-create.php?idVenta=$idVenta';
                    }
                });
            });
        </script>
        ";
    }else {
        echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Error',
                    text: 'Uno o más productos superan el stock disponible.',
                    icon: 'error'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './tablaDetalleVentas-create.php?idVenta=$idVenta';
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
