<?php
session_start();
require '../../Conexion-Base-de-Datos/dbConnection.php';

if (!isset($_SESSION['Nombre'])) {
    header('Location: index.php');
    exit();
}
//en este apartado accederemos a la informacion que se encuantra en la base de datos para mostrarla en la vista
$conn = conectar();
$empresa = $conn->query("SELECT * FROM empresa WHERE id = 1")->fetch_assoc();


//este apartado sirve para validar que el tipo de archivo sea el correcto

//valida que minimo un campo este lleno para actualizar la informacion
    if (!empty($_POST['btnEditarEmpresa']) && isset($_POST['btnEditarEmpresa'])){
        //obtiene el archivo temporal
        $logoEmpresa = $_FILES['LogoEmpresa']['tmp_name'];
        //obtiene el nombre del archivo
        $nombreLogo = $_FILES['LogoEmpresa']['name'];
        //obtiene la extensión del archivo
        $tipoLogo = strtolower(pathinfo($nombreLogo, PATHINFO_EXTENSION));
        //permite obtener el tamaño del archivo en bytes
        $sizeLogo = $_FILES['LogoEmpresa']['size'];
        $directorio = 'resources/images/';
    
        //valida que el archivo sea de tipo jpg, jpeg, png o gif
        if ($tipoLogo == 'jpg' || $tipoLogo == 'jpeg' || $tipoLogo == 'png' || $tipoLogo == 'gif'){
            //valida que ningun campo este vacio
            if ($_POST['NombreEmpresa'] != '' || $nombreLogo != '' || $_POST['SloganEmpresa'] != '' || $_POST['MisionEmpresa'] != '' || $_POST['VisionEmpresa'] != '' || $_POST['AboutUsEmpresa'] != ''){
                $ruta = $directorio.$nombreLogo;
                $conn->query("UPDATE empresa SET NombreEmpresa = '".$_POST['NombreEmpresa']."', LogoEmpresa = '".$ruta."', SloganEmpresa = '".$_POST['SloganEmpresa']."', MisionEmpresa = '".$_POST['MisionEmpresa']."', VisionEmpresa = '".$_POST['VisionEmpresa']."', AboutUsEmpresa = '".$_POST['AboutUsEmpresa']."' WHERE id = 1");
                //almacenar el archivo en la carpeta resources/images
                if (move_uploaded_file($logoEmpresa, '../../'.$ruta)){
                    echo "<script>
                    window.onload = function() {
                        Swal.fire({
                            title: '¡Exito!',
                            text: 'Se ha guardado la configuración de la empresa correctamente',
                            icon: 'success'
                        })= function() {
                            window.location = 'viewModifEmpresa.php';
                        };
                    };
                    </script>";
                }else{
                    echo "<script>
                    window.onload = function() {
                        Swal.fire({
                            title: '¡Error!',
                            text: 'No se ha podido guardar la configuración de la empresa',
                            icon: 'error'
                        });
                    };
                    </script>";
                }
        }else{
            echo "<script>
            window.onload = function() {
                Swal.fire({
                    title: '¡Error!',
                    text: 'El archivo no es de tipo imagen',
                    icon: 'error'
                });
            };
            </script>";
        
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurar Empresa</title>
    <!--Dependencias de bootstrap-->
    <link href="../../resources/src/Bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../resources/src/css/index.css" rel="stylesheet">
    <!--Dependencias de SweetAlert-->
    <link rel="stylesheet" href="../../resources/src/SweetAlert/sweetalert2.min.css">
    <script src="../../resources/src/SweetAlert/sweetalert2.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1>Configurar Empresa</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="NombreEmpresa" class="form-label">Nombre de la Empresa</label>
                <input type="text" class="form-control" id="NombreEmpresa" name="NombreEmpresa" value="<?php echo $empresa['NombreEmpresa']?>">
            </div>
            <div class="mb-3">
                <label for="LogoEmpresa" class="form-label">Logo de la Empresa</label><br>
                <input type="file" class="form-control" id="LogoEmpresa" name="LogoEmpresa">
                <br>
                <?php echo "<img src='../../".$empresa['LogoEmpresa']."' alt='Logo actual' width='100'>"?>
            </div>
            <div class="mb-3">
                <label for="SloganEmpresa" class="form-label">Slogan de la Empresa</label>
                <input type="text" class="form-control" id="SloganEmpresa" name="SloganEmpresa" value="<?php echo $empresa['SloganEmpresa']?>">
            </div>
            <div class="mb-3">
                <label for="MisionEmpresa" class="form-label">Misión de la Empresa</label>
                <textarea class="form-control" id="MisionEmpresa" name="MisionEmpresa" rows="3">
                <?php echo $empresa['MisionEmpresa']?>
                </textarea>
            </div>
            <div class="mb-3">
                <label for="VisionEmpresa" class="form-label">Visión de la Empresa</label>
                <textarea class="form-control" id="VisionEmpresa" name="VisionEmpresa" rows="3" >
                <?php echo $empresa['VisionEmpresa']?>
                </textarea>
            </div>
            <div class="mb-3">
                <label for="AboutUsEmpresa" class="form-label">Acerca de Nosotros</label>
                <textarea class="form-control" id="AboutUsEmpresa" name="AboutUsEmpresa" rows="3">
                <?php echo $empresa['AboutUsEmpresa']?>
                </textarea>
            </div>
            <input type="submit" class="btn btn-primary" name="btnEditarEmpresa" value="Guardar Configuracion">
            <button class="btn btn-secondary"><a class="text-decoration-none text-dark" href="../../index.php">Volver</a></button>
        </form>
    </div>
    <script src="./resources/src/Bootstrap/js/bootstrap.bundle.js"></script>
</body>
</html>
