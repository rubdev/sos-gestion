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
    <title>SOS Gestión - Almacenar productos en botiquín</title>
  </head>
  <body>
    <div class="container-fluid bg-panel"> <!-- container fluid sup -->
        <?php navSuperior(); ?>
        <div class="container pos-container"> <!-- container -->
          <div class="col col-md-8 offset-md-2 col-lg-6 offset-lg-3"> <!-- col -->
            <div class="card">
              <div class="card-body tarjeta-acceder"> <!-- tarjeta -->
                <h2 class="card-title" align="center">Almacenar productos en un botiquín</h2>
                <h6 class="card-subtitle mb-2 text-muted" align="center">Selecciona los productos que quieres almacenar en el botiquín</h6>
                <hr>
                <?php
                  if (isset($_GET['almacenar'])) {

                    $id_bot = $_GET['id_botiquin'];

                    $conexion = abrirConexion();
                    $sql_cliente = "SELECT id_cliente FROM botiquin WHERE id='$id_bot'";

                    $cliente = mysqli_query($conexion,$sql_cliente);

                    if ($cliente) { //cliente

                      $cli = mysqli_fetch_array($cliente, MYSQLI_ASSOC);
                      $id_cli = $cli['id_cliente'];

                      $sql_nom_cli = "SELECT nombre FROM cliente WHERE id='$id_cli'";

                      $nom_cli = mysqli_query($conexion, $sql_nom_cli);

                      if ($nom_cli) { //nombre cliente

                        $fila = mysqli_fetch_array($nom_cli,MYSQLI_ASSOC);
                        $nombre = $fila['nombre'];

                        echo '<h6 align="center"><b>Este es el contenido actual del botiquín del cliente '.$nombre.'</b></h6>';

                      } //nombre cliente

                    } // cliente

                    mysqli_close($conexion);

                  }
                ?>
                <div class="formulario-login"> <!-- formulario asignar botiquín -->
                  <form action="#" method="post" enctype="multipart/form-data">
                    <?php // listado de productos en el botiquín

                        if (isset($_GET['almacenar'])) { //isset

                          $id_bot = $_GET['id_botiquin'];

                          $conexion = abrirConexion();
                          $sql_prod_en_botiquin = "SELECT * FROM almacena WHERE id_botiquin='$id_bot'";

                          $prod_en_botiquin = mysqli_query($conexion,$sql_prod_en_botiquin);

                          if ($prod_en_botiquin) { //prod en botiquin

                            if (mysqli_num_rows($prod_en_botiquin) > 0) {

                              echo '<div class="alert alert-info">';

                              while ($nom = mysqli_fetch_array($prod_en_botiquin,MYSQLI_ASSOC)) {

                                $slq_nom_prod = "SELECT nombre FROM producto WHERE id='$nom[id_producto]'";
                                $producto = mysqli_query($conexion,$slq_nom_prod);

                                if ($producto) {

                                  $nombre_producto = mysqli_fetch_array($producto,MYSQLI_ASSOC);

                                  echo '<p>'.$nombre_producto['nombre'].'</p>';

                                }

                              }

                              echo '</div>';

                            } else {
                              echo '<div class="alert alert-info separador" role="alert">
                                      <h4 align="center">Ahora mismo no dispones de ningún producto en este botiquín</b></h4>
                                    </div>';
                            }

                          } //prod en botiquin


                        }//isset


                        // listado de productos en el botiquín
                    ?>
                    <hr>
                    <p align="center" style="color: #6c757d">Selecciona un producto para añadirlo al botiquín</p>
                    <select name="producto" class="custom-select">
                      <?php

                          $conexion = abrirConexion();
                          $sql_productos = "SELECT id,nombre FROM producto";

                          $productos = mysqli_query($conexion,$sql_productos);

                          if ($productos) { //productos

                            while ($producto = mysqli_fetch_array($productos,MYSQLI_ASSOC)) {

                              echo "<option value=$producto[id]>$producto[nombre]</option>";

                            }

                          } // productos

                       ?>
                     </select>
                    <div class="col-md-8 offset-md-2">
                      <input type="submit" name="añadir" value="Añadir al botiquín" class="btn btn-success btn-new">
                      <a href="botiquin.php" class="btn btn-danger separa-titulo">Cancelar y volver</a>
                    </div>
                    <div class="col">
                    </div>
                  </form>
                </div> <!-- formulario asignar botiquín -->
              </div>
            </div> <!-- tarjeta -->
            <!-- Tratamiento del formulario -->
            <?php

              $id_bot = $_GET['id_botiquin'];

              if (isset($_POST['añadir'])) { //isset añadir

                // Recojo datos del formulario
                $id_prod = $_POST['producto'];

                // abro conexion con bd y preparo la consulta para insertar
                $conexion = abrirConexion();
                $insertar = "INSERT INTO almacena (id_botiquin,id_producto,stock) VALUES ('$id_bot','$id_prod', true)";

                $producto = mysqli_query($conexion,$insertar);


                // ejecuto la consulta
                if ($producto) {
                  echo '<div class="alert alert-success separador" role="alert">
                            <h4><b>Vale!</b> El producto se ha añadido correctamente al botiquín</b></h4>
                            <h2>¡Añade otro producto!</h2>
                            <a href="admin-panel.php">O también puedes volver al botiquín</a>
                          </div>';
                } else {
                  echo '<div class="alert alert-danger separador" role="alert">
                            <h4><b>Ups!</b> parece que ha ocurrido un error al añadir el producto al botiquín</b></h4>
                          </div>';
                }

                mysqli_close($conexion);

              } // isset añadir

             ?><!-- Tratamiento del formulario -->
          </div> <!-- col -->
        </div> <!-- container -->
      </div> <!-- container fluid sup -->
  </body>
</html>
