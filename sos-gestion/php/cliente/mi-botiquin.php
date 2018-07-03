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
          <div class="row">
            <div class="col-md-3 offset-md-4 al-centro"> <!-- col -->
              <a class="btn btn-info separa-bt mov-w" href="cliente.php" title="volver al area de administración"><!-- atras -->
                <i class="fas fa-chevron-circle-left"></i> Ir al panel de administración
              </a><!-- atras -->
            </div> <!-- col -->
          </div>
          <div class="row">
            <div class="col-md-6 offset-md-3 al-centro">
              <div class="separa-titulo">
                <h2 align='center' class='separa-titulo'>Mi botiquín</h2>
                    <?php

                      $tu_id = $_SESSION['id'];
                      $conexion = abrirConexion();
                      $sql_pag_botiquines = "SELECT id FROM botiquin WHERE id_cliente='$tu_id'";

                      $query_pag = mysqli_query($conexion,$sql_pag_botiquines);

                      if ($query_pag) {

                        $num_bot = mysqli_num_rows($query_pag);

                        if ($num_bot > 0) {
                          $paginacion = 3;
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

                        $sql_botiquines = "SELECT id,id_cliente FROM botiquin WHERE id_cliente='$tu_id' LIMIT $inicio,$paginacion";

                        $query_botiquines = mysqli_query($conexion,$sql_botiquines);

                        if ($query_botiquines) {

                          if (mysqli_num_rows($query_botiquines) > 0) {

                            $contador_botiquines = 1;

                            while ($botiquin = mysqli_fetch_array($query_botiquines, MYSQLI_ASSOC)) {

                              // info botiquin
                              echo "<div class='table-responsive'>
                                        <table class='table table-hover separa-titulo'>
                                         <thead class='cabecera-tabla'>
                                                <tr>
                                                  <th scope='col'>Producto</th>
                                                  <th scope='col'>Indicaciones de uso</th>
                                                </tr>
                                              </thead>
                                              <tbody></div></div>";
                              echo '</div>'; // col

                              $sql_productos = "SELECT id_producto FROM almacena WHERE id_botiquin='$botiquin[id]'";
                                $query_productos = mysqli_query($conexion,$sql_productos);

                                if ($query_productos) {

                                  if (mysqli_num_rows($query_productos) > 0) {

                                    while ($productos = mysqli_fetch_array($query_productos,MYSQLI_ASSOC)) {

                                      $sql_nom_prod = "SELECT nombre,uso FROM producto WHERE id='$productos[id_producto]'";
                                      $query_nom_prod = mysqli_query($conexion, $sql_nom_prod);

                                      if ($query_nom_prod) {

                                        $producto = mysqli_fetch_array($query_nom_prod,MYSQLI_ASSOC);
                                        echo "<tr><td><b>$producto[nombre]</td><td>$producto[uso]</b></td></tr>";

                                      }

                                    } // fetch productos

                                  } else {
                                    echo 'no hay productos';
                                  }

                                } // query productos

                            } // fetch array

                            echo "</tbody></table>"; // table
                            echo "</div>"; // responsive

                          } else {
                            echo '<div class="col-md-8 offset-md-2"><div class="alert alert-info separador" role="alert">
                                        <h4><b>¡Vaya!</b> Parece que no tienes más productos en el botiquín</b></h4>
                                      </div></div>';
                          }

                        } // query botiquines

                      } // query pag

                      mysqli_close($conexion);

                     ?>
              </div>
              <div class="col-md-4 offset-md-4"> <!-- col paginacion productos -->
                  <nav aria-label="Page navigation example">
                    <ul class="pagination pag-mi-inc-tra">
                      <?php
                        echo "<li class='page-item'><a class='page-link' href='mi-botiquin.php?pagina=".($pagina - 1)."'><i class='fas fa-angle-left'></i></a></li><li class='page-item'><a class='page-link' href='mi-botiquin.php?pagina=".($pagina + 1)."'><i class='fas fa-angle-right'></i></a></li>";
                       ?>
                    </ul>
                  </nav>
               </div> <!-- col paginacion productos -->
            </div>
          </div>
      </div> <!-- container fluid sup -->
  </body>
</html>