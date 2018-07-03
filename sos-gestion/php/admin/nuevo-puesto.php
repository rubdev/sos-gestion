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
     <!-- jQuery validate forms -->
    <script type="text/javascript" src="../../js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="../../js/validaPuestos.js"></script>
    <title>SOS Gestión - Puestos de trabajo</title>
  </head>
  <body>
    <div class="container-fluid bg-panel seccion"> <!-- container fluid sup -->
        <?php navSuperior(); ?>
        <div class="container pos-container"> <!-- container -->
          <div class="row"> <!-- row -->
            <div class="col col-md-8 offset-md-2 col-lg-6 offset-lg-3"> <!-- col -->
              <div class="card">
                <div class="card-body tarjeta-acceder"> <!-- tarjeta -->
                  <h2 class="card-title" align="center">Añadir un nuevo puesto de trabajo</h2>
                  <h6 class="card-subtitle mb-2 text-muted" align="center">Todos los campos son <b>obligatorios</b></h6>
                  <div class="formulario-login"> <!-- formulario añadir trabajador -->
                    <form class="cmxform" id="validaPuesto" action="#" method="post" enctype="multipart/form-data">
                      <hr>
                       <p align="center" style="color: #6c757d">Datos del puesto</p>
                      <div class="form-group">  <!-- fecha ini -->
                        <p><b>Fecha de inicio</b></p>
                        <input type="date" name="f_ini" class="form-control" id="f_ini">
                      </div> <!-- fecha ini -->
                      <div class="form-group">  <!-- fecha fin -->
                        <p><b>Fecha de fin</b></p>
                        <input type="date" name="f_fin" class="form-control" id="f_fin">
                      </div> <!-- fecha fin -->
                      <div class="form-group">  <!-- num trabajador -->
                        <p><b>Nº de trabajadores necesarios</b></p>
                        <input type="number" name="num" class="form-control" id="num">
                      </div> <!-- num trabajador -->
                      <div class="form-group">  <!-- tipo -->
                        <p><b>Tipo de trabajador necesario</b></p>
                        <select class="custom-select" name="tipo">
                          <option value="socorrista">Socorrista</option>
                          <option value="monitor">Monitor</option>
                          <option value="enfermero">Enfermero</option>
                        </select>
                      </div> <!-- tipo -->
                      <div class="form-group">  <!-- cliente -->
                        <p><b>Cliente que necesita cubrir el puesto</b></p>
                        <select name="cliente" class="custom-select">
                          <?php

                            $conexion = abrirConexion();
                            $sql = "SELECT id,nombre FROM cliente";
                            $clientes = mysqli_query($conexion,$sql);

                            if ($clientes) {

                              while ($fila = mysqli_fetch_array($clientes,MYSQLI_ASSOC)) {
                                echo "<option value=$fila[id]>$fila[nombre]</option>";
                              }

                            } else {
                              echo "<p><b>No hay clientes para asignar</b></p>";
                            }

                            mysqli_close($conexion);

                          ?>
                        </select>
                      </div> <!-- cliente -->
                      <input type="submit" name="añadir" value="Añadir puesto de trabajo" class="btn btn-success btn-new">
                      <a href="gestion-puestos.php" class="btn btn-danger">Cancelar y volver</a>
                    </form>
                  </div> <!-- formulario añadir trabajador -->
                </div>
              </div> <!-- tarjeta -->
              <?php

                  if (isset($_POST['añadir'])) {

                    $inicio = $_POST['f_ini'];
                    $fin = $_POST['f_fin'];
                    $num = $_POST['num'];
                    $tipo = $_POST['tipo'];
                    $cliente = $_POST['cliente'];

                    // se añade el puesto en bd
                    $conexion = abrirConexion();
                    $sql = "INSERT INTO puesto VALUES (null,'$inicio','$fin','$num','$tipo','$cliente')";

                    $insertar = mysqli_query($conexion,$sql);

                    if ($insertar) {
                      echo '<div class="alert alert-success separador" role="alert">
                            <h4><b>Vale!</b> ya tienes un nuevo puesto de trabajo que cubrir</b></h4>
                            <a href="asignar-puesto.php">¿Porqué no le asignas un trabajador ya?</a></br>
                            <a href="admin-panel.php">O también puedes volver al panel de administración</a>
                          </div>';
                    } else {
                      echo '<div class="alert alert-danger separador" role="alert">
                            <h4><b>Ups!</b> parece que ha ocurrido un error al añadir puesto de trabajo</b></h4>
                          </div>';
                    }

                    mysqli_close($conexion);

                  }

               ?>
            </div> <!-- col -->
          </div> <!-- row -->
        </div><!-- container -->
      </div> <!-- container fluid sup -->
  </body>
</html>