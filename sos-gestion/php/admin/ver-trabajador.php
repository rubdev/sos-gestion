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
    <title>SOS Gestión - Ver trabajadores</title>
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
                    <div class="input-group buscar-grupo">
                      <span>
                        <i class="fas fa-search icon-buscar"></i>
                      </span>
                      <input type="text" class="form-control buscar" placeholder="Búsqueda por nombre" size="6" name="buscar_trabajador">
                    </div>
                    <a class="btn btn-success separa-bt colocar-bt-trabajador" href="nuevo-trabajador.php" title="añadir trabajador"><!-- nuevo trabajador -->
                      <i class="fas fa-plus-circle"></i></i> Añadir nuevo trabajador
                    </a><!-- nuevo trabajador -->
                   <!-- <a class="btn btn-danger separa-bt" href="eliminar-trabajador.php" title="eliminar trabajador"> eliminar
                      <i class="fas fa-trash-alt"></i> Dar de baja a un trabajador
                    </a> eliminar -->
                    <a class="btn btn-info separa-bt mov-w" id="administracion" href="admin-panel.php" title="volver al area de administración"><!-- atras -->
                      <i class="fas fa-chevron-circle-left"></i> Ir al panel de administración
                    </a><!-- atras -->
                  </div> <!-- buscar -->
              </form>


            </div>
          <div class="row"> <!-- row -->

            <?php

            if (isset($_POST['buscar_trabajador'])) { //buscar
              $buscar = $_POST['buscar_trabajador'];

              $conexion = abrirConexion();
              $sql_buscar = "SELECT * FROM trabajador WHERE nombre like '%$buscar%' OR apellidos like '%$buscar%'";
              $busqueda = mysqli_query($conexion,$sql_buscar);

              // hago la búsqueda en bd
              if ($busqueda) {

                if (mysqli_num_rows($busqueda) > 0) {

                      while ($fila = mysqli_fetch_array($busqueda,MYSQLI_ASSOC)) {
                        if ($fila['id'] != 1 ){
                          echo "<div class='col-md-3 offset-md-1 separa-tarjetas'>"; //col
                            echo "<div class='card'>"; // tarjeta
                            if (is_null($fila['foto'])) {
                              echo "<img class='card-img-top' src='../../img/img_trabajadores/perfil.png'>";
                            } else {
                              echo "<img class='card-img-top' src='$fila[foto]'>";
                            }
                            echo "<div class='card-body tarjeta-trabajador'>
                                    <h2 class='card-title' align='center'>$fila[nombre]</h2>
                                    <h4 class='card-subtitle mb-2 text-muted' align='center'>$fila[tipo]</h4>
                                    <div id='ver-mas'>
                                      <hr>
                                      <button type='button' class='btn btn-info bt-accion bt-ver-mas-tra' data-toggle='modal' data-target='#$fila[id]'>
                                        Ver más datos
                                      </button>
                                      <form action='modificar-trabajador.php' method='get'><input type='hidden' name='id-trabajador' value='$fila[id]'><input class='form-control btn-warning separa-bt mod-bt-tra' type='submit' name='modificar' value='Modificar'></form>
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
                                      <hr><p align='center' style='color: #6c757d'><b>Datos personales</b></p>
                                      <div id='ver-mas'>
                                        <p align='center'><b>Nombre completo:</b><br>$fila[nombre] $fila[apellidos]</p>
                                        <p align='center'><b>DNI:</b><br>$fila[dni]</p>
                                        <p align='center'><b>Fecha de nacimiento:</b><br>$fila[fecha_nacimiento]</p>
                                        <p align='center'><b>Teléfono:</b><br>$fila[telefono]</p>
                                        <p align='center'><b>Dirección:</b><br>$fila[direccion]</p>
                                        <p align='center'><b>Email:</b><br>$fila[email]</p>
                                        <hr><p align='center' style='color: #6c757d'><b>Datos profesionales</b></p>
                                        <p align='center'><b>Tipo de trabajador:</b><br>$fila[tipo]</p>
                                        <p align='center'><b>Nº Seguridad Social:</b><br>$fila[numero_ss]</p>
                                        <hr><p align='center' style='color: #6c757d'><b>Datos bancarios</b></p>
                                        <p align='center'><b>Nº cuenta corriente:</b><br>$fila[cuenta_bancaria]</p>
                                    </div>
                                    </div>
                                    <div class='modal-footer'>
                                      <button type='button' class='btn btn-info' data-dismiss='modal'>Cerrar</button>
                                    </div>
                                  </div>
                                </div>
                              </div>";
                        }

                      }

                    } else {

                      echo '<div class="alert alert-danger separador" role="alert">
                              <h4><b>Ups</b> Parece que no tienes ningún trabajador con ese nombre</b></h4>
                              <p>¿Porqué no intentas realizar una nueva búsqueda?</p>
                              <a href="ver-trabajador.php">O también puedes volver al listado de trabajadores</a>
                            </div>';

                    }

              }


            } else { //buscar

                  // abro conexión y listo los trabajadores en bd
                  $conexion = abrirConexion();
                  $sql_listar = "SELECT * FROM trabajador";
                  $listar = mysqli_query($conexion,$sql_listar);

                  if ($listar) { // listar

                    $num_trabajadores = mysqli_num_rows($listar);

                    if ($num_trabajadores > 0) {
                      $paginacion = 4;
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

                    $datos_sql = "SELECT * FROM trabajador LIMIT $inicio,$paginacion";
                    $datos = mysqli_query($conexion,$datos_sql);

                  if ($datos) {

                    if (mysqli_num_rows($datos) > 0) {

                      while ($fila = mysqli_fetch_array($datos,MYSQLI_ASSOC)) {
                        if ($fila['id'] != 1 ){
                          echo "<div class='col-md-3 offset-md-1 separa-tarjetas'>"; //col
                            echo "<div class='card'>"; // tarjeta
                            if (is_null($fila['foto'])) {
                              echo "<img class='card-img-top' src='../../img/img_trabajadores/perfil.png'>";
                            } else {
                              echo "<img class='card-img-top' src='$fila[foto]'>";
                            }
                            echo     "<div class='card-body tarjeta-trabajador'>
                                    <h2 class='card-title' align='center'>$fila[nombre]</h2>
                                    <h4 class='card-subtitle mb-2 text-muted' align='center'>$fila[tipo]</h4>
                                    <div id='ver-mas'>
                                      <hr>
                                      <button type='button' class='btn btn-info bt-accion bt-ver-mas-tra' data-toggle='modal' data-target='#$fila[id]'>
                                        Ver más datos
                                      </button>
                                      <form action='modificar-trabajador.php' method='get'><input type='hidden' name='id-trabajador' value='$fila[id]'><input class='form-control btn-warning separa-bt mod-bt-tra' type='submit' name='modificar' value='Modificar'></form>
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
                                      <hr><p align='center' style='color: #6c757d'><b>Datos personales</b></p>
                                      <div id='ver-mas'>
                                        <p align='center'><b>Nombre completo:</b><br>$fila[nombre] $fila[apellidos]</p>
                                        <p align='center'><b>DNI:</b><br>$fila[dni]</p>
                                        <p align='center'><b>Fecha de nacimiento:</b><br>$fila[fecha_nacimiento]</p>
                                        <p align='center'><b>Teléfono:</b><br>$fila[telefono]</p>
                                        <p align='center'><b>Dirección:</b><br>$fila[direccion]</p>
                                        <p align='center'><b>Email:</b><br>$fila[email]</p>
                                        <hr><p align='center' style='color: #6c757d'><b>Datos profesionales</b></p>
                                        <p align='center'><b>Tipo de trabajador:</b><br>$fila[tipo]</p>
                                        <p align='center'><b>Nº Seguridad Social:</b><br>$fila[numero_ss]</p>
                                        <hr><p align='center' style='color: #6c757d'><b>Datos bancarios</b></p>
                                        <p align='center'><b>Nº cuenta corriente:</b><br>$fila[cuenta_bancaria]</p>
                                    </div>
                                    </div>
                                    <div class='modal-footer'>
                                      <button type='button' class='btn btn-info' data-dismiss='modal'>Cerrar</button>
                                    </div>
                                  </div>
                                </div>
                              </div>";
                        }


                      }

                    } else {

                      echo '<div class="col-md-4 offset-md-4">
                            <div class="alert alert-info separador" role="alert">
                              <h4>¡Vaya!<b></b> no tienes más trabajadores para listar</b></h4>
                              <a href="nuevo-trabajador.php">¿Porqué no añades algún nuevo trabajador?</a></br>
                              <a href="admin-panel.php">O también puedes volver al panel de administración</a>
                            </div></div>';

                    }

                  }

                  } // listar


            } //buscar

            mysqli_close($conexion);

             ?>
          </div> <!-- row -->
                <div class="row">
                  <div class="col-md-2 offset-md-6"> <!-- col paginacion productos -->
                        <nav aria-label="Page navigation example">
                          <ul class="pagination trab-pag">
                            <?php
                              echo "<li class='page-item'><a class='page-link' href='ver-trabajador.php?pagina=".($pagina - 1)."'><i class='fas fa-angle-left'></i></a></li><li class='page-item'><a class='page-link' href='ver-trabajador.php?pagina=".($pagina + 1)."'><i class='fas fa-angle-right'></i></a></li>";
                             ?>
                          </ul>
                        </nav>
                    </div> <!-- col paginacion productos -->
                </div>
        </div> <!-- container -->

      </div> <!-- container fluid sup -->
  </body>
</html>