<?php

require "../../models/usuarioModel.php";
$objUsuario = new Usuario();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../resources/src/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../resources/src/css/lobibox.css">
    <link rel="stylesheet" href="../../resources/src/css/select2.css">
    <link rel="stylesheet" href="../../resources/src/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="../../resources/src/css/select2.css">
    <link rel="stylesheet" href="../../resources/src/css/waitMe.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.bootstrap4.min.css">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <title>Document</title>
</head>
<body class="bg-light">
    <div class="container mt-4 bg-white rounded p-4 shadow">
        
        <div class="row">
            <div class="col-md-8">
                <h1>FORMULARIO PRUEBA</h1>
            </div>
            <div class="col-md-4 text-lg-center">
                <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modal-agregar">
                    Agregar registro
                </button>
            </div>
        </div>
        <hr>

        <div class="table-responsive mt-5">
            <table class="table table-bordered table-hover" id="tabla-datos">
                <thead class="bg-primary text-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>DUI</th>
                        <th>Rol</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- tu codigo php con los datos (for o foreach) -->
                    <?php
                    $data=$objUsuario->obtenerUsuarios();
                    foreach( $data as $objUsuario){
                        echo"<tr>";
                        echo "<td>".$objUsuario["Nombre"]."</td>";
                        echo "<td>".$objUsuario["Apellido"]."</td>";
                        echo "<td>".$objUsuario["Email"]."</td>";
                        echo "<td>".$objUsuario["DUI"]."</td>";
                        echo "<td>".$objUsuario["Rol"]."</td>";
                        echo"</tr>";
                    }
             
                    ?>

                </tbody>
            </table>
        </div>
    </div>



    <!-- Modal -->
<div class="modal fade" id="modal-agregar" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Formulario de registro de Usuarios</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="">
            <div class="row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="TXTnombre" id="Nombre" placeholder="Nombre">
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="TXTapellido" id="Apellido" placeholder="Apellido">
                </div>
                <div class="form-group col-md-6">
                    <input type="number" class="form-control" name="TXTedad" id="Edad" placeholder="Edad">
                </div>
                <div class="form-group col-md-6">
                    <input type="email" class="form-control" name="TXTEmail" id="Email" placeholder="example@gmail.com">
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="TXTdui" id="DUI" placeholder="DUI">
                </div>
                <div class="form-group col-md-6">
                    <input type="password" class="form-control" name="TXTcontraseña" id="Contraseña">
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="TXTrol" id="Rol" placeholder="Rol">
                </div>
            </div>
        </form>
        
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-primary">Guardar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

    
</body>
<script src="../../resources/src/js/waitMe.min.js"></script>
<script src="../../resources/src/js/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
<script src="../../resources/src/js/bootstrap.min.js"></script>
<script src="../../resources/src/js/popper.min.js"></script>
<script src="../../resources/src/js/lobibox.js"></script>
<script src="../../resources/src/js/notifications.js"></script>
<script src="../../resources/src/js/messageboxes.js"></script>
<script src="../../resources/src/js/datatables.min.js"></script>
<script src="../../resources/src/js/dataTables.bootstrap4.min.js"></script>
<script src="../../resources/src/js/select2.js"></script>
<script src="../../resources/src/js/sweetalert.min.js"></script>
<script>
    $(document).ready(function(){
        $("#tabla-datos").DataTable();
    });
</script>
</html>