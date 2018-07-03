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
    <title>SOS Gestión - Puestos de trabajo</title>
  </head>
  <body>
    <div class="container-fluid bg-panel seccion"> <!-- container fluid sup -->
        <?php navSuperior(); ?>
        <div class="container pos-container"> <!-- container -->
          <div class="row"> <!-- row -->
            <div class="col-md-10 offset-md-1 al-centro">

              <a class="btn btn-success separa-bt colocar-bt-pu mov-w" href="nuevo-puesto.php" title="añadir puesto"><!-- nuevo cliente -->
                <i class="fas fa-plus-circle"></i></i> Añadir nuevo puesto
              </a><!-- nuevo cliente -->

              <a class="btn btn-primary separa-bt mov-w" href="asignar-puesto.php" title="asignar puesto"><!-- asignar -->
                <i class="fas fa-hockey-puck"></i> Asignar puesto a trabajador
              </a><!-- asignar -->

              <a class="btn btn-danger separa-bt mov-w" href="retirar-puesto.php" title="asignar puesto"><!-- eliminar -->
                <i class="fas fa-trash-alt"></i> Retirar trabajador
              </a><!-- eliminar -->

              <a class="btn btn-info separa-bt mov-w" href="admin-panel.php" title="volver al area de administración"><!-- atras -->
                <i class="fas fa-chevron-circle-left"></i> Ir al panel de administración
              </a><!-- atras -->

            </div>
          </div> <!-- row -->

          <div class="row"> <!-- row -->
            <div class="col al-centro"> <!-- col -->

              <h1 align="center" class="separa-titulo">Puestos de trabajo</h1>
              <?php //listado de puestos

                $fecha_actual = date("y-m-d");
                $conexion = abrirConexion();

                $lista_puestos = "SELECT id FROM puesto";
                $puestos_lista = mysqli_query($conexion,$lista_puestos);

                if ($puestos_lista) { // puestos lista

                  $num_puestos = mysqli_num_rows($puestos_lista);

                  if ($num_puestos > 0) {
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

                  $sql_puestos = "SELECT p.id as id_puesto, p.fecha_inicio, p.fecha_fin, p.numero_trabajadores, p.tipo, p.id_cliente, c.id as id_cli, c.nombre FROM puesto p, cliente c WHERE p.id_cliente=c.id AND p.fecha_fin > '$fecha_actual' LIMIT $inicio,$paginacion";

                  $listado_puestos = mysqli_query($conexion, $sql_puestos);

                  if ($listado_puestos) {

                    if (mysqli_num_rows($listado_puestos) > 0) {
                      echo "<div class='table-responsive'>"; //responsive
                        echo "<table class='table table-hover'>";
                          echo "<thead class='cabecera-tabla'>
                                    <tr>
                                      <th scope='col'>Cliente</th>
                                      <th scope='col'>Tipo de puesto</th>
                                      <th scope='col'>Trabajadores necesarios</th>
                                      <th scope='col'>Fecha inicio</th>
                                      <th scope='col'>Fecha fin</th>
                                    </tr>
                                  </thead>
                                  <tbody>";

                      while ($fila = mysqli_fetch_array($listado_puestos, MYSQLI_ASSOC)) {

                            $marca_ini = strtotime($fila['fecha_inicio']);
                            $fecha_formateada_ini = date('d-m-Y',$marca_ini);
                            $marca_fin = strtotime($fila['fecha_fin']);
                            $fecha_formateada_fin = date('d-m-Y',$marca_fin);


                            echo  "<tr>
                                      <td>$fila[nombre]</td>
                                      <td>$fila[tipo]</td>
                                      <td>$fila[numero_trabajadores]</td>
                                      <td>$fecha_formateada_ini</td>
                                      <td>$fecha_formateada_fin</td>
                                    </tr>";

                      }

                      echo "</tbody></table>"; // table
                      echo "</div>"; // responsive

                    } else {

                        echo '<div class="alert alert-info separador" role="alert">
                                <h4><b>¡Vaya!</b> Parece que no tienes más puestos de trabajo para listar</b></h4>
                              </div>';

                      }

                  }

                } // puestos lista


                ?>
                        <div class="col-md-2 offset-md-5"> <!-- col paginacion productos -->
                          <nav aria-label="Page navigation example">
                            <ul class="pagination pag-ges">
                              <?php
                                echo "<li class='page-item'><a class='page-link' href='gestion-puestos.php?pagina=".($pagina - 1)."'><i class='fas fa-angle-left'></i></a></li><li class='page-item'><a class='page-link' href='gestion-puestos.php?pagina=".($pagina + 1)."'><i class='fas fa-angle-right'></i></a></li>";
                               ?>
                            </ul>
                          </nav>
                        </div> <!-- col paginacion productos -->
                      <?php
               ?> <!-- listado de puestos -->

            </div> <!-- col -->

            <div class="col al-centro"> <!-- col -->

              <h1 align="center" class="separa-titulo">Ocupados actualmente</h1>
              <?php //puestos ocupados actual

                $conexion = abrirConexion();

                $sql_ocupa = "SELECT * FROM ocupa";
                $ocupados_lista = mysqli_query($conexion,$sql_ocupa);

                if ($ocupados_lista) { // ocupados lista

                  $num_ocupados = mysqli_num_rows($ocupados_lista);

                  if ($num_ocupados > 0) {
                    $paginacion_o = 5;
                    $pagina_o = false;
                  }

                  if (isset($_GET['pagina_o'])) {
                    $pagina_o = $_GET['pagina_o'];
                  }

                  if (!$pagina_o) {
                    $inicio = 0;
                    $pagina_o = 1;
                  } else {
                    $inicio = ($pagina_o - 1) * $paginacion_o;
                  }

                  $sql_trabajador = "SELECT o.id_trabajador, o.id_puesto, t.id, t.nombre,t.tipo FROM ocupa o, trabajador t WHere o.id_trabajador=t.id LIMIT $inicio,$paginacion_o";
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
                                    </tr>";

                            }

                          }

                        }

                      }

                    } else {

                        echo '<div class="alert alert-info separador" role="alert">
                                <h4><b>¡Vaya!</b> Parece que no tienes más puestos de trabajo ocupados para listar</b></h4>
                              </div>';

                      }

                    echo "</tbody></table>"; // table

                      echo "</div>"; // responsive

                  }

                } // ocupados lista


                ?>
                        <div class="col-md-2 offset-md-5"> <!-- col paginacion productos -->
                          <nav aria-label="Page navigation example">
                            <ul class="pagination pag-ges">
                              <?php
                                echo "<li class='page-item'><a class='page-link' href='gestion-puestos.php?pagina_o=".($pagina_o - 1)."'><i class='fas fa-angle-left'></i></a></li><li class='page-item'><a class='page-link' href='gestion-puestos.php?pagina_o=".($pagina_o + 1)."'><i class='fas fa-angle-right'></i></a></li>";
                               ?>
                            </ul>
                          </nav>
                        </div> <!-- col paginacion productos -->
                      <?php

                mysqli_close($conexion);
               ?> <!-- puestos ocupados actual -->
            </div> <!-- col -->
          </div> <!-- row -->

        </div><!-- container -->
      </div> <!-- container fluid sup -->
  </body>
</html>