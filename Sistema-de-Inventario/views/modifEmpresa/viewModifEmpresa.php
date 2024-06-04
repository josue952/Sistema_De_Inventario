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

    //este apartado se ejecuta cuando hay una imagen que se enviara
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
                            window.location = '../../index.php';
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
    }else if ($_POST){
        //este apartado se ejecuta cuando no hay una imagen que se enviara
        $conn->query("UPDATE empresa SET NombreEmpresa = '".$_POST['NombreEmpresa']."', SloganEmpresa = '".$_POST['SloganEmpresa']."', MisionEmpresa = '".$_POST['MisionEmpresa']."', VisionEmpresa = '".$_POST['VisionEmpresa']."', AboutUsEmpresa = '".$_POST['AboutUsEmpresa']."' WHERE id = 1");
        echo "<script>
        window.onload = function() {
            Swal.fire({
                title: '¡Exito!',
                text: 'Se ha guardado la configuración de la empresa correctamente',
                icon: 'success'
            })= function() {
                window.location = '../../index.php';
            };
        };
        </script>";

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
    <script src="../../resources/src/Bootstrap/js/bootstrap.bundle.js"></script>
    <link href="../../resources/src/css/index.css" rel="stylesheet">
    <!--Dependencias de SweetAlert-->
    <link rel="stylesheet" href="../../resources/src/SweetAlert/sweetalert2.min.css">
    <script src="../../resources/src/SweetAlert/sweetalert2.min.js"></script>
    <style>
        /* Estilo para centrar el enlace de Inicio */
        .navbar-center {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }
    </style>

</head>
<body>
    <!--nav bar-->
    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand navbar-center" href="../../index.php">Inicio</a>
            <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="menuInicio">Menú</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <?php if (!isset($_SESSION['Nombre'])): ?>
                        <li class="nav-item">
                            <a href="#" id="loginBtn" class="nav-link">Iniciar Sesión</a>
                        </li>
                        <?php else: ?>
                        <li class="nav-item">
                            <a href="#" id="loginBtn" class="nav-link">Panel de Control</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Administración
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" id="Usuarios" href="../../views/usuarios/tablaUsuario.php">Usuarios</a></li>
                                <li><a class="dropdown-item" id="Categorias" href="#">Categorias</a></li>
                                <li><a class="dropdown-item" id="Sucursales" href="#">Sucursales</a></li>
                                <li><a class="dropdown-item" id="Proveedores" href="#">Proveedores</a></li>
                                <li><a class="dropdown-item" id="Clientes" href="#">Clientes</a></li>
                                <li>
                                <hr class="dropdown-divider">
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="../../views/compras/tablaCompras.php" id="Compras" class="nav-link">Compras</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" id="Productos" class="nav-link">Productos</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" id="Ventas" class="nav-link">Ventas</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" id="Entradas" class="nav-link">Entradas</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" id="Salidas" class="nav-link">Salidas</a>
                        </li>
                        <li class="nav-item">
                            <a href="../../views/modifEmpresa/viewModifEmpresa.php" id="configurarEmpresa" class="nav-link">Configurar Empresa</a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <?php if (isset($_SESSION['Nombre'])): ?>
            <div class="dropdown ms-auto">
                <a class="navbar-brand dropdown-toggle" href="#" id="usuarioDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo $_SESSION['Nombre']; ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="usuarioDropdown">
                    <li><a class="dropdown-item" href="#">Rol: <?php echo $_SESSION['Rol']; ?></a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="../../logout.php">Cerrar Sesión</a></li>
                </ul>
            </div>
            <?php endif; ?>
        </div>
    </nav>
    <br><br><br>

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
                <label for="LogoActual" class="form-label">Logo Actual de la Empresa</label><br>
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
<script>
$('.dropdown-toggle').click(function() {
    $(this).next('.dropdown-menu').toggleClass('show');
});

$(document).click(function (e) {
    var container = $(".dropdown");
    if (!container.is(e.target) && container.has(e.target).length === 0) {
        container.find('.dropdown-menu').removeClass('show');
    }
});

</script>
