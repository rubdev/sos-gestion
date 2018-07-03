<?php
  include '../funciones.php';
  session_start();
  comprobarAdmin();
 ?>
<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Estilos generales personalizados -->
    <link rel="stylesheet" type="text/css" href="../../css/custom-general.css">
    <!-- Optional JavaScript -->
    <!-- Font Awesome -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!-- jQuery validate forms -->
    <script type="text/javascript" src="../../js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="../../js/validaNuevoCliente.js"></script>
    <title>SOS Gestión - Nuevo trabajador</title>
  </head>
  <body>
    <div class="container-fluid bg-panel"> <!-- container fluid sup -->
        <?php navSuperior(); ?>
        <div class="container pos-container"> <!-- container -->
          <div class="col col-md-8 offset-md-2 col-lg-6 offset-lg-3"> <!-- col -->
            <div class="card">
              <div class="card-body tarjeta-acceder"> <!-- tarjeta -->
                <h2 class="card-title" align="center">Añadir un nuevo cliente</h2>
                <h6 class="card-subtitle mb-2 text-muted" align="center">Todos los campos son <b>obligatorios</b></h6>
                <div class="formulario-login"> <!-- formulario añadir trabajador -->
                  <form class="cmxform" id="validaCliente" action="#" method="post" enctype="multipart/form-data">
                    <hr>
                     <p align="center" style="color: #6c757d">Datos de acceso</p>
                    <div class="form-group">  <!-- usuario -->
                      <input type="text" name="usuario" class="form-control" id="usuario" placeholder="Usuario">
                    </div> <!-- usuario -->
                    <div class="form-group"> <!-- contraseña -->
                      <input type="password" name="pass" class="form-control" id="pass" placeholder="Contraseña"> <!-- contraseña -->
                    </div>
                    <hr>
                     <p align="center" style="color: #6c757d">Datos del cliente</p>
                    <div class="form-group">  <!-- nombre -->
                      <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre">
                    </div> <!-- nombre -->
                    <div class="form-group">  <!-- ds -->
                      <input type="text" name="ds" class="form-control" id="ds" placeholder="Denominación Social">
                    </div> <!-- ds -->
                    <div class="form-group">  <!-- dni -->
                      <input type="text" name="dni" class="form-control" id="cif" placeholder="CIF">
                    </div> <!-- dni -->
                    <div class="form-group">  <!-- direccion -->
                      <input type="text" name="direccion" class="form-control" id="direccion" placeholder="Dirección">
                    </div> <!-- direccion -->
                    <div class="form-group">  <!-- email -->
                      <input type="email" name="email" class="form-control" id="email" placeholder="Email">
                    </div> <!-- email -->
                    <div class="form-group">  <!-- telefono -->
                      <input type="number" name="telefono" class="form-control" id="telefono" placeholder="Teléfono">
                    </div> <!-- telefono -->

                    <input type="submit" name="añadir" value="Añadir cliente" class="btn btn-success btn-new">
                    <a href="ver-cliente.php" class="btn btn-danger">Cancelar y volver</a>
                  </form>
                </div> <!-- formulario añadir trabajador -->
              </div>
            </div> <!-- tarjeta -->
            <!-- Tratamiento del formulario -->
            <?php
              if (isset($_POST['añadir'])) { //isset añadir

                // Recojo datos del formulario
                $usuario = $_POST['usuario'];
                $password = $_POST['pass'];
                $nombre = $_POST['nombre'];
                $dni = $_POST['dni'];
                $direccion = $_POST['direccion'];
                $telefono = $_POST['telefono'];
                $email = $_POST['email'];
                $ds = $_POST['ds'];

                // paso md5 para proteger la contraseña
                $pass_segura = md5(md5($password));

                  // abro conexion con bd y preparo la consulta para insertar
                  $conexion = abrirConexion();
                  $insertar = "INSERT INTO cliente (id,usuario,password,email,telefono,nombre,direccion,denominacion_social,dni_cif) VALUES (null,'$usuario','$pass_segura','$email','$telefono','$nombre','$direccion','$ds','$dni')";

                  $datos = mysqli_query($conexion,$insertar);

                  // ejecuto la consulta
                  if ($datos) {
                    echo '<div class="alert alert-success separador" role="alert">
                            <h4><b>Yuhu!</b> ya tienes un nuevo cliente guardado</b></h4>
                            <a href="asignar-puesto.php">¿Porqué no le asignas un trabajador ya?</a></br>
                            <a href="admin-panel.php">O también puedes volver al panel de administración</a>
                          </div>';
                  } else {
                    echo '<div class="alert alert-danger separador" role="alert">
                            <h4><b>Ups!</b> parece que ha ocurrido un error al añadir el nuevo cliente</b></h4>
                          </div>';
                  }

              } // isset añadir

             ?><!-- Tratamiento del formulario -->
          </div> <!-- col -->
        </div> <!-- container -->
      </div> <!-- container fluid sup -->
  </body>
</html>