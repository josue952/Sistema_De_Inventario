<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página de Inicio</title>
  <link href="./resources/src/Bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="./resources/src/css/index.css" rel="stylesheet">
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Nombre del usuario</a>
      <a class="navbar-brand" href="../Sistema-de-Inventario/index.php">Inicio</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="menuInicio">Menú</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a href="#" id="loginBtn" class="nav-link">Iniciar Sesión</a>
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
              <a href="#" id="Compras" class="nav-link">Compras</a>
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
              <a href="#" id="configurarEmpresa" class="nav-link">Configurar Empresa</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
  <br><br><br>

  <!-- Login Form -->
  <div class="login-container" id="loginContainer">
    <button class="close-btn" id="closeBtn">&times;</button>
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
<!--Logica para abrir y cerrar el Login-->
  <script>
    const loginBtn = document.getElementById('loginBtn');
    const loginContainer = document.getElementById('loginContainer');
    const closeBtn = document.getElementById('closeBtn');

    loginBtn.addEventListener('click', () => {
      loginContainer.classList.add('active');
    });

    closeBtn.addEventListener('click', () => {
      loginContainer.classList.remove('active');
    });
  </script>

  <!-- Header -->
  <header class="header">
    <div class="container text-center"><br><br><br>
      <h1 class="display-4 text-black">Bienvenido a nuestro sistema de inventario</h1><br>
      <p class="lead text-black">Este sistema lo que hara es una solucion en la web, con unos diferentes tipos de empresas tanto como pequeñas y gramdes, lo que es es un sistema completo de un sistema de inventario, en este encontraremos como la compra de productos del dia, ventas que se hicieron en la tienda, las vistas de los productos que se tiene en la tienda.</p>
    </div>
  </header>

  <!-- Features Section -->
  <section class="features py-5">
    <div class="container">
      <div class="row">
        <div class="col-md-4 text-center">
          <i class="fas fa-cog fa-3x mb-3"></i>
          <h3>Mision</h3>
          <p>Como empresa que somos, lo que se busca es que la empresa tenga productos de calidad, lo que este sistema nos ayuda a estar mas organizado tanto como los productos que se maneja en los diferentes sucursales y tambien para saber cuanta seria la cantidad de productos que los clientes han comprado en cada uno de nuestras diferentes sucursales.</p>
        </div>
        <div class="col-md-4 text-center">
          <i class="fas fa-cloud fa-3x mb-3"></i>
          <h3>Vision</h3>
          <p>Esto trata de la organización para la distribucion de producto y tambien para poder saber donde están ubicados las socursalesde la Empresa.</p>
        </div>
        <div class="col-md-4 text-center">
          <i class="fas fa-heart fa-3x mb-3"></i>
          <h3>Característica 3</h3>
          <p>Descripción de la característica 3.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer bg-light py-4">
    <div class="container text-center">
      <p class="m-0">© 2024 Proyecto</p>
    </div>
  </footer>

  <!-- Bootstrap JS and dependencies -->
  <script src="./resources/src/Bootstrap/js/bootstrap.bundle.js"></script>

</body>
</html>
