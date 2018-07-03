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
    <title>SOS Gestión - Asignar puesto de trabajo</title>
  </head>
  <body>
    <div class="container-fluid bg-panel seccion"> <!-- container fluid sup -->
        <?php navSuperior(); ?>

        <div class="container pos-container"> <!-- container -->
          <div class="row"> <!-- row -->
            <div class="col col-md-8 offset-md-2 col-lg-6 offset-lg-3"> <!-- col -->
              <div class="card">
                <div class="card-body tarjeta-acceder"> <!-- tarjeta -->
                  <h2 class="card-title" align="center">Asignar puesto a un trabajador</h2>
                  <h6 class="card-subtitle mb-2 text-muted" align="center">Todos los campos son <b>obligatorios</b></h6>
                  <div class="formulario-login"> <!-- formulario asignar trabajador -->
                    <form action="#" method="post" enctype="multipart/form-data">
                      <hr>
                       <p align="center" style="color: #6c757d">Datos del puesto</p>
                      <div class="form-group">  <!-- puestos -->
                        <p><b>Cliente que necesita cubrir el puesto</b></p>
                        <select name="puesto" class="custom-select">
                          <?php

                            $conexion = abrirConexion();
                            $sql_puesto = "SELECT * FROM puesto";

                            $query_puesto = mysqli_query($conexion,$sql_puesto);

                            if ($query_puesto) {

                              while ($puesto = mysqli_fetch_array($query_puesto)) {

                                $sql_ocupados = "SELECT * FROM ocupa WHERE id_puesto = '$puesto[id]'";
                                $query_ocupados = mysqli_query($conexion,$sql_ocupados);

                                $num_ocupados = mysqli_num_rows($query_ocupados);

                                if (!$num_ocupados >= $puesto['numero_trabajadores']) {

                                  $sql_cliente = "SELECT nombre FROM cliente WHERE id='$puesto[id_cliente]'";
                                  $query_cliente = mysqli_query($conexion,$sql_cliente);

                                  if ($query_cliente) {

                                    $cliente = mysqli_fetch_array($query_cliente,MYSQLI_ASSOC);
                                    echo "<option value=$puesto[id]>$cliente[nombre] ($puesto[tipo])</option>";
                                  }

                                }

                              }

                            }

                            mysqli_close($conexion);

                          ?>
                        </select>
                      </div> <!-- puestos -->
                      <div class="form-group">  <!-- trabajadores disponibles -->
                        <p><b>Trabajador disponible</b></p>
                        <select name="trabajador" class="custom-select">
                          <?php

                            $conexion = abrirConexion();
                            $sql = "SELECT id,nombre,tipo FROM trabajador WHERE id NOT IN (SELECT id_trabajador FROM ocupa)";
                            $trabajadores_disponibles = mysqli_query($conexion,$sql);

                            if ($trabajadores_disponibles) {

                              while ($fila = mysqli_fetch_array($trabajadores_disponibles,MYSQLI_ASSOC)) {

                                if ($fila['id'] != 1) {
                                  echo "<option value=$fila[id]>$fila[nombre] - $fila[tipo]</option>";
                                }

                              }

                            } else {
                              echo "<p><b>No hay trabajadores disponibles</b></p>";
                            }

                            mysqli_close($conexion);

                          ?>
                        </select>
                      </div> <!-- trabajadores disponibles -->
                      <input type="submit" name="asignar" value="Asignar trabajador" class="btn btn-success btn-new">
                      <a href="gestion-puestos.php" class="btn btn-danger">Cancelar y volver</a>
                    </form>
                  </div> <!-- formulario asignar trabajador -->
                </div>
              </div> <!-- tarjeta -->

              <?php

                  if (isset($_POST['asignar'])) {

                    $fecha = date("y-m-d");

                    if (isset($_POST['puesto'])) {
                      $id_puesto = $_POST['puesto'];
                      $id_tra = $_POST['trabajador'];

                      $conexion = abrirConexion();
                      $sql_asignar = "INSERT INTO ocupa (id_trabajador,id_puesto,fecha) VALUES ('$id_tra','$id_puesto','$fecha')";
                      $asignar_puesto = mysqli_query($conexion,$sql_asignar);

                      if ($asignar_puesto) {

                        echo '<div class="alert alert-success separador" role="alert">
                              <h4><b>Enhorabuena!</b> ya has cubierto un puesto de trabajo</b></h4>
                              <a href="gestion-puestos.php">Volver al panel de administración</a>
                            </div>';

                      } else {

                        echo '<div class="alert alert-danger separador" role="alert">
                              <h4><b>Ups!</b> parece que ha ocurrido un error al asignar el puesto de trabajo</b></h4>
                            </div>';

                      }

                    } else {
                      echo '<div class="alert alert-danger separador" role="alert">
                              <h4><b>¡Ups!</b> Debes seleccionar un puesto al que asignar al trabajador</b></h4>
                            </div>';
                    }

                  }

               ?>

            </div> <!-- col -->
          </div> <!-- row -->
        </div><!-- container -->
      </div> <!-- container fluid sup -->
  </body>
</html>