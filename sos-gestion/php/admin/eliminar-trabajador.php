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
    <title>SOS Gestión - Finalizar contrato trabajador</title>
  </head>
  <body>
    <div class="container-fluid bg-panel"> <!-- container fluid sup -->
        <?php navSuperior(); ?>
        <div class="container pos-container"> <!-- container -->
          <div class="col col-md-8 offset-md-2 col-lg-6 offset-lg-3"> <!-- col -->
            <div class="card">
              <div class="card-body tarjeta-acceder"> <!-- tarjeta -->
                <h2 class="card-title" align="center">Eliminar trabajador</h2>
                <h6 class="card-subtitle mb-2 text-muted" align="center">Es hora de decir adiós a un empleado</h6>
                <hr>
                     <p align="center" class="ayuda"><i class="fas fa-info-circle"></i> Pulsa el botón eliminar para borrar al trabajador</p>
                <div class="formulario-login"> <!-- listado de trabajadores -->
                  <?php //lista trabajadores con opción borrar

                    // abro conexión con la bd y preparo la consulta para listar trabajadores
                    $conexion = abrirConexion();
                    $sql_listar = "SELECT id FROM trabajador";
                    $listar = mysqli_query($conexion,$sql_listar);

                    if ($listar) { // listar

                      $num_trabajadores = mysqli_num_rows($listar);

                      if ($num_trabajadores > 0) {
                        $paginacion = 7;
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

                      $sql_mostrar = "SELECT id,nombre,apellidos,tipo FROM trabajador LIMIT $inicio,$paginacion";
                      $datos = mysqli_query($conexion,$sql_mostrar);

                      // ejecuto la consulta y muestro los trabajadores
                      if ($datos) {

                        echo '<div class="table-responsive">'; // tabla responsive
                        echo '<table class="table table-hover">'; //tabla
                        echo '<thead class="cabecera-tabla"><tr><td><b>Nombre</b></td><td><b>Apellidos</b></td><td><b>Tipo de empleado</b></td><td><b>Eliminar</b></td></tr></thead>';
                        echo '<tbody>';

                          // recorro todos los resultados de la consulta
                          while ($fila = mysqli_fetch_array($datos, MYSQLI_ASSOC)) {
                            if ($fila['id'] != 1) {

                              echo "<tr><td>$fila[nombre]</td><td>$fila[apellidos]</td><td>$fila[tipo]</td><td><form action='#' method='post'><input type='hidden' name='id' value='$fila[id]'><button class='alert-danger' type='submit' name='borrar'><i class='fas fa-trash-alt'></i></button></form></td></tr>";

                            }

                          }

                        echo '<tbody>';
                        echo '</table>'; //tabla
                        echo "<a href='ver-trabajador.php' class='btn btn-danger'>Cancelar y volver</a>";
                        ?>
                        <div class="col-md-5 offset-md-5">
                          <nav aria-label="Page navigation example">
                          <ul class="pagination">
                            <?php
                              echo "<li class='page-item'><a class='page-link' href='eliminar-trabajador.php?pagina=".($pagina - 1)."'><i class='fas fa-angle-left'></i></a></li><li class='page-item'><a class='page-link' href='eliminar-trabajador.php?pagina=".($pagina + 1)."'><i class='fas fa-angle-right'></i></a></li>";
                             ?>
                          </ul>
                          </nav>
                          </div>
                        <?php
                        echo '</div>'; // tabla responsive



                      } else {

                        echo '<div class="alert alert-danger separador" role="alert">
                              <h4>Ups, ha ocurrido un <b>error</b> al buscar a tus trabjadores en el servidor</b></h4>
                              <p>Por favor, inténtelo de nuevo</p>
                            </div>';
                        echo "<META HTTP-EQUIV='REFRESH'CONTENT='10;URL=eliminar-trabajador.php'>";

                      }

                    } // listar

                    mysqli_close($conexion);

                   ?><!-- lista trabajadores con opción borrar -->
                </div> <!-- listado de trabajadores -->
              </div>
            </div> <!-- tarjeta -->
            <?php //eliminar
            // borrado del trabajador
              if (isset($_POST['borrar'])) {

                $id = $_POST['id'];
                echo '<h1>'.$id.'</h1>';

                // Primero elimino la foto del servidor
                $conexion = abrirConexion();
                $foto = "SELECT foto FROM trabajador WHERE id='$id'";
                $url = mysqli_query($conexion,$foto);

                // compruebo si tengo la url de la foto
                if ($url) {
                  echo '<h1>hay foto</h1>';
                  // compruebo si el trabajador tiene foto
                  if (mysqli_num_rows($url) > 0) {

                    // elimino la foto
                    $fila = mysqli_fetch_array($url,MYSQLI_ASSOC);

                    if (is_null($fila['foto'])) {

                    } else {
                      unlink($fila['foto']);
                    }

                  }

                }

                // ahora elimino al trabajador de la base de datos
                $sql_borrar = "DELETE FROM trabajador WHERE id='$id'";
                $eliminar = mysqli_query($conexion,$sql_borrar);

                if ($eliminar) {
                  echo '<div class="alert alert-success separador" role="alert">
                          <h4><b>Perfecto!</b> Has eliminado correctamente al trabajador</b></h4>
                          <a href="#">Volver al panel de administración</a>
                        </div>';
                } else {
                  echo '<div class="alert alert-danger separador" role="alert">
                          <h4><b>Ups!</b> Parece que ha ocurrido un error al eliminar al trabajador</h4>
                          <p><b>Por favor, comprueba que el trabajador no esté ocupando ningún puesto actualmente y vuelve a intentarlo</b></p>
                        </div>';
                }

              }
           ?><!-- eliminar -->
          </div> <!-- col -->
        </div> <!-- container -->
      </div> <!-- container fluid sup -->
  </body>
</html>