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
    <!-- jQuery validate forms -->
    <script type="text/javascript" src="../../js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="../../js/validaIncidencias.js"></script>
    <title>SOS Gestión - Panel de Gestión</title>
  </head>
  <body>
    <div class="container-fluid bg-panel seccion"> <!-- container fluid sup -->
        <?php navSuperior(); ?>
        <div class="container pos-container">

          <div class="row"> <!-- row -->

            <div class="col col-md-8 offset-md-2 col-lg-6 offset-lg-3"> <!-- col -->
              <div class="card">
                <div class="card-body tarjeta-acceder"> <!-- tarjeta -->
                  <h2 class="card-title" align="center">Notificar incidencia</h2>
                  <h6 class="card-subtitle mb-2 text-muted" align="center">Todos los campos son <b>obligatorios</b></h6>
                  <div class="formulario-login"> <!-- formulario notificar incidencia -->
                    <form class="cmxform" id="validaIncidencia" action="#" method="post" enctype="multipart/form-data">
                      <hr>
                       <p align="center" style="color: #6c757d">Datos de la incidencia</p>
                       <div class="form-group">  <!-- titulo -->
                        <p><b>¿Qué ha pasado?</b></p>
                        <input type="text" name="titulo" class="form-control" id="titulo">
                      </div> <!-- titulo -->
                      <div class="form-group">  <!-- descripcion -->
                        <p><b>Escribe una breve descripción de la incidencia</b></p>
                        <textarea id="descripcion" rows="4" cols="35" name="descripcion"></textarea>
                      </div> <!-- descripcion -->
                      <div class="form-group">  <!-- estado -->
                        <p><b>¿En qué estado se encuentra la incidencia?</b></p>
                        <select name="estado">
                          <option value="Solventada">Solventada</option>
                          <option value="No solventada">No solventada</option>
                        </select>
                      </div> <!-- estado -->
                      <div class="form-group">  <!-- gravedad -->
                        <p><b>¿Cuál es la gravedad de la incidencia?</b></p>
                        <select name="gravedad">
                          <option value="Alta">Alta</option>
                          <option value="Media">Media</option>
                          <option value="Baja">Baja</option>
                        </select>
                      </div> <!-- gravedad -->
                      <input type="submit" name="notificar" value="Notificar incidencia" class="btn btn-success btn-new">
                      <a href="mis-incidencias.php" class="btn btn-danger">Cancelar y volver</a>
                    </form>
                  </div> <!-- formulario notificar incidencia -->
                </div>
              </div> <!-- tarjeta -->

              <?php

                  if ( isset($_POST['notificar']) ) {

                    //datos formulario
                    $nombre = $_POST['titulo'];
                    $descripcion = $_POST['descripcion'];
                    $estado = $_POST['estado'];
                    $gravedad = $_POST['gravedad'];

                    //fecha de la incidencia
                    $fecha = date("Y-m-d");

                    // id trabajador
                    $id_trabajador = $_SESSION['id'];

                    //id cliente
                    $conexion = abrirConexion();
                    $sql_puesto = "SELECT o.id_trabajador, o.id_puesto, t.id, t.tipo FROM ocupa o, trabajador t WHERE o.id_trabajador = '$id_trabajador'";
                    $tiene_trabajo = mysqli_query($conexion,$sql_puesto);

                    if ($tiene_trabajo) {

                      if (mysqli_num_rows($tiene_trabajo) > 0) {

                        $fila = mysqli_fetch_array($tiene_trabajo,MYSQLI_ASSOC);

                        $tipo_puesto = $fila['tipo'];
                        $puesto_id = $fila['id_puesto'];
                        $sql_cliente = "SELECT id_cliente FROM puesto WHERE id = '$puesto_id'";
                        $id_puesto = mysqli_query($conexion, $sql_cliente);

                        if ( $id_puesto ) {

                          // consigo el id del cliente
                          $fila = mysqli_fetch_array($id_puesto,MYSQLI_ASSOC);
                          $id_cliente = $fila['id_cliente'];

                          //envio incidencia a BD
                          $sql_notificar = "INSERT INTO incidencia VALUES (null,'$descripcion','$fecha','$estado','$gravedad','$nombre','$id_trabajador','$id_cliente')";

                          $notificar = mysqli_query($conexion,$sql_notificar);

                          // ejecuto la consulta
                          if ($notificar) {
                            echo '<div class="alert alert-success separador" role="alert">
                                    <h4><b>¡Okey!</b> Has notificado correctamente la incidencia</b></h4>
                                    <a href="trabajador.php">Pulsa aquí para volver a tu página de trabajador</a>
                                  </div>';
                          } else {
                            echo '<div class="alert alert-danger separador" role="alert">
                                    <h4><b>¡Ups!</b> parece que ha ocurrido un error al enviar la incidencia</b></h4>
                                  </div>';
                          }


                        }

                      }

                    }

                    mysqli_close($conexion);

                  }



               ?>

            </div> <!-- col -->

          </div><!-- row -->
        </div> <!-- col -->
      </div> <!-- container fluid sup -->
  </body>
</html>