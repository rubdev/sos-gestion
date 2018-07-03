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
    <title>SOS Gestión - Retirar trabajador del puesto</title>
  </head>
  <body>
    <div class="container-fluid bg-panel seccion"> <!-- container fluid sup -->
        <?php navSuperior(); ?>
        <div class="container pos-container"> <!-- container -->
          <div class="col col-md-8 offset-md-2 col-lg-6 offset-lg-3"> <!-- col -->
            <div class="card">
              <div class="card-body tarjeta-acceder"> <!-- tarjeta -->
                <h2 class="card-title" align="center">Retirar trabajador de su puesto</h2>
                <h6 class="card-subtitle mb-2 text-muted" align="center">Un trabajo llega a su fin</h6>
                <hr>
                     <p align="center" class="ayuda"><i class="fas fa-info-circle"></i> Pulsa el botón eliminar para retirar al trabajador del puesto</p>
                <div class="formulario-login"> <!-- listado de puestos cubiertos -->
                  <?php //lista puestos con opción borrar

                    // abro conexión con la bd y preparo la consulta para listar puestos ocupados
                    $conexion = abrirConexion();
                    $sql_ocupa = "SELECT * FROM ocupa";
                    $ocupados = mysqli_query($conexion,$sql_ocupa);

                    if ($ocupados) { // ocupados pag

                      $num_ocupados = mysqli_num_rows($ocupados);

                      if ($num_ocupados > 0) {
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

                      $sql_trabajador = "SELECT o.id_trabajador, o.id_puesto, t.id, t.nombre,t.tipo FROM ocupa o, trabajador t WHere o.id_trabajador=t.id LIMIT $inicio,$paginacion";
                      $trabajador = mysqli_query($conexion,$sql_trabajador);

                      if ($trabajador) {

                        if (mysqli_num_rows($trabajador) > 0) {

                          echo "<div class='table-responsive'>"; //responsive
                                echo "<table class='table table-hover'>";
                                  echo "<thead class='cabecera-tabla'>
                                            <tr>
                                              <th scope='col'>Trabajador</th>
                                              <th scope='col'>Fecha de ocupación</th>
                                              <th scope='col'>Para el cliente</th>
                                              <th scope='col'>Tipo de puesto</th>
                                              <th scope='col'>Retirar trabajador</th>
                                            </tr>
                                        </thead>
                                        <tbody>";

                          while ($fila = mysqli_fetch_array($trabajador, MYSQLI_ASSOC)) {

                            $id_puesto = $fila['id_puesto'];

                            $sql_cliente = "SELECT p.id as id_pu, p.fecha_inicio, p.id_cliente, c.id as id_cli, c.nombre FROM puesto p, cliente c WHERE p.id_cliente=c.id AND p.id = $id_puesto";

                            $cliente = mysqli_query($conexion,$sql_cliente);

                            if ($cliente) {

                              if (mysqli_num_rows($cliente) > 0) {

                                while ($fila2 = mysqli_fetch_array($cliente,MYSQLI_ASSOC)) {

                                  $marca_ini = strtotime($fila2['fecha_inicio']);
                                  $fecha_formateada = date("d-m-Y", $marca_ini);

                                  echo  "<tr>
                                          <td>$fila[nombre]</td>
                                          <td>$fecha_formateada</td>
                                          <td>$fila2[nombre]</td>
                                          <td>$fila[tipo]</td>
                                          <td><form action='#' method='post'><input type='hidden' name='id' value='$fila[id_trabajador]'><button class='alert-danger' type='submit' name='retirar'><i class='fas fa-trash-alt'></i></button></form></td>
                                        </tr>";

                                }

                              }

                            }

                          }

                        } else {
                          echo '<div class="alert alert-info separador" role="alert">
                                <h4><b>¡Vaya!</b> Parece que no tienes más trabajadores ocupados para listar</b></h4>
                              </div>';
                        }

                        echo "</tbody></table>"; // table

                        echo "</div>"; // responsive
                        echo "<a href='gestion-puestos.php' class='btn btn-danger bt-ret-pu'>Cancelar y volver</a>";
                        ?>
                        <div class="col-md-5 offset-md-5">
                          <nav aria-label="Page navigation example">
                          <ul class="pagination ret-pu-pag">
                            <?php
                              echo "<li class='page-item'><a class='page-link' href='retirar-puesto.php?pagina=".($pagina - 1)."'><i class='fas fa-angle-left'></i></a></li><li class='page-item'><a class='page-link' href='retirar-puesto.php?pagina=".($pagina + 1)."'><i class='fas fa-angle-right'></i></a></li>";
                             ?>
                          </ul>
                          </nav>
                          </div>
                        <?php

                      } else {

                        echo '<div class="alert alert-danger separador" role="alert">
                                  <h4>Ups, ha ocurrido un <b>error</b> al buscar tus puestos de trabajo ocupados</b></h4>
                                  <p>Por favor, inténtelo de nuevo</p>
                                </div>';
                        echo "<META HTTP-EQUIV='REFRESH'CONTENT='5;URL=retirar-puesto.php'>";

                      }

                    } // ocupados pag




                    mysqli_close($conexion);

                   ?><!-- lista puestos con opción borrar -->
                </div> <!-- listado de puestos cubiertos -->
              </div>
            </div> <!-- tarjeta -->
            <?php //eliminar
              if (isset($_POST['retirar'])) {

                $id_trabajador = $_POST['id'];

                $conexion = abrirConexion();
                $sql_borrar = "DELETE FROM ocupa WHERE id_trabajador='$id_trabajador'";
                $eliminar = mysqli_query($conexion,$sql_borrar);

                if ($eliminar) {

                  echo '<div class="alert alert-success separador" role="alert">
                          <h4><b>Perfecto!</b> Has finalizado el contrato correctamente al cliente</b></h4>
                          <a href="admin-panel.php">Volver al panel de administración</a>
                        </div>';

                } else {

                  echo '<div class="alert alert-danger separador" role="alert">
                          <h4><b>Ups!</b> Parece que ha ocurrido un error al retirar al trabajador del puesto</b></h4>
                        </div>';

                }

              }
             ?> <!-- eliminar -->
          </div> <!-- col -->
        </div> <!-- container -->
      </div> <!-- container fluid sup -->
  </body>
</html>