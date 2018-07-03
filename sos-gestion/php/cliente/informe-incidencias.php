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
    <title>SOS Gestión - Panel de cliente</title>
  </head>
  <body>
    <div class="container-fluid bg-panel seccion"> <!-- container fluid sup -->
        <?php navSuperior(); ?>
        <div class="container pos-container"> <!-- container -->
          <div class="row">
            <div class="col-md-3 offset-md-4 al-centro "> <!-- col -->
              <a class="btn btn-info separa-bt bt-cli-inc" href="mis-incidencias.php" title="Volver al area de administración"><!-- atras -->
                <i class="fas fa-chevron-circle-left"></i> Volver a mis incidencias
              </a><!-- atras -->
            </div> <!-- col -->
          </div>
          <div class="row">
            <div class="col-md-6 offset-md-3">
                <p align="center" class="ayuda "><i class="fas fa-info-circle"></i><b> Aquí tienes un listado con todas las incidencias ocurridas</b></p>
            </div>
            <div class="col-md-10 offset-md-1 ">
              <?php
                  $conexion = abrirConexion();
                  $sql_lista = "SELECT * FROM incidencia WHERE id_cliente='$_SESSION[id]' ORDER BY fecha DESC";
                  $query = mysqli_query($conexion,$sql_lista);

                  if ($query) { // query

                    $num_incidencias = mysqli_num_rows($query);

                    if ($num_incidencias > 0) {
                      $paginacion = 5;
                      $pagina = false;
                    } else {
                      $paginacion = 5;
                      $pagina = false;
                    }

                    if (isset($_GET['pagina'])) {
                      $pagina = $_GET['pagina'];
                    }

                    if (!$pagina) {
                      $inicio = 0;
                      $pagina = 1;
                    } else {
                      $inicio = ($pagina - 1) * $paginacion;
                    }

                    $sql_incidencias = "SELECT * FROM incidencia WHERE id_cliente='$_SESSION[id]' ORDER BY fecha DESC LIMIT $inicio,$paginacion";
                    $incidencias = mysqli_query( $conexion, $sql_incidencias );

                    if ( $incidencias ) {

                      if (mysqli_num_rows($incidencias) > 0) {

                        echo "<div class='table-responsive'>
                              <table class='table table-hover'>
                                <thead class='cabecera-tabla'>
                                  <tr>
                                    <th scope='col'>Cliente</th>
                                    <th scope='col'>Trabajador</th>
                                    <th scope='col'>Incidencia</th>
                                    <th scope='col'>Fecha</th>
                                    <th scope='col'>Estado</th>
                                  </tr>
                                </thead>
                                <tbody class='tabla-incidencias'>";

                        // saco incidencias
                        while ( $fila = mysqli_fetch_array($incidencias, MYSQLI_ASSOC) ) {

                          $id_cli = $fila['id_cliente'];
                          $id_tra = $fila['id_trabajador'];

                          $sql_cli = "SELECT nombre FROM cliente WHERE id = '$id_cli'";
                          $cli_nom = mysqli_query($conexion,$sql_cli) or die(mysqli_error($conexion));

                          // busco nombre de cliente
                          if ($cli_nom) {

                            while ($fila_cli = mysqli_fetch_array($cli_nom,MYSQLI_ASSOC)) {

                                $sql_tra = "SELECT nombre FROM trabajador WHERE id = '$id_tra'" or die(mysqli_error($conexion));
                                $tra_nom = mysqli_query($conexion,$sql_tra);

                                // saco nombre de trabajador
                                if ($tra_nom) {

                                  while ($fila_tra = mysqli_fetch_array($tra_nom,MYSQLI_ASSOC)) {

                                    $marca_ini = strtotime($fila['fecha']);
                                    $fecha_formateada_ini = date('d-m-Y',$marca_ini);

                                    echo "<tr>
                                            <td>$fila_cli[nombre]</td>
                                            <td>$fila_tra[nombre]</td>
                                            <td><button type='button' class='btn btn-info bt-accion bt-circulo' data-toggle='modal' data-target='#$fila[id]'><i class='fas fa-info-circle'></i></button> $fila[nombre]</td>
                                            <td>$fecha_formateada_ini</td>";
                                    if ($fila['estado'] == 'Solventada') {

                                      echo "<td><button type='button' class='btn btn-success' data-toggle='modal' data-target='#$fila[id]estado'>$fila[estado] <i class='fas fa-exclamation-circle'></i></i></button></td></tr>";

                                    } else {

                                      echo "<td><button type='button' class='btn btn-danger' data-toggle='modal' data-target='#$fila[id]estado'>$fila[estado] <i class='fas fa-exclamation-circle'></i></i></button></td></tr>";

                                    }

                                    //modal descripción
                                    echo "<div class='modal fade' id='$fila[id]' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                            <div class='modal-dialog' role='document'>
                                              <div class='modal-content modal-custom'>
                                                <div class='modal-header'>
                                                  <h5 class='modal-title' id='exampleModalLabel'><b>Descripción de la incidencia</b></h5>
                                                  <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                    <span aria-hidden='true'>&times;</span>
                                                  </button>
                                                </div>
                                                <div class='modal-body'>
                                                  <p>$fila[descripcion]</p>
                                                  <p><b>Gravedad: </b>$fila[gravedad]</p>
                                                </div>
                                                <div class='modal-footer'>
                                                  <button type='button' class='btn btn-danger' data-dismiss='modal'>Cerrar</button>
                                                </div>
                                              </div>
                                            </div>
                                          </div>";





                                  }

                                }

                            }

                          }

                        }

                        echo "</tbody></table></div>"; //cierra tabla

                      } else {

                        echo '<div class="col-md-4 offset-md-4"><div class="alert alert-info separador" role="alert">
                                  <h4><b>¡Vaya, que bien!</b> parece que no tienes más incidencias en este mes</b></h4>
                                </div></div>';

                      }

                    }

                  } // query
               ?>
            </div>
          </div>
          <div class="row">
                  <div class="col-md-2 offset-md-5"> <!-- col paginacion productos -->
                        <nav aria-label="Page navigation example">
                          <ul class="pagination pag-mi-inc-tra">
                            <?php
                              echo "<li class='page-item'><a class='page-link' href='mis-incidencias.php?pagina=".($pagina - 1)."'><i class='fas fa-angle-left'></i></a></li><li class='page-item'><a class='page-link' href='mis-incidencias.php?pagina=".($pagina + 1)."'><i class='fas fa-angle-right'></i></a></li>";
                             ?>
                          </ul>
                        </nav>
                    </div> <!-- col paginacion productos -->
                </div>
        </div> <!-- container -->
    </div> <!-- container fluid sup -->
  </body>
</html>