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
    <title>SOS Gestión - Botiquín</title>
  </head>
  <body>
    <div class="container-fluid bg-panel seccion"> <!-- container fluid sup -->
        <?php navSuperior(); ?>
        <div class="container pos-container"> <!-- container -->
          <div class="row"> <!-- row -->
            <div class="col-md-3 offset-md-4 al-centro coloca-botiq-pan-sup"> <!-- col -->
              <a class="btn btn-info separa-bt bot-ir-adp" href="admin-panel.php" title="volver al panel de administración"><!-- atras -->
                <i class="fas fa-chevron-circle-left"></i> Ir al panel de administración
              </a><!-- atras -->
            </div> <!-- col -->
          </div><!-- row -->
          <div class="row"> <!-- row -->
            <div class="col-md-6 al-centro "> <!-- col prods-->
               <h1 align="center" class="separa-titulo">Inventario de productos</h1>
                <div class="col-md-8 offset-md-2"><!-- col btn-->
                <form action="#" method="post" accept-charset="utf-8"> <!-- buscar -->
                  <div class="input-group buscar-grupo">
                      <span>
                        <i class="fas fa-search icon-buscar"></i>
                      </span>
                      <input type="text" class="form-control buscar" placeholder="Buscar por nombre"  name="buscar_producto">
                    </div>
                </form> <!-- buscar -->
                <a class="btn btn-success separa-bt bt-nw-prod" href="nuevo-producto.php" title="añadir producto al inventario"><!-- nuevo producto -->
                    <i class="fas fa-plus-circle"></i></i> Añadir productos
                  </a><!-- eliminar producto
                  <a class="btn btn-danger separa-bt" href="eliminar-producto.php" title="eliminar producto del inventario">
                    <i class="fas fa-trash-alt"></i></i> Eliminar producto
                  </a> eliminar producto -->
               </div> <!-- col btn -->
               <div class="col"> <!-- col listado prod -->
                  <?php

                      if (isset($_POST['buscar_producto'])) { // buscar

                        $buscar = $_POST['buscar_producto'];

                        $conexion = abrirConexion();
                        $consulta = "SELECT * FROM producto WHERE nombre like '%$buscar%'";
                        $productos = mysqli_query($conexion,$consulta);

                        if ($productos) { // productos

                          $num_productos = mysqli_num_rows($productos);

                          if ($num_productos > 0) {
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

                          $consulta_mostrar = "SELECT * FROM producto WHERE nombre like '%$buscar%' LIMIT $inicio,$paginacion";
                          $mostrar = mysqli_query($conexion,$consulta_mostrar);

                          if ($mostrar) {

                            echo "<div class='table-responsive'>"; //responsive
                            echo "<table class='table table-hover separa-titulo'>";
                              echo "<thead class='cabecera-tabla'>
                                        <tr>
                                          <th scope='col'>Producto</th>
                                          <th scope='col'>Indicaciones de uso</th>
                                        </tr>
                                      </thead>
                                      <tbody>";

                            while ($producto = mysqli_fetch_array($mostrar,MYSQLI_ASSOC)) {
                              echo "<tr>
                                      <td><b>$producto[nombre]</b></td>
                                      <td>$producto[uso]</td>
                                    </tr>";
                            }

                            echo "</tbody></table>"; // table
                            echo "</div>"; // responsive

                          }

                        } // productos


                      } else { // buscar
                        $conexion = abrirConexion();
                        $consulta = "SELECT * FROM producto";
                        $productos = mysqli_query($conexion,$consulta);

                        if ($productos) { // productos

                          $num_productos = mysqli_num_rows($productos);

                          if ($num_productos > 0) {
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

                          $consulta_mostrar = "SELECT * FROM producto LIMIT $inicio,$paginacion";
                          $mostrar = mysqli_query($conexion,$consulta_mostrar);

                          if ($mostrar) {

                            echo "<div class='table-responsive'>"; //responsive
                            echo "<table class='table table-hover separa-titulo'>";
                              echo "<thead class='cabecera-tabla'>
                                        <tr>
                                          <th scope='col'>Producto</th>
                                          <th scope='col'>Indicaciones de uso</th>
                                        </tr>
                                      </thead>
                                      <tbody>";

                            while ($producto = mysqli_fetch_array($mostrar,MYSQLI_ASSOC)) {
                              echo "<tr>
                                      <td><b>$producto[nombre]</b></td>
                                      <td>$producto[uso]</td>
                                    </tr>";
                            }

                            echo "</tbody></table>"; // table
                            echo "</div>"; // responsive

                          }

                        } // productos
                      } // buscar fin




                   ?>
               </div> <!-- col listado prod -->
               <div class="col-md-4 offset-md-4"> <!-- col paginacion productos -->
                  <nav aria-label="Page navigation example">
                    <ul class="pagination pag-bot-lis">
                      <?php
                        echo "<li class='page-item'><a class='page-link' href='botiquin.php?pagina=".($pagina - 1)."'><i class='fas fa-angle-left'></i></a></li><li class='page-item'><a class='page-link' href='botiquin.php?pagina=".($pagina + 1)."'><i class='fas fa-angle-right'></i></a></li>";
                       ?>
                    </ul>
                  </nav>
               </div> <!-- col paginacion productos -->
            </div> <!-- col prods -->
            <div class="col-md-3 al-centro"> <!-- col botiquines-->
               <h1 align="center" class="separa-titulo">Botiquines</h1>
               <div class="col">
                  <a class="btn btn-success separa-bt mov-w" href="asignar-botiquin.php" title="Asignar botiquín a un cliente"><!-- asignar bot -->
                    <i class="fas fa-briefcase-medical"></i> Asignar botiquín a un cliente
                  </a><!-- asignar bot -->
               </div>

               <div class="col-md-10 offset-md-1">
                  <?php
                    $conexion = abrirConexion();
                    $sql_lista_bot = "SELECT id FROM botiquin";

                    $lista_bots = mysqli_query($conexion,$sql_lista_bot);

                    if ($lista_bots) {

                      $num_bots = mysqli_num_rows($lista_bots);

                      if ($num_bots > 0) {
                        $paginacion_bot = 6;
                        $pagina_bot = false;
                      }

                      if (isset($_GET['pagina_bot'])) {
                        $pagina_bot = $_GET['pagina_bot'];
                      }

                      if (!$pagina_bot) {
                        $inicio = 0;
                        $pagina_bot = 1;
                      } else {
                        $inicio = ($pagina_bot - 1) * $paginacion_bot;
                      }

                      $sql_botiquines = "SELECT * FROM botiquin LIMIT $inicio,$paginacion_bot";
                      $botiquines = mysqli_query($conexion,$sql_botiquines);

                      if ($botiquines) {

                        if (mysqli_num_rows($botiquines) > 0 ) {

                          echo "<div class='table-responsive'>"; //responsive
                          echo "<table class='table table-hover separa-titulo'><tbody>";

                          while ($botiquin = mysqli_fetch_array($botiquines,MYSQLI_ASSOC)) {

                            $slq_cliente = "SELECT nombre FROM cliente WHERE id='$botiquin[id_cliente]'";
                            $clientes = mysqli_query($conexion,$slq_cliente);

                            if ($clientes) {

                              while ($cliente = mysqli_fetch_array($clientes,MYSQLI_ASSOC)) {

                                echo "<tr><td><form action='almacenar-productos.php' method='get'><input type='hidden' name='id_botiquin' value='$botiquin[id]'><input class='form-control btn-info separa-bt' type='submit' name='almacenar' value='$cliente[nombre]'></form></td></tr>";

                              }

                            }

                          }

                          echo "</tbody></table>"; // table

                          echo "</div>"; // responsive

                        } else {
                          echo '<div class="alert alert-info separador" role="alert">
                                  <h4><b>¡Vaya!</b> Parece que no tienes más botiquines</b></h4>
                                </div>';
                        }

                      }

                    } // lista bots



                    mysqli_close($conexion);
                  ?>
               </div>
               <div class="col-md-4 offset-md-4"> <!-- col paginacion botiquines -->
                  <nav aria-label="Page navigation example">
                    <ul class="pagination pag-bot-lis">
                      <?php
                        echo "<li class='page-item'><a class='page-link' href='botiquin.php?pagina_bot=".($pagina_bot - 1)."'><i class='fas fa-angle-left'></i></a></li><li class='page-item'><a class='page-link' href='botiquin.php?pagina_bot=".($pagina_bot + 1)."'><i class='fas fa-angle-right'></i></a></li>";
                       ?>
                    </ul>
                  </nav>
               </div> <!-- col paginacion botiquines -->
            </div> <!-- col botiquines -->
            <div class="col-md-3 al-centro"> <!-- col avisos-->
               <h1 align="center" class="separa-titulo">Últimos avisos de stock</h1>
               <div class="col">
                  <a class="btn btn-success separa-bt mov-w" href="ver-avisos.php" title="Ver todos los avisos de stock"><!-- asignar bot -->
                    <i class="fas fa-exclamation-circle"></i> Ver todos los avisos de stock
                  </a><!-- asignar bot -->
                  <hr>
                    <p align="center" class="ayuda"><i class="fas fa-info-circle"></i> <b>Puedes pulsar sobre el aviso para solucionarlo</b></p>
                    <?php
                      // Notificación al admin
                        if (isset($_GET['mensaje'])) {

                          $mensaje = $_GET['mensaje'];

                          if ($mensaje == 1) {
                            echo '<div class="alert alert-success" role="alert">
                                    <h4>¡El <b>aviso de stock</b> se ha solucionado correctamente!</h4>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>';
                          } else {
                            echo '<div class="alert alert-success" role="alert">
                                    <h4>¡Ups! parece que el <b>aviso de stock</b> no se ha podido solucionar</h4>
                                    <p>Por favor, <b>vuelve a intentarlo</b></p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>';
                          }
                        }
                     ?>
               </div>
               <?php

                    $conexion = abrirConexion();
                    $sql_avisos_lista = "SELECT * FROM aviso WHERE estado='sin stock'";
                    $avisos_lista = mysqli_query($conexion,$sql_avisos_lista);

                    if ($avisos_lista) {

                      $num_avisos = mysqli_num_rows($avisos_lista);

                      if ($num_avisos > 0) {
                        $paginacion_av = 3;
                        $pagina_av = false;
                      }

                      if (isset($_GET['pagina_av'])) {
                        $pagina_av = $_GET['pagina_av'];
                      }

                      if (!$pagina_av) {
                        $inicio = 0;
                        $pagina_av = 1;
                      } else {
                        $inicio = ($pagina_av - 1) * $paginacion_av;
                      }

                      $sql_avisos = "SELECT * FROM aviso WHERE estado='sin stock' LIMIT $inicio,$paginacion_av";

                      $avisos = mysqli_query($conexion,$sql_avisos);

                      if ($avisos) { // avisos

                        if (mysqli_num_rows($avisos) > 0) {

                          echo "<div class='table-responsive'>"; //responsive
                          echo "<table class='table table-hover separa-titulo'><tbody>";

                          while ($aviso = mysqli_fetch_array($avisos,MYSQLI_ASSOC)) {

                            $sql_botiquin = "SELECT id_cliente FROM botiquin WHERE id='$aviso[id_botiquin]'";
                            $botiquin = mysqli_query($conexion,$sql_botiquin);

                            if ($botiquin) { // botiquin

                              $bot = mysqli_fetch_array($botiquin,MYSQLI_ASSOC);

                              $sql_cliente = "SELECT nombre FROM cliente WHERE id='$bot[id_cliente]'";
                              $cliente = mysqli_query($conexion,$sql_cliente);

                              if ($cliente) { // cliente

                                $cli = mysqli_fetch_array($cliente,MYSQLI_ASSOC);

                                $sql_producto = "SELECT nombre FROM producto WHERE id='$aviso[id_producto]'";
                                $productos = mysqli_query($conexion,$sql_producto);

                                if ($productos) { // productos

                                  $prod = mysqli_fetch_array($productos,MYSQLI_ASSOC);

                                  echo "<tr><td><form action='solucionar-aviso.php' method='get'><input type='hidden' name='id_aviso' value='$aviso[id]'><input type='hidden' name='id_botiquin' value='$aviso[id_botiquin]'><input type='hidden' name='id_producto' value='$aviso[id_producto]'><input class='form-control btn-warning separa-bt' type='submit' name='solucionar' value='$prod[nombre] en $cli[nombre] '></form></td></tr>";

                                } // productos

                              } // cliente

                            } // botiquin

                          } // fetch avisos

                          echo "</tbody></table>"; // table
                          echo "</div>"; // responsive

                        } else {

                          echo '<div class="alert alert-info separador" role="alert">
                                  <h4><b>¡Vaya, que bien!</b> Parece que no tienes más avisos de stock</b></h4>
                                </div>';

                        }

                      } // avisos

                    } // avisos lista




                    mysqli_close($conexion);

                ?>
                <div class="col-md-4 offset-md-4"> <!-- col paginacion avisos -->
                  <nav aria-label="Page navigation example">
                    <ul class="pagination pag-bot-lis">
                      <?php
                        echo "<li class='page-item'><a class='page-link' href='botiquin.php?pagina_av=".($pagina_av - 1)."'><i class='fas fa-angle-left'></i></a></li><li class='page-item'><a class='page-link' href='botiquin.php?pagina_av=".($pagina_av + 1)."'><i class='fas fa-angle-right'></i></a></li>";
                       ?>
                    </ul>
                  </nav>
               </div> <!-- col paginacion avisos -->

            </div> <!-- col avisos -->
          </div> <!-- row -->
        </div> <!-- container -->
    </div> <!-- container fluid sup -->
  </body>
</html>
