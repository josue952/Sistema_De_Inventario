<?php
// Verificar si se ha solicitado la eliminación de un usuario
if (isset($_POST['delete_id'])) {
    $producto = $_POST['delete_id'];
    echo "<script>
    window.onload = function() {
        Swal.fire({
            title: '¡Éxito!',
            text: 'Producto eliminado exitosamente',
            icon: 'success'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = './tablaProducto.php';
            }
        });
    };
    </script>";
    $producto->eliminarUsuario($idProducto);
}
