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
    <script type="text/javascript" src="../../js/validaProductos.js"></script>
    <title>SOS Gestión - Añadir producto</title>
  </head>
  <body>
    <div class="container-fluid bg-panel"> <!-- container fluid sup -->
        <?php navSuperior(); ?>
        <div class="container pos-container"> <!-- container -->
          <div class="col col-md-8 offset-md-2 col-lg-6 offset-lg-3"> <!-- col -->
            <div class="card">
              <div class="card-body tarjeta-acceder"> <!-- tarjeta -->
                <h2 class="card-title" align="center">Añadir producto al inventario</h2>
                <h6 class="card-subtitle mb-2 text-muted" align="center">Todos los campos son <b>obligatorios</b></h6>
                <div class="formulario-login"> <!-- formulario añadir trabajador -->
                  <form class="cmxform" id="validaProducto" action="#" method="post" enctype="multipart/form-data">
                    <hr>
                     <p align="center" style="color: #6c757d">Datos del producto</p>
                    <div class="form-group">  <!-- nombre -->
                      <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre del producto">
                    </div> <!-- nombre -->
                    <div class="form-group">  <!-- uso -->
                      <textarea id="uso" placeholder="Indicaciones de uso del producto" rows="4" cols="35" name="uso"></textarea>
                    </div> <!-- uso -->
                    <input type="submit" name="insertar" value="Añadir producto" class="btn btn-success btn-new">
                    <a href="botiquin.php" class="btn btn-danger">Cancelar y volver</a>
                  </form>
                </div> <!-- formulario añadir trabajador -->
              </div>
            </div> <!-- tarjeta -->
            <?php
              // tratamiento del formulario
              if (isset($_POST['insertar'])) {

                  $nombre = $_POST['nombre'];
                  $uso = $_POST['uso'];

                  $conexion = abrirConexion();
                  $sql_insertar = "INSERT INTO producto VALUES (null,'$nombre','$uso')";

                  $insertar = mysqli_query($conexion,$sql_insertar);

                  if ($insertar) {

                    echo '<div class="alert alert-success separador" role="alert">
                            <h4><b>De acuerdo!</b> ya tienes un nuevo producto en el inventario</b></h4>
                          </div>';

                  } else {
                    echo '<div class="alert alert-danger separador" role="alert">
                            <h4><b>Ups!</b> parece que ha ocurrido un error al añadir el producto al inventario</b></h4>
                          </div>';
                  }

              }
             ?>
          </div> <!-- col -->
        </div> <!-- container -->
      </div> <!-- container fluid sup -->
  </body>
</html>