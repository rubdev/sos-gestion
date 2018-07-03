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
    <script type="text/javascript" src="../../js/validaNuevoTrabajador.js"></script>
    <title>SOS Gestión - Nuevo trabajador</title>
  </head>
  <body>
    <div class="container-fluid bg-panel"> <!-- container fluid sup -->
        <?php navSuperior(); ?>
        <div class="container pos-container"> <!-- container -->
          <div class="col col-md-8 offset-md-2 col-lg-6 offset-lg-3"> <!-- col -->
            <div class="card">
              <div class="card-body tarjeta-acceder"> <!-- tarjeta -->
                <h2 class="card-title" align="center">Añadir un nuevo trabajador</h2>
                <h6 class="card-subtitle mb-2 text-muted" align="center">Todos los campos son <b>obligatorios</b> excepto la foto</h6>
                <div class="formulario-login"> <!-- formulario añadir trabajador -->
                  <form class="cmxform" id="validaTrabajador" action="#" method="post" enctype="multipart/form-data">
                    <hr>
                     <p align="center" style="color: #6c757d">Datos de acceso</p>
                    <div class="form-group">  <!-- usuario -->
                      <input type="text" name="usuario" class="form-control" id="usuario" placeholder="Usuario">
                    </div> <!-- usuario -->
                    <div class="form-group"> <!-- contraseña -->
                      <input type="password" name="pass" class="form-control" id="pass" placeholder="Contraseña"> <!-- contraseña -->
                    </div>
                    <hr>
                     <p align="center" style="color: #6c757d">Datos personales</p>
                    <div class="form-group">  <!-- nombre -->
                      <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre">
                    </div> <!-- nombre -->
                    <div class="form-group">  <!-- apellidos -->
                      <input type="text" name="apellidos" class="form-control" id="apellidos" placeholder="Apellidos">
                    </div> <!-- apellidos -->
                    <div class="form-group">  <!-- dni -->
                      <input type="text" name="dni" class="form-control" id="dni" placeholder="DNI">
                    </div> <!-- dni -->
                    <div class="form-group">  <!-- f-nacimiento -->
                      <input type="date" name="fecha" class="form-control" id="fecha" placeholder="Fecha de nacimiento">
                    </div> <!-- f-nacimiento -->
                    <div class="form-group">  <!-- direccion -->
                      <input type="text" name="direccion" class="form-control" id="direccion" placeholder="Dirección">
                    </div> <!-- direccion -->
                    <div class="form-group">  <!-- email -->
                      <input type="email" name="email" class="form-control" id="email" placeholder="Email">
                    </div> <!-- email -->
                    <div class="form-group">  <!-- telefono -->
                      <input type="number" name="telefono" class="form-control" id="telefono" placeholder="Teléfono">
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
                      <input type="text" name="ss" class="form-control" id="ss" placeholder="Nº de la Seguridad Social">
                    </div> <!-- ss -->
                    <hr>
                     <p align="center" style="color: #6c757d">Datos de bancarios</p>
                    <div class="form-group">  <!-- cuenta bancaria -->
                      <input type="text" name="cc" class="form-control" id="cc" placeholder="Nº de cuenta bancaria">
                    </div> <!-- cuenta bancaria -->
                    <hr>
                    <div class="form-group">  <!-- foto -->
                      <p align="center" style="color: #6c757d">Foto del trabajador</p>
                      <input type="file" name="foto" class="form-control input-ico" id="foto">
                    </div> <!-- foto -->
                    <input type="submit" name="añadir" value="Añadir trabajador" class="btn btn-success btn-new">
                    <a href="ver-trabajador.php" class="btn btn-danger">Cancelar y volver</a>
                  </form>
                </div> <!-- formulario añadir trabajador -->
              </div>
            </div> <!-- tarjeta -->
            <!-- Tratamiento del formulario -->
            <?php
              if (isset($_POST['añadir'])) { //isset añadir

                // Recojo datos del formulario
                $usuario = $_POST['usuario'];
                $password = $_POST['pass'];
                $nombre = $_POST['nombre'];
                $apellidos = $_POST['apellidos'];
                $dni = $_POST['dni'];
                $fecha = $_POST['fecha'];
                $direccion = $_POST['direccion'];
                $email = $_POST['email'];
                $telefono = $_POST['telefono'];
                $tipo = $_POST['tipo'];
                $ss = $_POST['ss'];
                $cc = $_POST['cc'];

                // paso md5 para proteger la contraseña
                $pass_segura = md5(md5($password));

                // recojo todo lo necesario para almacenar la foto
                $foto = $_FILES['foto']['name'];
                $foto_tmp = $_FILES['foto']['tmp_name'];
                $foto_type = $_FILES['foto']['type'];
                $foto_size = $_FILES['foto']['size'];

                // variables que servirán para comprobar si hay foto para guardar o no
                $foto_correcta = false;
                $guardar_foto = false;

                // si el tamaño de la foto es mayor que 0 significa que hay foto para guardar
                if ($foto_size > 0) {
                  $guardar_foto = true;
                }

                // si hay foto para guardar se almacenará en bd junto con el resto de datos
                if ($guardar_foto) {

                  // compruebo que sea un tipo de imagen válido
                  if ($foto_type != 'image/jpeg' && $foto_type != 'image/png') {
                    echo '<div class="alert alert-warning separador" role="alert">
                            <h4>Vaya, parece que <b>tipo de imagen</b> seleccionado <b>no es válido</b></h4>
                            <p>Por favor, selecciona un archivo con formato <b>PNG</b> o <b>JPEG</b></p>
                          </div>';
                  }

                  // creo el directorio donde se almacenará si no existe ya
                  if (!file_exists("../../img/img_trabajadores")) {
                    mkdir("../../img/img_trabajadores");
                  }

                  // creo la ruta donde guardar la foto dependiendo del tipo que sea
                  if ($foto_type == "image/png") {
                    $ruta_foto = "../../img/img_trabajadores/$id-$dni".".png";
                  } else if ($foto_type == "image/jpeg"){
                    $ruta_foto = "../../img/img_trabajadores/$id-$dni".".jpg";
                  }

                  // guardo la foto en el servidor
                  if (move_uploaded_file($foto_tmp, $ruta_foto)) {
                    $foto_correcta = true;
                  } else {
                    echo '<div class="alert alert-danger separador" role="alert">
                            <h4>Ups, ha ocurrido un <b>error</b> al guardar la imagen en el servidor</b></h4>
                            <p>Por favor, inténtelo de nuevo</p>
                          </div>';
                    echo "<META HTTP-EQUIV='REFRESH'CONTENT='10;URL=nuevo-trabajador.php'>";
                  }

                  // si se ha guardado la foto correctamente
                  if ($foto_correcta) {

                    // abro conexion con bd y preparo la consulta para insertar
                    $conexion = abrirConexion();
                    $insertar = "INSERT INTO trabajador (id,usuario,password,nombre,apellidos,dni,fecha_nacimiento,direccion,email,telefono,tipo,numero_ss,cuenta_bancaria,foto) VALUES (null,'$usuario','$pass_segura','$nombre','$apellidos','$dni','$fecha','$direccion','$email','$telefono','$tipo','$ss','$cc','$ruta_foto')";

                    $datos = mysqli_query($conexion,$insertar);

                    // ejecuto la consulta
                    if ($datos) {
                      echo '<div class="alert alert-success separador" role="alert">
                            <h4><b>Yuhu!</b> ya tienes un nuevo trabajador guardado</b></h4>
                            <a href="#">¿Porqué no le asignas un cliente ya?</a></br>
                            <a href="#">O también puedes volver al panel de administración</a>
                          </div>';
                    } else {
                      echo '<div class="alert alert-danger separador" role="alert">
                            <h4><b>Ups!</b> parece que ha ocurrido un error al añadir el nuevo trabajador</b></h4>
                          </div>';
                    }

                  }

                } else {

                  // abro conexion con bd y preparo la consulta para insertar

                    //$foto_defecto = '../../img/img_trabajadores/perfil.png';

                    $conexion = abrirConexion();
                    $insertar = "INSERT INTO trabajador (id,usuario,password,nombre,apellidos,dni,fecha_nacimiento,direccion,email,telefono,tipo,numero_ss,cuenta_bancaria) VALUES (null,'$usuario','$pass_segura','$nombre','$apellidos','$dni','$fecha','$direccion','$email','$telefono','$tipo','$ss','$cc')";

                    $datos = mysqli_query($conexion,$insertar);

                    // ejecuto la consulta
                    if ($datos) {
                      echo '<div class="alert alert-success separador" role="alert">
                            <h4><b>Yuhu!</b> ya tienes un nuevo trabajador guardado</b></h4>
                            <a href="asignar-puesto.pnp">¿Porqué no le asignas un cliente ya?</a></br>
                            <a href="admin-panel.php">O también puedes volver al panel de administración</a>
                          </div>';
                    } else {
                      echo '<div class="alert alert-danger separador" role="alert">
                            <h4><b>Ups!</b> parece que ha ocurrido un error al añadir el nuevo trabajador</b></h4>
                          </div>';
                    }
                }

              } // isset añadir

             ?><!-- Tratamiento del formulario -->
          </div> <!-- col -->
        </div> <!-- container -->
      </div> <!-- container fluid sup -->
  </body>
</html>