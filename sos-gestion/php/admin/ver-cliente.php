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
    <!-- <script type="text/javascript" src="../../js/scripts.js"></script> -->
    <title>SOS Gestión - Ver clientes</title>
  </head>
  <body>
    <div class="container-fluid bg-panel-ver seccion"> <!-- container fluid sup -->
        <?php navSuperior(); ?>
        <div class="container pos-container"> <!-- container -->
          <div class="row"> <!-- row -->

          </div> <!-- row -->
            <div class="col-md-8 offset-md-2 al-centro">
              <form action="#" method="post" accept-charset="utf-8">
                <div class="form-group">  <!-- buscar -->
                    <div class="input-group buscar-tra">
                      <span>
                        <i class="fas fa-search icon-buscar"></i>
                      </span>
                      <input type="text" class="form-control buscar" placeholder="Búsqueda por nombre" size="2" name="buscar_cliente">
                    </div>
                    <a class="btn btn-success separa-bt colocar-bt-trabajador" href="nuevo-cliente.php" title="añadir cliente"><!-- nuevo cliente -->
                      <i class="fas fa-plus-circle"></i></i> Añadir nuevo cliente
                    </a><!-- nuevo cliente -->
                    <!--<a class="btn btn-danger separa-bt" href="eliminar-cliente.php" title="eliminar cliente"> eliminar
                      <i class="fas fa-trash-alt"></i> Finalizar el contrato de un cliente
                    </a> eliminar -->
                    <a class="btn btn-info separa-bt mov-w" href="admin-panel.php" title="volver al area de administración"><!-- atras -->
                      <i class="fas fa-chevron-circle-left"></i> Ir al panel de administración
                    </a><!-- atras -->
                  </div> <!-- buscar -->
              </form>


            </div>
          <div class="row"> <!-- row -->

            <?php

            if (isset($_POST['buscar_cliente'])) { //buscar
              $buscar = $_POST['buscar_cliente'];

              $conexion = abrirConexion();
              $sql_buscar = "SELECT * FROM cliente WHERE nombre like '%$buscar%'";
              $busqueda = mysqli_query($conexion,$sql_buscar);

              // hago la búsqueda en bd
              if ($busqueda) {

                if (mysqli_num_rows($busqueda) > 0) {

                      while ($fila = mysqli_fetch_array($busqueda,MYSQLI_ASSOC)) {

                          echo "<div class='col-md-3 offset-md-1 separa-tarjetas'>"; //col
                            echo "<div class='card'>"; // tarjeta
                            echo "<div class='card-body tarjeta-trabajador'>
                                    <h2 class='card-title' align='center'>$fila[nombre]</h2>
                                    <h4 class='card-subtitle mb-2 text-muted' align='center'>$fila[direccion]</h4>
                                    <div id='ver-mas'>
                                      <hr>
                                      <button type='button' class='btn btn-info bt-accion bt-ver-mas-tra' data-toggle='modal' data-target='#$fila[id]'>
                                        Ver mas datos
                                      </button>
                                      <form action='modificar-cliente.php' method='get'><input type='hidden' name='id-cliente' value='$fila[id]'><input class='form-control btn-warning separa-bt mod-bt-tra' type='submit' name='modificar' value='Modificar'></form>
                                    </div>
                                  </div>";
                            echo "</div>"; // tarjeta
                          echo "</div>"; //col

                          // modal con todos los datos del trabajador
                          echo "<div class='modal fade' id='$fila[id]' tabindex='-1' role='dialog' aria-labelledby='ver-datosTitle' aria-hidden='true'>
                                <div class='modal-dialog modal-dialog-centered' role='document'>
                                  <div class='modal-content modal-custom'>
                                    <div class='modal-header'>
                                      <h5 align='center' class='modal-title'>Datos de $fila[nombre]</h5>
                                      <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                      </button>
                                    </div>
                                      <div class='modal-body'>
                                      <p align='center' style='color: #6c757d'><b>Datos de acceso</b></p>
                                      <p align='center'><b>Usuario:</b><br>$fila[usuario]</p>
                                      <p align='center'><b>Contraseña:</b><br>$fila[password]</p>
                                      <hr><p align='center' style='color: #6c757d'><b>Datos del cliente</b></p>
                                      <div id='ver-mas'>
                                        <p align='center'><b>Nombre:</b><br>$fila[nombre]</p>
                                        <p align='center'><b>Denominación social:</b><br>$fila[denominacion_social]
                                        </p>
                                        <p align='center'><b>DNI/CIF:</b><br>$fila[dni_cif]</p>
                                        <p align='center'><b>Dirección:</b><br>$fila[direccion]</p>
                                        <p align='center'><b>Teléfono:</b><br>$fila[telefono]</p>
                                        <p align='center'><b>Email:</b><br>$fila[email]</p>
                                    </div>
                                    </div>
                                    <div class='modal-footer'>
                                      <button type='button' class='btn btn-info' data-dismiss='modal'>Cerrar</button>
                                    </div>
                                  </div>
                                </div>
                              </div>";


                      }

                    } else {

                      echo '<div class="alert alert-danger separador" role="alert">
                              <h4><b>Ups</b> Parece que no tienes ningún cliente con ese nombre</b></h4>
                              <p>¿Porqué no intentas realizar una nueva búsqueda?</p>
                              <a href="ver-cliente.php">O también puedes volver al listado de clientes</a>
                            </div>';

                    }

              }


            } else { //buscar

                  // abro conexión y listo los trabajadores en bd
                  $conexion = abrirConexion();
                  $sql_listar = "SELECT * FROM cliente";
                  $listar = mysqli_query($conexion,$sql_listar);

                  if ($listar) { // listar

                    $num_clientes = mysqli_num_rows($listar);

                    if ($num_clientes > 0) {
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

                    $sql_datos = "SELECT * FROM cliente LIMIT $inicio,$paginacion";
                    $datos = mysqli_query($conexion,$sql_datos);

                    if ($datos) { //datos

                      if (mysqli_num_rows($datos) > 0) {

                        while ($fila = mysqli_fetch_array($datos,MYSQLI_ASSOC)) {

                            echo "<div class='col-md-3 offset-md-1 separa-tarjetas'>"; //col
                              echo "<div class='card'>"; // tarjeta
                              echo "<div class='card-body tarjeta-trabajador'>
                                      <h2 class='card-title' align='center'>$fila[nombre]</h2>
                                      <h4 class='card-subtitle mb-2 text-muted' align='center'>$fila[direccion]</h4>
                                      <div id='ver-mas'>
                                        <hr>
                                        <button type='button' class='btn btn-info bt-accion bt-ver-mas-tra' data-toggle='modal' data-target='#$fila[id]'>
                                          Ver más datos
                                        </button>
                                        <form action='modificar-cliente.php' method='get'><input type='hidden' name='id-cliente' value='$fila[id]'><input class='form-control btn-warning separa-bt mod-bt-tra' type='submit' name='modificar' value='Modificar'></form>
                                      </div>
                                    </div>";
                              echo "</div>"; // tarjeta
                            echo "</div>"; //col

                            // modal con todos los datos del trabajador
                            echo "<div class='modal fade' id='$fila[id]' tabindex='-1' role='dialog' aria-labelledby='ver-datosTitle' aria-hidden='true'>
                                  <div class='modal-dialog modal-dialog-centered' role='document'>
                                    <div class='modal-content'>
                                      <div class='modal-header'>
                                        <h5 align='center' class='modal-title'>Datos de $fila[nombre]</h5>
                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                          <span aria-hidden='true'>&times;</span>
                                        </button>
                                      </div>
                                        <div class='modal-body'>
                                        <p align='center' style='color: #6c757d'><b>Datos de acceso</b></p>
                                        <p align='center'><b>Usuario:</b><br>$fila[usuario]</p>
                                        <p align='center'><b>Contraseña:</b><br>$fila[password]</p>
                                        <hr><p align='center' style='color: #6c757d'><b>Datos del cliente</b></p>
                                        <div id='ver-mas'>
                                          <p align='center'><b>Nombre:</b><br>$fila[nombre]</p>
                                          <p align='center'><b>Denominación social:</b><br>$fila[denominacion_social]
                                          </p>
                                          <p align='center'><b>DNI/CIF:</b><br>$fila[dni_cif]</p>
                                          <p align='center'><b>Dirección:</b><br>$fila[direccion]</p>
                                          <p align='center'><b>Teléfono:</b><br>$fila[telefono]</p>
                                          <p align='center'><b>Email:</b><br>$fila[email]</p>
                                      </div>
                                      </div>
                                      <div class='modal-footer'>
                                        <button type='button' class='btn btn-info' data-dismiss='modal'>Cerrar</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>";

                        }

                      } else {

                        echo '<div class="col-md-4 offset-md-4"><div class="alert alert-info separador" role="alert">
                                <h4><b>¡Vaya!</b> Parece que no tienes más clientes para listar</b></h4>
                                <a href="nuevo-cliente.php">¿Por qué no añades alguno nuevo?</a>
                              </div></div>';

                      }

                    } //datos

                  } // listar



                    mysqli_close($conexion);
            } //buscar


             ?>

          </div> <!-- row -->

          </div> <!-- row -->
                <div class="row">
                  <div class="col-md-2 offset-md-6"> <!-- col paginacion productos -->
                        <nav aria-label="Page navigation example">
                          <ul class="pagination pag-cli">
                            <?php
                              echo "<li class='page-item'><a class='page-link' href='ver-cliente.php?pagina=".($pagina - 1)."'><i class='fas fa-angle-left'></i></a></li><li class='page-item'><a class='page-link' href='ver-cliente.php?pagina=".($pagina + 1)."'><i class='fas fa-angle-right'></i></a></li>";
                             ?>
                          </ul>
                        </nav>
                    </div> <!-- col paginacion productos -->
                </div>

        </div> <!-- container -->

      </div> <!-- container fluid sup -->
  </body>
</html>