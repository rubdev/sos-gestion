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
    <title>SOS Gestión - Eliminar productos</title>
  </head>
  <body>
    <div class="container-fluid bg-panel seccion"> <!-- container fluid sup -->
        <?php navSuperior(); ?>
        <div class="container pos-container"> <!-- container -->
          <div class="col col-md-8 offset-md-2 col-lg-6 offset-lg-3"> <!-- col -->
            <div class="card">
              <div class="card-body tarjeta-acceder"> <!-- tarjeta -->
                <h2 class="card-title" align="center">Eliminar productos del inventario</h2>
                <hr>
                     <p align="center" class="ayuda"><i class="fas fa-info-circle"></i> Pulsa el botón eliminar para borrar el producto del inventario</p>
                <div class="formulario-login"> <!-- listado de productos -->
                  <?php //lista productos con opción borrar

                    // abro conexión con la bd y preparo la consulta para listar productos
                    $conexion = abrirConexion();
                    $sql_lista = "SELECT id FROM producto";
                    $listado = mysqli_query($conexion,$sql_lista);

                    if ($listado) {

                      $num_productos = mysqli_num_rows($listado);

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

                      $sql_listar = "SELECT id,nombre
                                   FROM producto
                                   LIMIT $inicio,$paginacion";
                      $datos = mysqli_query($conexion,$sql_listar);

                      // ejecuto la consulta y muestro los productos
                      if ($datos) {

                        if (mysqli_num_rows($datos) > 0) {

                          echo '<div class="table-responsive">'; // tabla responsive
                          echo '<table class="table table-hover">'; //tabla
                          echo '<thead class="cabecera-tabla"><tr><td><b>Producto</b></td><td><b>Eliminar</b></td></tr></thead>';
                          echo '<tbody>';

                            // recorro todos los resultados de la consulta
                            while ($fila = mysqli_fetch_array($datos, MYSQLI_ASSOC)) {
                              echo "<tr><td>$fila[nombre]</td><td><form action='#' method='post'><input type='hidden' name='id' value='$fila[id]'><button class='alert-danger' type='submit' name='borrar'><i class='fas fa-trash-alt'></i></button></form></td></tr>";
                            }

                          echo '<tbody>';
                          echo '</table>'; //tabla
                          echo '</div>'; // tabla responsive
                          echo "<a href='botiquin.php' class='btn btn-danger'>Cancelar y volver</a>";
                          ?>
                            <div class="col-md-5 offset-md-5">
                              <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                  <?php
                                    echo "<li class='page-item'><a class='page-link' href='eliminar-producto.php?pagina=".($pagina - 1)."'><i class='fas fa-angle-left'></i></a></li><li class='page-item'><a class='page-link' href='eliminar-producto.php?pagina=".($pagina + 1)."'><i class='fas fa-angle-right'></i></a></li>";
                                   ?>
                                </ul>
                              </nav>
                            </div>
                          <?php

                        } else {
                          echo '<div class="alert alert-info separador" role="alert">
                                <h4>¡Vaya! Parece que no hay más productos en el inventario</b></h4>
                                <p>Por favor, inténtelo de nuevo</p>
                              </div>';
                        }

                      } // datos

                    } // listado

                    mysqli_close($conexion);

                   ?><!-- lista productos con opción borrar -->
                </div> <!-- listado de productos -->
              </div>
            </div> <!-- tarjeta -->
            <?php //eliminar
              if (isset($_POST['borrar'])) {

                $id = $_POST['id'];

                $conexion = abrirConexion();

                $sql_borrar_almacenados = "DELETE FROM almacena WHERE id_producto='$id'";
                $borrar_almacenados = mysqli_query($conexion,$sql_borrar_almacenados);

                if ($borrar_almacenados) {

                  $sql_borrar_de_avisos = "DELETE FROM aviso WHERE id_producto='$id'";
                  $borrar_de_avisos = mysqli_query($conexion,$sql_borrar_de_avisos);

                  if ($borrar_de_avisos) {

                    $sql_borrar_del_inventario = "DELETE FROM producto WHERE id='$id'";
                    $eliminar_del_inventario = mysqli_query($conexion,$sql_borrar_del_inventario);

                    if ($eliminar_del_inventario) {

                      echo '<div class="alert alert-success separador" role="alert">
                              <h4><b>Perfecto!</b> El producto ha sido eliminado del inventario</b></h4>
                              <a href="admin-panel.php">Volver al panel de administración</a>
                            </div>';

                    } else {

                      echo '<div class="alert alert-danger separador" role="alert">
                              <h4><b>Ups!</b> Parece que ha ocurrido un error al eliminar el producto del inventario</b></h4>
                            </div>';

                    }

                  } else {

                    if ($eliminar_del_inventario) {

                      echo '<div class="alert alert-success separador" role="alert">
                              <h4><b>Perfecto!</b> El producto ha sido eliminado del inventario</b></h4>
                              <a href="admin-panel.php">Volver al panel de administración</a>
                            </div>';

                    } else {

                      echo '<div class="alert alert-danger separador" role="alert">
                              <h4><b>Ups!</b> Parece que ha ocurrido un error al eliminar el producto del inventario</b></h4>
                            </div>';

                    }

                  }



                } else {

                  $sql_borrar_de_avisos = "DELETE FROM aviso WHERE id_producto='$id'";
                  $borrar_de_avisos = mysqli_query($conexion,$sql_borrar_de_avisos);

                  if ($borrar_de_avisos) {

                    $sql_borrar_del_inventario = "DELETE FROM producto WHERE id='$id'";
                    $eliminar_del_inventario = mysqli_query($conexion,$sql_borrar_del_inventario);

                    if ($eliminar_del_inventario) {

                      echo '<div class="alert alert-success separador" role="alert">
                              <h4><b>Perfecto!</b> El producto ha sido eliminado del inventario</b></h4>
                              <a href="admin-panel.php">Volver al panel de administración</a>
                            </div>';

                    } else {

                      echo '<div class="alert alert-danger separador" role="alert">
                              <h4><b>Ups!</b> Parece que ha ocurrido un error al eliminar el producto del inventario</b></h4>
                            </div>';

                    }

                  } else {

                    if ($eliminar_del_inventario) {

                      echo '<div class="alert alert-success separador" role="alert">
                              <h4><b>Perfecto!</b> El producto ha sido eliminado del inventario</b></h4>
                              <a href="admin-panel.php">Volver al panel de administración</a>
                            </div>';

                    } else {

                      echo '<div class="alert alert-danger separador" role="alert">
                              <h4><b>Ups!</b> Parece que ha ocurrido un error al eliminar el producto del inventario</b></h4>
                            </div>';

                    }

                  }
                }

              }
             ?> <!-- eliminar -->
          </div> <!-- col -->
        </div> <!-- container -->
      </div> <!-- container fluid sup -->
  </body>
</html>