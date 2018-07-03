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
    <title>SOS Gestión - Asignar botiquín a un cliente</title>
  </head>
  <body>
    <div class="container-fluid bg-panel"> <!-- container fluid sup -->
        <?php navSuperior(); ?>
        <div class="container pos-container"> <!-- container -->
          <div class="col col-md-8 offset-md-2 col-lg-6 offset-lg-3"> <!-- col -->
            <div class="card">
              <div class="card-body tarjeta-acceder"> <!-- tarjeta -->
                <h2 class="card-title" align="center">Asignar botiquín a un cliente</h2>
                <h6 class="card-subtitle mb-2 text-muted" align="center">Elige el cliente al que le quieres asignar un nuevo botiquín</h6>
                <div class="formulario-login"> <!-- formulario asignar botiquín -->
                  <form action="#" method="post" enctype="multipart/form-data">
                    <hr>
                    <div class="form-group">  <!-- cliente -->
                    <p><b>Clientes</b></p>
                    <select name="cliente" id="cliente" class="custom-select">
                      <?php
                        $conexion = abrirConexion();
                        $sql_clientes = "SELECT id,nombre FROM cliente WHERE id NOT IN (SELECT id_cliente FROM botiquin)";
                        $clientes = mysqli_query($conexion,$sql_clientes);

                        if ($clientes) {

                          if (mysqli_num_rows($clientes) > 0) {

                            while ($cliente = mysqli_fetch_array($clientes,MYSQLI_ASSOC)) {

                              echo "<option value='$cliente[id]'>$cliente[nombre]</option>";

                            }

                          } else {

                            echo "<option disabled>Todos tus cliente ya tienen botiquín</option>";

                          }

                        }
                        mysqli_close($conexion);
                      ?>
                    </select>
                    </div> <!-- cliente -->
                    <div class="col-md-8 offset-md-2">
                      <input type="submit" name="añadir" value="Asignar botiquín" class="btn btn-success btn-new">
                      <a href="botiquin.php" class="btn btn-danger separa-titulo">Cancelar y volver</a>
                    </div>
                    <div class="col">

                    </div>
                  </form>
                </div> <!-- formulario asignar botiquín -->
              </div>
            </div> <!-- tarjeta -->
            <!-- Tratamiento del formulario -->
            <?php
              if (isset($_POST['añadir'])) { //isset añadir

                // Recojo datos del formulario
                if (isset($_POST['cliente'])) {
                  $cliente = $_POST['cliente'];
                  // abro conexion con bd y preparo la consulta para insertar
                  $conexion = abrirConexion();
                  $insertar = "INSERT INTO botiquin (id,id_cliente) VALUES (null,'$cliente')";

                  $datos = mysqli_query($conexion,$insertar);

                  // ejecuto la consulta
                  if ($datos) {
                    echo '<div class="alert alert-success separador" role="alert">
                            <h4><b>Vale!</b> Ya has asignado el botiquín al cliente</b></h4>
                            <a href="#">¿Porqué no le añades productos ya?</a></br>
                            <a href="admin-panel.php">O también puedes volver al panel de administración</a>
                          </div>';
                  } else {
                    echo '<div class="alert alert-danger separador" role="alert">
                            <h4><b>Ups!</b> parece que ha ocurrido un error al asignar el nuevo botiquín</b></h4>
                          </div>';
                  }

                  mysqli_close($conexion);
                } else {
                  echo '<div class="alert alert-danger separador" role="alert">
                            <h4><b>¡Ups!</b> No se ha podido añadir el botiquín porque todos tus clientes ya tienen asignado uno</b></h4>
                          </div>';
                }

              } // isset añadir

             ?><!-- Tratamiento del formulario -->
          </div> <!-- col -->
        </div> <!-- container -->
      </div> <!-- container fluid sup -->
  </body>
</html>