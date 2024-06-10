<?php
session_start();
require '../../Conexion-Base-de-Datos/dbConnection.php';

if (!isset($_SESSION['Nombre'])) {
    header('Location: index.php');
    exit();
}

$directorio = '../../resources/images/';

// Abre el directorio
if ($handle = opendir($directorio)) {
    // Recorre todos los archivos y carpetas dentro del directorio
    while (false !== ($entry = readdir($handle))) {
        // Omite las entradas especiales "." y ".."
        if ($entry != "." && $entry != "..") {
            $filePath = $directorio . $entry;
            // Verifica si es un archivo antes de intentar eliminarlo
            if (is_file($filePath)) {
                unlink($filePath); // Elimina el archivo
            }
        }
    }
    closedir($handle);
}

// Redirige de vuelta a la página de configuración de la empresa con un mensaje de éxito
echo "<script>
window.onload = function() {
    Swal.fire({
        title: 'Exito!',
        text: 'Todas las imágenes han sido eliminadas.',
        icon: 'success'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = './viewModifEmpresa.php';
        }
    });
};
</script>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Dependencias de bootstrap-->
    <link href="../../resources/src/Bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="../../resources/src/Bootstrap/js/bootstrap.bundle.js"></script>
    <link href="../../resources/src/css/index.css" rel="stylesheet">
    <!--Dependencias de SweetAlert-->
    <link rel="stylesheet" href="../../resources/src/SweetAlert/sweetalert2.min.css">
    <script src="../../resources/src/SweetAlert/sweetalert2.min.js"></script>
</head>
<body>
</body>
</html>
<!-- Bootstrap JS and dependencies -->
<script src="../../resources/src/Bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../resources/src/Bootstrap/js/jquery.min.js"></script>
<script src="../../resources/src/Bootstrap/js/bootstrap.min.js"></script>
