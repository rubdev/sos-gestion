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
    <title>SOS Gestión - Mi botiquín</title>
  </head>
  <body>
    <div class="container-fluid bg-panel seccion"> <!-- container fluid sup -->
        <?php navSuperior(); ?>
        <div class="container pos-container">
          <div class="row"> <!-- row -->
            <div class="col-md-3 offset-md-4 al-centro coloca-botiq-pan-sup"> <!-- col -->
              <form action="#" method="post" accept-charset="utf-8">

              </form>
              <a class="btn btn-info separa-bt bot-ir-adp" href="trabajador.php" title="Volver al panel de trabajador"><!-- atras -->
                <i class="fas fa-chevron-circle-left"></i> Volver al panel de trabajador
              </a><!-- atras -->
            </div>  <!-- col -->
          </div> <!-- row -->
            <div class="row"> <!-- row -->
            <div class="col-md-6 offset-md-3 "> <!-- col -->
              <?php
                  // Notificación al trabajador
                  if (isset($_GET['mensaje'])) {

                    $mensaje = $_GET['mensaje'];

                    if ($mensaje == 1) {
                      echo '<div class="alert alert-success" role="alert">
                              <h3>¡Tu <b>aviso de stock</b> se ha realizado correctamente!</h3>
                            </div>';
                    } else {
                      echo '<div class="alert alert-success" role="alert">
                              <h3>¡Ups! parece que tu <b>aviso de stock</b> no se ha podido realizar</h3>
                              <p>Por favor, <b>vuelve a intentarlo</b></p>
                            </div>';
                    }
                  }
               ?>
            </div> <!-- col -->
          </div> <!-- row -->
          </div> <!-- row -->
          <div class="row"><!-- row -->
            <div class="col-md-6 offset-md-3 al-centro"> <!-- col -->
              <h1 align="center" class="separa-titulo">Productos en el botiquín</h1>
              <hr>
              <p align="center" class="ayuda"><i class="fas fa-info-circle"></i> <b>Puedes pulsar sobre el botón <b>stock</b> para mandar un aviso</b></p>
              <?php

                  $conexion = abrirConexion();

                  $sql_puesto = "SELECT id_puesto FROM ocupa WHERE id_trabajador='$_SESSION[id]'";

                  $puesto = mysqli_query($conexion,$sql_puesto);

                  if ($puesto) { // busco puesto de trabajador

                    $fila_puesto = mysqli_fetch_array($puesto, MYSQLI_ASSOC);

                    $id_puesto = $fila_puesto['id_puesto'];

                    $sql_id_cli = "SELECT id_cliente FROM puesto WHERE id='$id_puesto'";

                    $id_cliente = mysqli_query($conexion,$sql_id_cli);

                    echo "<div class='table-responsive'>"; //responsive
                          echo "<table class='table table-hover separa-titulo'>";
                            echo "<thead class='cabecera-tabla'>
                                      <tr>
                                        <th scope='col'>Producto</th>
                                        <th scope='col'>Indicaciones de uso</th>
                                        <th scope='col'>Stock</th>
                                      </tr>
                                    </thead>
                                    <tbody>";

                    if ($id_cliente) { // busco id de cliente

                      $fila_id_cli = mysqli_fetch_array($id_cliente,MYSQLI_ASSOC);

                      $id_cliente = $fila_id_cli['id_cliente'];

                      $sql_id_botiquin = "SELECT id FROM botiquin WHERE id_cliente='$id_cliente'";

                      $botiquin = mysqli_query($conexion,$sql_id_botiquin);

                      if ($botiquin) { // busco id del botiquin

                        $fila_id_bot = mysqli_fetch_array($botiquin,MYSQLI_ASSOC);

                        $id_botiquin = $fila_id_bot['id'];

                        $sql_paginar = "SELECT * FROM almacena WHERE id_botiquin='$id_botiquin'";
                        $paginar = mysqli_query($conexion,$sql_paginar);

                        if ($paginar) {

                          $num_productos = mysqli_num_rows($paginar);

                          if ($num_productos > 0) {
                            $paginacion = 6;
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

                          $sql_alm = "SELECT * FROM almacena WHERE id_botiquin='$id_botiquin' LIMIT $inicio,$paginacion";

                          $almacenado = mysqli_query($conexion,$sql_alm);

                          if ($almacenado) { // busco productos almacenados en botiquin

                            if (mysqli_num_rows($almacenado) > 0) {
                              while ($fila_productos = mysqli_fetch_array($almacenado,MYSQLI_ASSOC)) {

                              $id_producto = $fila_productos['id_producto'];

                              $sql_nom_prod = "SELECT * FROM producto WHERE id='$id_producto'";

                              $prod_nom = mysqli_query($conexion,$sql_nom_prod);

                              if ($prod_nom) { // busco el nombre del producto

                                $producto = mysqli_fetch_array($prod_nom,MYSQLI_ASSOC);

                                echo "<tr>
                                        <td><b>$producto[nombre]</b></td>
                                        <td>$producto[uso]</td>";

                                if ($fila_productos['stock'] == 1) {
                                    echo "<td><form action='aviso.php' method='get'><input type='hidden' name='id_botiquin' value='$fila_id_bot[id]'><input type='hidden' name='id_producto' value='$fila_productos[id_producto]'><input class='form-control btn-success separa-bt bt-solv-in' type='submit' name='stock_producto' value='En stock'></form></td></tr>";
                                  } else {
                                    echo '<td><button class="btn btn-danger bt-solv-in" disabled>Sin stock</button></td></tr>';
                                  }

                                } // busco el nombre del producto

                              }
                            } else {
                              echo '<div class="col-md-8 offset-md-2"><div class="alert alert-info separador" role="alert">
                                      <h4><b>¡Vaya!</b> No tienes más productos por listar en tu botiquín</b></h4>
                                    </div></div>';
                            }

                          } // busco productos almacenados en botiquin

                        } // paginar



                      } // busco id del botiquin

                    } // busco id de cliente

                    echo "</tbody></table>"; // table
                    echo "</div>"; // responsive

                  } // busco puesto de trabajador

              ?>
            </div><!-- col -->
            <div class="col-md-2 offset-md-5"> <!-- col paginacion productos -->
                  <nav aria-label="Page navigation example">
                    <ul class="pagination pag-mi-inc-tra">
                      <?php
                        echo "<li class='page-item'><a class='page-link' href='mi-botiquin.php?pagina=".($pagina - 1)."'><i class='fas fa-angle-left'></i></a></li><li class='page-item'><a class='page-link' href='mi-botiquin.php?pagina=".($pagina + 1)."'><i class='fas fa-angle-right'></i></a></li>";
                       ?>
                    </ul>
                  </nav>
               </div> <!-- col paginacion productos -->
          </div><!-- row -->
        </div>
      </div> <!-- container fluid sup -->
  </body>
</html>