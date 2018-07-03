<?php
  include '../funciones.php';
  session_start();
  comprobarCliente();
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
    <title>SOS Gestión - Datos de cliente</title>
  </head>
  <body>
    <div class="container-fluid bg-panel seccion"> <!-- container fluid sup -->
        <?php navSuperior(); ?>
        <div class="container pos-container">
          <div class="row"> <!-- row -->
            <div class="col-md-3 offset-md-4 al-centro coloca-botiq-pan-sup"> <!-- col -->
              <a class="btn btn-info separa-bt bot-ir-adp" href="cliente.php" title="Volver al area de administración"><!-- atras -->
                <i class="fas fa-chevron-circle-left"></i> Ir al panel de administración
              </a><!-- atras -->
            </div> <!-- col -->
          </div><!-- row -->
          <div class="row"> <!-- row -->
            <div class="col-md-6 offset-md-3  al-centro">
               <h2 class="separa-titulo" align="center">Mis datos de cliente</h2>
                <?php
                  $conexion = abrirConexion();
                  $sql_listar = "SELECT * FROM cliente WHERE id='$_SESSION[id]'";
                  $listar = mysqli_query($conexion,$sql_listar);

                  if ($listar) {

                    $fila = mysqli_fetch_array($listar,MYSQLI_ASSOC);

                    echo "<p align='center'><b>Usuario de acceso:</b><br>$fila[usuario]</p>
                                          <p align='center'><b>Nombre:</b><br>$fila[nombre]</p>
                                          <p align='center'><b>Denominación social:</b><br>$fila[denominacion_social]
                                          </p>
                                          <p align='center'><b>DNI/CIF:</b><br>$fila[dni_cif]</p>
                                          <p align='center'><b>Dirección:</b><br>$fila[direccion]</p>
                                          <p align='center'><b>Teléfono:</b><br>$fila[telefono]</p>
                                          <p align='center'><b>Email:</b><br>$fila[email]</p>";
                  }
                 ?>
            </div> <!-- col -->
          </div><!-- row -->
        </div> <!-- col -->
      </div> <!-- container fluid sup -->
  </body>
</html>