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
    <script type="text/javascript" src="../../js/validaModTrabajador.js"></script>
    <title>SOS Gestión - Modificar trabajador</title>
  </head>
  <body>
    <div class="container-fluid bg-panel"> <!-- container fluid sup -->
        <?php navSuperior(); ?>
        <div class="container pos-container"> <!-- container -->
          <div class="col col-md-8 offset-md-2 col-lg-6 offset-lg-3"> <!-- col -->
            <?php


            // obtengo los datos del trabajador a modificar
            if (isset($_GET['modificar'])) {
              $id = $_GET['id-trabajador'];

              $conexion = abrirConexion();
              $sql_datos = "SELECT * FROM trabajador WHERE id='$id'";
              $datos_trabajador = mysqli_query($conexion,$sql_datos);

              if ($datos_trabajador) {

                while ($fila = mysqli_fetch_array($datos_trabajador,MYSQLI_ASSOC)) {

                    $usuario = $fila['usuario'];
                    $nombre = $fila['nombre'];
                    $apellidos = $fila['apellidos'];
                    $dni = $fila['dni'];
                    $fecha = $fila['fecha_nacimiento'];
                    $direccion = $fila['direccion'];
                    $email = $fila['email'];
                    $telefono = $fila['telefono'];
                    $tipo = $fila['tipo'];
                    $numero_ss = $fila['numero_ss'];
                    $cuenta_banco = $fila['cuenta_bancaria'];
                    $foto = $fila['foto'];

                }

              }

              mysqli_close($conexion);
            }
         ?>
            <div class="card">
              <div class="card-body tarjeta-acceder"> <!-- tarjeta -->
                <h2 class="card-title" align="center">Modificar trabajador</h2>
                <h6 class="card-subtitle mb-2 text-muted" align="center">Todos los campos son <b>obligatorios</b> excepto la foto</h6>
                <div class="formulario-login"> <!-- formulario añadir trabajador -->
                  <form class="cmxform" id="validaTrabajador" action="#" method="post" enctype="multipart/form-data">
                    <hr>
                     <p align="center" style="color: #6c757d">Datos de acceso</p>
                    <div class="form-group">  <!-- usuario -->
                      <input type="text" name="usuario" class="form-control" id="usuario" value='<?php echo $usuario; ?>'">
                    </div> <!-- usuario -->
                    <div class="form-group"> <!-- contraseña -->
                      <input type="password" name="pass" class="form-control" id="pass" placeholder="Escriba una nueva contraseña "> <!-- contraseña -->
                    </div>
                    <hr>
                     <p align="center" style="color: #6c757d">Datos personales</p>
                    <div class="form-group">  <!-- nombre -->
                      <input type="text" name="nombre" class="form-control" id="nombre" value='<?php echo $nombre; ?>'>
                    </div> <!-- nombre -->
                    <div class="form-group">  <!-- apellidos -->
                      <input type="text" name="apellidos" class="form-control" id="apellidos" value='<?php echo $apellidos; ?>'>
                    </div> <!-- apellidos -->
                    <div class="form-group">  <!-- dni -->
                      <input type="text" name="dni" class="form-control" id="dni" value='<?php echo $dni; ?>'>
                    </div> <!-- dni -->
                    <div class="form-group">  <!-- f-nacimiento -->
                      <input type="date" name="fecha" class="form-control" id="fecha" value='<?php echo $fecha_nacimiento; ?>'>
                    </div> <!-- f-nacimiento -->
                    <div class="form-group">  <!-- direccion -->
                      <input type="text" name="direccion" class="form-control" id="direccion" value='<?php echo $direccion; ?>'>
                    </div> <!-- direccion -->
                    <div class="form-group">  <!-- email -->
                      <input type="email" name="email" class="form-control" id="email" value='<?php echo $email; ?>'>
                    </div> <!-- email -->
                    <div class="form-group">  <!-- telefono -->
                      <input type="number" name="telefono" class="form-control" id="telefono" value='<?php echo $telefono; ?>'>
                    </div> <!-- telefono -->
                    <hr>
                     <p align="center" style="color: #6c757d">Datos profesionales</p>
                    <div class="form-group">  <!-- tipo empleado -->
                      <select class="custom-select" name="tipo">
                        <option value="socorrista">Socorrista</option>
                        <option value="monitor">Monitor</option>
                        <option value="enfermero">Enfermero</option>
                      </select>
                    </div> <!-- tipo empleado -->
                    <div class="form-group">  <!-- ss -->
                      <input type="text" name="ss" class="form-control" id="ss" value='<?php echo $numero_ss; ?>'>
                    </div> <!-- ss -->
                    <hr>
                     <p align="center" style="color: #6c757d">Datos de bancarios</p>
                    <div class="form-group">  <!-- cuenta bancaria -->
                      <input type="text" name="cc" class="form-control" id="cc" value='<?php echo $cuenta_banco; ?>'>
                    </div> <!-- cuenta bancaria -->
                    <hr>
                    <div class="form-group">  <!-- foto -->
                      <p align="center" style="color: #6c757d">Foto del trabajador</p>
                      <input type="file" name="foto" class="form-control input-ico" id="foto">
                      <?php
                      if (isset($foto)) {
                        echo "<p style='color: #6c757d'>Foto actual:</p><img src='$foto' width='150px'></img>";
                      }
                    ?>
                    </div> <!-- foto -->
                    <input type="submit" name="mod" value="Modificar trabajador" class="btn btn-success btn-new">
                    <a href="ver-trabajador.php" class="btn btn-danger">Cancelar y volver</a>
                  </form>
                </div> <!-- formulario añadir trabajador -->
              </div>
            </div> <!-- tarjeta -->
            <?php
              if (isset($_POST['mod'])) {

                $n_usuario = $_POST['usuario'];
                $n_pass = $_POST['pass'];
                $n_nombre = $_POST['nombre'];
                $n_apellidos = $_POST['apellidos'];
                $n_fecha = $_POST['fecha'];
                $n_telefono = $_POST['telefono'];
                $n_dni = $_POST['dni'];
                $n_email = $_POST['email'];
                $n_direccion = $_POST['direccion'];
                $n_tipo = $_POST['tipo'];
                $n_ss = $_POST['ss'];
                $n_cc = $_POST['cc'];
                $n_foto = $_FILES['foto']['name'];
                $n_foto_tmp = $_FILES['foto']['tmp_name'];
                $n_foto_type = $_FILES['foto']['type'];
                $n_foto_size = $_FILES['foto']['size'];

                $pass_segura = md5(md5($n_pass));

                $foto_correcta = false;
                $modificar_foto = false;

                if ($n_foto_size > 0) {
                  $modificar_foto = true;
                }

                if ($modificar_foto) { //mod foto

                  if ($n_foto_type != 'image/jpeg' && $n_foto_type != 'image/png') {
                      echo '<div class="alert alert-warning separador" role="alert">
                              <h4>Vaya, parece que <b>tipo de imagen</b> seleccionado <b>no es válido</b></h4>
                              <p>Por favor, selecciona un archivo con formato <b>PNG</b> o <b>JPEG</b></p>
                            </div>';
                    }

                    if (!file_exists("../../img/img_trabajadores")) {
                      mkdir("../../img/img_trabajadores");
                    }

                    if ($n_foto_type == "image/png") {
                      $ruta_foto = "../../img/img_trabajadores/$id-$dni".".png";
                    } else if ($n_foto_type == "image/jpeg"){
                      $ruta_foto = "../../img/img_trabajadores/$id-$dni".".jpg";
                    }

                    if (move_uploaded_file($n_foto_tmp, $ruta_foto)) {
                      $foto_correcta = true;
                    } else {
                      echo '<div class="alert alert-danger separador" role="alert">
                                <h4>Ups, ha ocurrido un <b>error</b> al guardar la imagen en el servidor</b></h4>
                                <p>Por favor, inténtelo de nuevo</p>
                              </div>';
                    }

                    $conexion = abrirConexion();
                    $sql_actualizar = "UPDATE trabajador SET usuario='$n_usuario',password='$pass_segura',nombre='$n_nombre',apellidos='$n_apellidos',dni='$n_dni',fecha_nacimiento='$n_fecha',direccion='$n_direccion',email='$n_email',telefono='$n_telefono',tipo='$n_tipo',numero_ss='$n_ss',cuenta_bancaria='$n_cc',foto='$ruta_foto' WHERE id='$id'";

                    $actualizar = mysqli_query($conexion,$sql_actualizar);

                    if ($actualizar) {

                      echo '<div class="alert alert-success separador" role="alert">
                            <h4><b>Yuhu!</b> has modificado correctamente los datos del trabajador</b></h4>
                            <a href="ver-trabajador.php">Pulsa aquí para volver al listado de trabajadores</a>
                          </div>';

                    } else {

                      echo '<div class="alert alert-danger separador" role="alert">
                            <h4><b>Ups!</b> parece que ha ocurrido un error al modificar los datos del trabajador</b></h4>
                          </div>';

                    }

                } else { //mod foto

                  $conexion = abrirConexion();
                    $sql_actualizar = "UPDATE trabajador SET usuario='$n_usuario',password='$pass_segura',nombre='$n_nombre',apellidos='$n_apellidos',dni='$n_dni',fecha_nacimiento='$n_fecha',direccion='$n_direccion',email='$n_email',telefono='$n_telefono',tipo='$n_tipo',numero_ss='$n_ss',cuenta_bancaria='$n_cc' WHERE id='$id'";

                    $actualizar = mysqli_query($conexion,$sql_actualizar);

                    if ($actualizar) {

                      echo '<div class="alert alert-success separador" role="alert">
                            <h4><b>Yuhu!</b> has modificado correctamente los datos del trabajador</b></h4>
                            <a href="ver-trabajador.php">Pulsa aquí para volver al listado de trabajadores</a>
                          </div>';

                    } else {

                      echo '<div class="alert alert-danger separador" role="alert">
                            <h4><b>Ups!</b> parece que ha ocurrido un error al modificar los datos del trabajador</b></h4>
                          </div>';

                    }


                } //mod foto

              } //isset formulario
             ?>
          </div> <!-- col -->
        </div> <!-- container -->
      </div> <!-- container fluid sup -->
      <!-- modificacion de datos -->

  </body>
</html>