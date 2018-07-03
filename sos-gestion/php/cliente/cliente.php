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
        <div class="container pos-container">
          <div class="row"> <!-- row -->
            <div class="col  al-centro">
              <?php
                  $tu_id = $_SESSION['id'];
                  $conexion = abrirConexion();
                  $sql_nombre = "SELECT nombre FROM cliente WHERE id='$tu_id'";
                  $tu_nombre = mysqli_query($conexion,$sql_nombre);

                  if ($tu_nombre) {

                    $fila = mysqli_fetch_array($tu_nombre, MYSQLI_ASSOC);
                    echo "<h1 align='center' class='separa-titulo'>Bienvenido, $fila[nombre]</h1>";

                  }

                  mysqli_close($conexion);
               ?>
               <h4 align="center">¿Qué quieres hacer?</h2>
                <a class="btn btn-primary separa-bt btn-block" href="datos-cliente.php" title="Ver mis datos"><!-- trabajadores -->
                  <i class="fas fa-id-card-alt"></i> Ver mis datos
                </a><!-- trabajadores -->

                <a class="btn btn-primary separa-bt btn-block" href="mis-incidencias.php" title="Mis incidencias"><!-- incidencias -->
                  <i class="fas fa-exclamation-circle"></i></i> Incidencias
                </a><!-- incidencias -->

                <a class="btn btn-primary separa-bt btn-block" href="mi-botiquin.php" title="Mi botiquín"><!-- botiquin -->
                  <i class="fas fa-prescription-bottle-alt"></i> Botiquín
                </a><!-- botiquin -->
                <?php

                  echo "<a data-toggle='modal' data-target='#$_SESSION[id]' class='btn btn-primary separa-bt btn-block col-a trab-color' title='Trabajadores actuales'><i class='fas fa-users'></i> Trabajadores</a>";

                  echo "<div class='modal fade' id='$_SESSION[id]' tabindex='-1' role='dialog' aria-labelledby='ver-datosTitle' aria-hidden='true'>
                                  <div class='modal-dialog modal-dialog-centered' role='document'>
                                    <div class='modal-content'>
                                      <div class='modal-header'>
                                        <h5 align='center' class='modal-title'>Trabajadores actuales</h5>
                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                          <span aria-hidden='true'>&times;</span>
                                        </button>
                                      </div>
                                      <div class='modal-body'>
                                      <div class='table-responsive'>
                                      <table class='table table-hover separa-titulo'>
                                      <thead class='cabecera-tabla'>
                                        <tr>
                                          <th scope='col'>Trabajador</th>
                                          <th scope='col'>Tipo</th>
                                          <th scope='col'>Teléfono de contacto</th>
                                        </tr>
                                      </thead>
                                      <tbody>";

                  $fecha_actual = date('Y-m-d');

                  $conexion = abrirConexion();
                  $sql_puesto = "SELECT id FROM puesto WHERE id_cliente='$_SESSION[id]' AND fecha_fin > $fecha_actual";
                  $puestos = mysqli_query($conexion,$sql_puesto);

                  if ($puestos) {

                    while ($puesto = mysqli_fetch_array($puestos,MYSQLI_ASSOC)) {

                      $sql_ocupados = "SELECT id_trabajador FROM ocupa WHERE id_puesto='$puesto[id]'";
                      $query_ocupados = mysqli_query($conexion,$sql_ocupados);

                      if ($query_ocupados) {

                        while ($ocupados = mysqli_fetch_array($query_ocupados,MYSQLI_ASSOC)) {

                          $sql_trabajador = "SELECT nombre,apellidos,telefono,tipo FROM trabajador WHERE id='$ocupados[id_trabajador]'";
                          $query_trabajador = mysqli_query($conexion,$sql_trabajador);

                          if ($query_trabajador) {

                            while ($trabajador = mysqli_fetch_array($query_trabajador,MYSQLI_ASSOC)) {
                              echo "<tr>
                                      <td><b>$trabajador[nombre] $trabajador[apellidos]</b></td>
                                      <td><b>$trabajador[tipo]</b></td>
                                      <td><a href='tel:$trabajador[telefono]'>$trabajador[telefono]</a></td>
                                    </tr>";
                            }

                          }

                        } // fetch ocupados

                      } // query ocupados

                    } // fetch puestos

                  } // query puestos

                  echo "</tbody></table>"; // table
                  echo "</div>"; // responsive

                  echo "</div>
                          <div class='modal-footer'>
                            <button type='button' class='btn btn-info' data-dismiss='modal'>Cerrar</button>
                          </div>
                        </div>
                      </div>
                    </div>";

                  mysqli_close($conexion);
                 ?>

            </div> <!-- col -->
            <div class="col al-centro">
                <h1 align="center" class="separa-titulo">Información rápida</h1>
                <div class="card"> <!-- info -->
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                      <?php

                        $num_trabajadores = 0;

                        $conexion = abrirConexion();
                        $sql_puesto = "SELECT id FROM puesto WHERE id_cliente='$_SESSION[id]'";

                        $puestos = mysqli_query($conexion,$sql_puesto);

                        if ($puestos) {

                          while ($puesto = mysqli_fetch_array($puestos,MYSQLI_ASSOC)) {

                            $sql_ocupados = "SELECT id_trabajador FROM ocupa WHERE id_puesto='$puesto[id]'";
                            $query_ocupados = mysqli_query($conexion,$sql_ocupados);

                            if ($query_ocupados) {
                              $num_ocupados = mysqli_num_rows($query_ocupados);
                              $num_trabajadores += $num_ocupados;
                            }

                          }

                        }

                        echo "<p align='center'><b>Trabajadores en nómina </b> <span class='badge badge-pill badge-info'>$num_trabajadores</span></p>";

                        mysqli_close($conexion);

                       ?>
                    </li>
                    <li class="list-group-item">
                      <?php

                        $conexion = abrirConexion();
                        $sql_botiquines = "SELECT id FROM botiquin WHERE id_cliente='$_SESSION[id]'";

                        $botiquines = mysqli_query($conexion,$sql_botiquines);

                        if ($botiquines) {
                          $num_bot = mysqli_num_rows($botiquines);
                          echo "<p align='center'><b>Botiquines actuales </b> <span class='badge badge-pill badge-info'>$num_bot</span></p>";
                        }

                        mysqli_close($conexion);

                       ?>
                    </li>
                    <li class="list-group-item">
                      <?php

                        $num_avisos = 0;

                        $conexion = abrirConexion();
                        $sql_botiquin = "SELECT id FROM botiquin WHERE id_cliente='$_SESSION[id]'";

                        $botiquin = mysqli_query($conexion,$sql_botiquin);

                        if ($botiquin) {

                          if (mysqli_num_rows($botiquin) > 0) {



                            while ($bot = mysqli_fetch_array($botiquin,MYSQLI_ASSOC)) {

                              $consulta_avisos = "SELECT id,fecha FROM aviso WHERE id_botiquin='$bot[id]' AND fecha BETWEEN date_sub(now(), interval 1 month)  AND NOW() ORDER BY id DESC";
                              $query_avisos = mysqli_query($conexion,$consulta_avisos);

                              if ($query_avisos) {

                                $avisos = mysqli_num_rows($query_avisos);
                                $num_avisos+=$avisos;

                              } // query avisos


                            } // while bot

                          } // rows botiquin

                        } // query botiquin

                        echo "<p align='center'><b>Avisos de stock en el último mes </b> <span class='badge badge-pill badge-info'>$num_avisos</span></p>";

                        mysqli_close($conexion);

                       ?>
                    </li>
                    <li class="list-group-item">
                      <?php

                        $conexion = abrirConexion();
                        $sql_incidencias = "SELECT id FROM incidencia WHERE id_cliente='$_SESSION[id]' AND fecha BETWEEN date_sub(now(), interval 1 month)  AND NOW() ORDER BY id DESC";

                        $incidencias = mysqli_query($conexion,$sql_incidencias);

                        if ($incidencias) {
                          $num_incidencias = mysqli_num_rows($incidencias);

                           echo "<p align='center'><b>Incidencias ocurridas el último mes </b> <span class='badge badge-pill badge-info'>$num_incidencias</span></p>";

                        }

                        mysqli_close($conexion);

                       ?>
                    </li>
                  </ul>
                </div>
            </div>
          </div><!-- row -->
        </div> <!-- col -->
      </div> <!-- container fluid sup -->
  </body>
</html>