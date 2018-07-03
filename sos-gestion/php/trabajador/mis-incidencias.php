<?php
  include '../funciones.php';
  session_start();
  comprobarTrabajador();
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
    <!-- <script type="text/javascript" src="../../js/scripts.js"></script> -->
    <title>SOS Gestión - Mis incidencias</title>
  </head>
  <body>
    <div class="container-fluid bg-panel-ver seccion"> <!-- container fluid sup -->
        <?php navSuperior(); ?>
        <div class="container pos-container"> <!-- container -->
          <div class="row"> <!-- row -->

            <div class="col-md-6 offset-md-3 al-centro"> <!-- col -->



              <a class="btn btn-success separa-bt centrar-bt" href="notificar-incidencia.php" title="notificar nueva incidencia"><!-- nueva incdencia -->
                <i class="fas fa-plus-circle"></i></i> Notificar nueva incidencia
              </a><!-- nueva incdencia -->

              <a class="btn btn-info separa-bt mov-w" href="trabajador.php" title="volver al area de administración"><!-- atras -->
                <i class="fas fa-chevron-circle-left"></i> Volver a mi panel de trabajador
              </a><!-- atras -->

            </div> <!-- col -->
          </div> <!-- row -->

          <div class="row"> <!-- row -->
            <div class="col col-md-6 offset-md-3 al-centro"> <!-- col -->
              <h1 align="center" class="separa-titulo">Mis incidencias</h1>
              <p align="center" class="ayuda "><i class="fas fa-info-circle"></i> Pulsa el botón de <b>estado</b> para cambiar el estado de una incidencia</p>
              <!-- listado de mis incidencias -->
              <?php

                  $id_trabajador = $_SESSION['id'];

                  $conexion = abrirConexion();
                  $sql_incidencia = "SELECT * FROM incidencia WHERE id_trabajador='$id_trabajador'";
                  $lista_inc = mysqli_query($conexion,$sql_incidencia);

                  if ($lista_inc) {

                    $num_incidencias = mysqli_num_rows($lista_inc);

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

                    $sql_lista_notificaciones = "SELECT id,nombre,estado,fecha,descripcion,gravedad FROM incidencia WHERE id_trabajador = '$id_trabajador' ORDER BY fecha DESC LIMIT $inicio,$paginacion";

                    $incidencias = mysqli_query($conexion,$sql_lista_notificaciones);

                    if ($incidencias) {

                      if (mysqli_num_rows($incidencias) > 0) {

                        echo "<div class='table-responsive'>"; //responsive
                        echo "<table class='table table-hover'>";
                          echo "<thead class='cabecera-tabla'>
                                    <tr>
                                      <th scope='col'>Incidencia</th>
                                      <th scope='col'>Fecha</th>
                                      <th scope='col'>Estado</th>
                                    </tr>
                                  </thead>
                                  <tbody class='tabla-incidencias'>";

                        while ($fila = mysqli_fetch_array($incidencias,MYSQLI_ASSOC)) {

                          $fecha_str = strtotime($fila['fecha']);
                          $fecha_formateada = date("d-m-Y",$fecha_str);

                          $id_incidencia = $fila['id'];

                          $estado = $fila['estado'];
                          $gravedad = $fila['gravedad'];

                            echo  "<tr>
                                      <td><button type='button' class='btn btn-info bt-accion bt-circulo' data-toggle='modal' data-target='#$fila[id]'><i class='fas fa-info-circle'></i></button> $fila[nombre]</td>
                                      <td>$fecha_formateada</td>";

                            if ($estado == 'Solventada') {

                              echo "<td><button type='button' class='btn btn-success bt-solv-in' data-toggle='modal' data-target='#$fila[id]estado'>$estado <i class='fas fa-exclamation-circle'></i></i></button></td></tr>";

                            } else {

                              echo "<td><button type='button' class='btn btn-danger bt-solv-in' data-toggle='modal' data-target='#$fila[id]estado'>$estado <i class='fas fa-exclamation-circle'></i></i></button></td></tr>";

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

                        //modal cambiar estado
                        echo "<div class='modal fade' id='$fila[id]estado' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                <div class='modal-dialog' role='document'>
                                  <div class='modal-content modal-custom'>
                                    <div class='modal-header'>
                                      <h5 class='modal-title' id='exampleModalLabel'><b>Cambiar estado de la incidencia</b></h5>
                                      <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                      </button>
                                    </div>
                                    <div class='modal-body'>
                                      <form action='#' method='post'>
                                        <div class='form-group'>
                                          <p><b>Elige el nuevo estado de la incidencia $fila[nombre]</b></p>
                                          <select name='cambiar_est'>
                                            <option value='Solventada'>Solventada</option>
                                            <option value='No solventada'>No solventada</option>
                                          </select>
                                        </div>
                                    </div>
                                    <div class='modal-footer'>
                                    <input type='hidden' name='id_inc' value='$fila[id]'>
                                    <input type='submit' name='mod' value='Cambiar estado' class='btn btn-success btn-new'>
                                      <button type='button' class='btn btn-danger' data-dismiss='modal'>Cancelar</button>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>";

                              // cambiar estado de la incidencia
                              if (isset($_POST['mod'])) {
                                $cambiar_est = $_POST['cambiar_est'];
                                $id_inc = $_POST['id_inc'];
                                $sql_cambiar = "UPDATE incidencia SET estado='$cambiar_est' WHERE id='$id_inc'";
                                $cambiar = mysqli_query($conexion,$sql_cambiar);

                                if ($cambiar) {
                                  echo "<META HTTP-EQUIV='REFRESH'CONTENT='0;URL=mis-incidencias.php'>";
                                } else {
                                  echo '<div class="alert alert-danger separador" role="alert">
                                            <h4><b>Vaya!</b> Parece que no se ha podido cambiar el estado de la incidencia</b></h4>
                                        </div>';
                                }

                              }

                        }

                      echo "</tbody></table>"; // table
                      echo "</div>"; // responsive

                      } else {

                        echo '<div class="alert alert-info separador" role="alert">
                                      <h4><b>¡Vaya, que bien!</b> parece que no tienes más incidencias</b></h4>
                                    </div>';

                      }

                    }

                  } // lista inc

                  mysqli_close($conexion);

               ?>
               <!-- listado de mis incidencias -->
            </div>
          </div> <!-- row -->
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