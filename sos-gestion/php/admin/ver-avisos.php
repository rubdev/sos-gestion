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
    <title>SOS Gestión - Avisos de stock</title>
  </head>
  <body>
    <div class="container-fluid bg-panel seccion"> <!-- container fluid sup -->
        <?php navSuperior(); ?>
        <div class="container pos-container"> <!-- container -->
          <div class="row"> <!-- row -->
            <div class="col-md-3 offset-md-4 al-centro coloca-botiq-pan-sup"> <!-- col -->
              <a class="btn btn-info separa-bt bot-ir-adp" href="botiquin.php" title="volver al botiquín"><!-- atras -->
                <i class="fas fa-chevron-circle-left"></i> Ir al panel de administración
              </a><!-- atras -->
            </div> <!-- col -->
          </div><!-- row -->
          <div class="row"> <!-- row -->
            <div class="col-md-5 offset-md-1 al-centro"> <!-- col avisos sin resolver-->
               <h1 align="center" class="separa-titulo">Avisos de stock sin resolver</h1>
               <div class="col-md-8 offset-md-2">
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

                    if (isset($_POST['buscar_cliente'])) {

                      echo 'buscaré <b>avisos</b> por cliente';

                    } else {

                      $conexion = abrirConexion();
                      $sql_avisos_lista = "SELECT * FROM aviso WHERE estado='sin stock'";
                      $avisos_lista = mysqli_query($conexion,$sql_avisos_lista);

                      if ($avisos_lista) {

                        $num_avisos = mysqli_num_rows($avisos_lista);

                        if ($num_avisos > 0) {
                          $paginacion_av = 5;
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

                    } // busqueda

                ?>
                <div class="col-md-4 offset-md-4"> <!-- col paginacion avisos -->
                  <nav aria-label="Page navigation example">
                    <ul class="pagination pag-av-ad">
                      <?php
                        echo "<li class='page-item'><a class='page-link' href='ver-avisos.php?pagina_av=".($pagina_av - 1)."'><i class='fas fa-angle-left'></i></a></li><li class='page-item'><a class='page-link' href='ver-avisos.php?pagina_av=".($pagina_av + 1)."'><i class='fas fa-angle-right'></i></a></li>";
                       ?>
                    </ul>
                  </nav>
               </div> <!-- col paginacion avisos -->
            </div> <!-- col avisos sin resolver-->
            <div class="col-md-5 offset-md-1 al-centro"> <!-- col avisos resueltos-->
               <h1 align="center" class="separa-titulo">Avisos de stock resueltos</h1>
               <div class="col-md-8 offset-md-2">
                <p align="center" class="ayuda"><i class="fas fa-info-circle"></i> <b>Los avisos resueltos no se pueden modificar</b></p>
               </div>
               <?php

                    if (isset($_POST['buscar_cliente'])) { //buscar avisos por cliente

                      echo 'buscaré <b>avisos</b> por cliente';

                    } else {

                      $conexion = abrirConexion();
                      $sql_avisos_pag = "SELECT * FROM aviso WHERE estado='solucionado'";
                      $avisos_pag = mysqli_query($conexion,$sql_avisos_pag);

                      if ($avisos_pag) {

                        $num_avisos_pag = mysqli_num_rows($avisos_pag);

                        if ($num_avisos_pag > 0) {
                          $paginacion_sol = 5;
                          $pagina_sol = false;
                        }

                        if (isset($_GET['pagina_sol'])) {
                          $pagina_sol = $_GET['pagina_sol'];
                        }

                        if (!$pagina_sol) {
                          $inicio = 0;
                          $pagina_sol = 1;
                        } else {
                          $inicio = ($pagina_sol - 1) * $paginacion_sol;
                        }

                        $sql_avisos = "SELECT * FROM aviso WHERE estado='solucionado' LIMIT $inicio,$paginacion_sol";

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

                                    echo "<tr><td><form action='solucionar-aviso.php' method='get'><input type='hidden' name='id_aviso' value='$aviso[id]'><input type='hidden' name='id_botiquin' value='$aviso[id_botiquin]'><input type='hidden' name='id_producto' value='$aviso[id_producto]'><input disabled class='form-control btn-success separa-bt' type='submit' name='solucionar' value='$prod[nombre] en $cli[nombre] '></form></td></tr>";

                                  } // productos

                                } // cliente

                              } // botiquin

                            } // fetch avisos

                            echo "</tbody></table>"; // table
                            echo "</div>"; // responsive


                          } else {

                            echo '<div class="alert alert-info separador" role="alert">
                                    <h4><b>¡Perfecto!</b> Parece que no tienes más avisos de stock resueltos</b></h4>
                                  </div>';

                          }

                        } // avisos


                      }



                      mysqli_close($conexion);

                    } // busqueda

                ?>
                <div class="col-md-4 offset-md-4"> <!-- col paginacion avisos -->
                  <nav aria-label="Page navigation example">
                    <ul class="pagination pag-av-ad">
                      <?php
                        echo "<li class='page-item'><a class='page-link' href='ver-avisos.php?pagina_sol=".($pagina_sol - 1)."'><i class='fas fa-angle-left'></i></a></li><li class='page-item'><a class='page-link' href='ver-avisos.php?pagina_sol=".($pagina_sol + 1)."'><i class='fas fa-angle-right'></i></a></li>";
                       ?>
                    </ul>
                  </nav>
               </div> <!-- col paginacion avisos -->
            </div> <!-- col avisos resueltos-->
          </div> <!-- row -->
        </div> <!-- container -->
    </div> <!-- container fluid sup -->
  </body>
</html>
