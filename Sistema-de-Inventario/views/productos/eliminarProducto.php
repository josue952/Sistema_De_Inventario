<?php
// Verificar si se ha solicitado la eliminación de un usuario
if (isset($_POST['delete_id'])) {
    $idUsuario = $_POST['delete_id'];
    echo "<script>
    window.onload = function() {
        Swal.fire({
            title: '¡Éxito!',
            text: 'Usuario eliminado exitosamente',
            icon: 'success'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = './tablaUsuario.php';
            }
        });
    };
    </script>";
    $objUsuario->eliminarUsuario($idUsuario);
}
