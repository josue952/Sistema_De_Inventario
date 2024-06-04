<?php
session_start();
require './Conexion-Base-de-Datos/dbConnection.php';

$conn = conectar();
//este parte verifica si el usuario esta o no logueado, y si no lo redirige a la pagina de inicio
if ($_POST){
    $nombreUsuario = $_POST['Usuario'];
    $contraseña = $_POST['Contraseña'];
    $sql = $conn->query("CALL obtenerUsuariosFiltro('', '$nombreUsuario', '')");
    
    if ($sql->num_rows > 0){
        $row = $sql->fetch_assoc();
        if ($row['Contraseña'] == $contraseña){
            $_SESSION['idUsuario'] = $row['idUsuario'];
            $_SESSION['Nombre'] = $row['Nombre'];
            $_SESSION['Rol'] = $row['Rol'];
            
            // Alerta con sweetalert que indica que el usuario se logueo correctamente
            echo "<script>
            window.onload = function() {
                Swal.fire({
                    title: '¡Bienvenido!',
                    text: 'Usted ha iniciado sesión correctamente',
                    icon: 'success'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './index.php'; // Redirigir a la página de inicio
                    }
                });
            };
            </script>";
            $sql->free();
        } else {
            echo "<script>
            window.onload = function() {
                Swal.fire({
                    title: '¡Error!',
                    text: 'Contraseña incorrecta',
                    icon: 'error'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './index.php';
                    }
                });
            };
            </script>";
        }
    } else {
        echo "<script>
        window.onload = function() {
            Swal.fire({
                title: '¡Error!',
                text: 'Usuario no encontrado',
                icon: 'error'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = './index.php';
                }
            });
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
    <title>Página de Inicio</title>
    <!-- Dependencias de Bootstrap -->
    <link href="./resources/src/Bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="./resources/src/css/index.css" rel="stylesheet">
    <!-- Dependencias de SweetAlert -->
    <link rel="stylesheet" href="./resources/src/SweetAlert/sweetalert2.min.css">
    <script src="./resources/src/SweetAlert/sweetalert2.min.js"></script>
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
    <?php
    $conn->next_result();
    //Este parte obtiene los datos de la empresa
    $sqlEmpresa = "SELECT * FROM empresa WHERE id = 1";
    $result = $conn->query($sqlEmpresa);
    $datosEmpresa = $result->fetch_assoc();
    $nombreEmpresa = $datosEmpresa['NombreEmpresa'];
    $urlImagenEmpresa = $datosEmpresa['LogoEmpresa'];
    $sloganEmpresa = $datosEmpresa['SloganEmpresa'];
    $misionEmpresa = $datosEmpresa['MisionEmpresa'];
    $visionEmpresa = $datosEmpresa['VisionEmpresa'];
    $abouUsEmpresa = $datosEmpresa['AboutUsEmpresa'];

    ?>
    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand navbar-center" href="../Sistema-de-Inventario/index.php">Inicio</a>
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
                                <li><a class="dropdown-item" id="Usuarios" href="./views/usuarios/tablaUsuario.php">Usuarios</a></li>
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
                            <a href="./views/compras/tablaCompras.php" id="Compras" class="nav-link">Compras</a>
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
                            <a href="./views/modifEmpresa/viewModifEmpresa.php" id="configurarEmpresa" class="nav-link">Configurar Empresa</a>
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
                    <li><a class="dropdown-item" href="./logout.php">Cerrar Sesión</a></li>
                </ul>
            </div>
            <?php endif; ?>
        </div>
    </nav>
    <br><br><br>
    <!-- Login Form -->
    <div class="login-container" id="loginContainer">
        <form class="login-form" id="loginForm" method="post">
            <h2>INICIO</h2>
            <div class="input-group">
                <input type="text" id="usuario" name="Usuario" placeholder=" " required>
                <label for="usuario">Usuario</label>
                <svg xmlns="http://www.w3.org/2000/svg" id="IconUser" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"/>
                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/>
                </svg>
            </div>
            <div class="input-group">
                <input type="password" id="contraseña" name="Contraseña" placeholder=" " required>
                <label for="contraseña">Contraseña</label>
                <svg xmlns="http://www.w3.org/2000/svg" id="IconPassword" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-lock">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z"/>
                    <path d="M10 11v-4a4 4 0 1 1 8 0v4"/>
                    <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0"/>
                    <path d="M8 11v-4a4 4 0 1 1 8 0v4"/>
                </svg>
            </div>
            <div class="options">
                <label>
                    <input type="checkbox" id="recordar">
                    Recordar
                </label>
                <a href="#" class="forgot-password">Olvidé la Contraseña</a>
            </div>
            <button type="submit">Iniciar Sesión</button>
        </form>
    </div>
    <!-- Header -->
    <!--Si el usuario no esta registrado no mostrara nada-->
    <header class="header" <?php echo !isset($_SESSION['Nombre']) ? 'style="display: none;"' : ''; ?>>
        <div class="container text-center"><br><br><br>
            <h1 class="display-4 text-black">Bienvenido a nuestro sistema de inventario</h1><br>
            <h2 class="display-5 text-black fw-bold"><?php echo $nombreEmpresa ?></h2>
            <img src="<?php echo $urlImagenEmpresa?>" alt="Imagen/Icono/Logo de la empresa">
            <p class="lead text-black fst-italic">
                <?php echo $sloganEmpresa ?>
            </p>
        </div>
    </header>

    <!-- Features Section -->
    <!--Si el usuario no esta registrado no mostrara nada-->
    <section class="features py-5" <?php echo !isset($_SESSION['Nombre']) ? 'style="display: none;"' : ''; ?>>
        <div class="container">
            <div class="row">
                <div class="text-center">
                    <i class="fas fa-cog fa-3x mb-3"></i>
                    <h3>Mision</h3>
                    <p>
                        <?php echo $misionEmpresa ?>
                    </p>
                </div>
                <div class="text-center">
                    <i class="fas fa-cloud fa-3x mb-3"></i>
                    <h3>Vision</h3>
                    <p>
                        <?php echo $visionEmpresa ?>
                    </p>
                </div>
                <div class="text-center">
                    <i class="fas fa-heart fa-3x mb-3"></i>
                    <h3>Acerca de Nosotros</h3>
                    <p>
                        <?php echo $abouUsEmpresa ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <!--Si el usuario no esta registrado no mostrara nada-->
    <footer class="footer bg-light py-4" <?php echo !isset($_SESSION['Nombre']) ? 'style="display: none;"' : ''; ?>>
        <div class="container text-center">
            <p class="m-0">© 2024 Proyecto</p>
        </div>
    </footer>

    <!-- Bootstrap JS y dependencias -->
    <script src="./resources/src/Bootstrap/js/bootstrap.bundle.js"></script>

    <!-- Logica para abrir y cerrar el Login -->
    <script>
        const loginBtn = document.getElementById('loginBtn');
        const loginContainer = document.getElementById('loginContainer');

        loginBtn.addEventListener('click', () => {
            loginContainer.classList.add('active');
        });

        // Mostrar el formulario de inicio de sesión automáticamente si el usuario no ha iniciado sesión
        <?php if (!isset($_SESSION['Nombre'])): ?>
        window.onload = function() {
            loginContainer.classList.add('active');
        };
        <?php endif; ?>
    </script>
</body>
</html>
<?php
if ($_POST) {
    $nombreEmpresa = $_POST['NombreEmpresa'];
    $logoEmpresa = $_POST['LogoEmpresa'];
    $sloganEmpresa = $_POST['SloganEmpresa'];
    $misionEmpresa = $_POST['MisionEmpresa'];
    $visionEmpresa = $_POST['VisionEmpresa'];
    $aboutUsEmpresa = $_POST['AboutUsEmpresa'];

    $datosEmpresa = array(
        'NombreEmpresa' => $nombreEmpresa,
        'LogoEmpresa' => $logoEmpresa,
        'SloganEmpresa' => $sloganEmpresa,
        'MisionEmpresa' => $misionEmpresa,
        'VisionEmpresa' => $visionEmpresa,
        'AboutUsEmpresa' => $aboutUsEmpresa
    );
}
?>

