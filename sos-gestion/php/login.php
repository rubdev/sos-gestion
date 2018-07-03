<?php
  include 'funciones.php';
  session_start();

  if (isset($_POST['entrar'])) {
    $usuario = $_POST['usuario'];
    $password = $_POST['pass'];

    // paso contraseña a MD5
    $pass_protegida = md5(md5($password));

    // abro conexion con bd
    $conexion = abrirConexion();



    // consulta para CLIENTE
    $sql_clientes = "SELECT id FROM cliente WHERE usuario='$usuario' AND password='$pass_protegida'";
    $es_cliente = mysqli_query($conexion,$sql_clientes);

    if ($es_cliente) {

      if (mysqli_num_rows($es_cliente) > 0) {

        $error_acceder = false;

        $fila = mysqli_fetch_array($es_cliente,MYSQLI_ASSOC);
        $_SESSION['id'] = $fila['id'];
        $_SESSION['tipo_usuario'] = 'cliente';

        // compruebo si hay que recordar la sesión con cookies
        if (isset($_POST['recordar'])) {
          $datos = session_encode();
          setcookie('datos', $datos, time()+(15*24*60*60), '/');
        }

        // redireccion al panel de cliente
        echo "<META HTTP-EQUIV='REFRESH'CONTENT='1;URL=cliente/cliente.php'>";

      } else {

        if ($error_acceder == false) {
          $error_acceder = true;
        }
      }

    }

    // consulta para ADMIN/TRABAJADOR
    $sql_trabajadores = "SELECT id FROM trabajador WHERE usuario='$usuario' AND password='$pass_protegida'";
    $es_trabajador = mysqli_query($conexion,$sql_trabajadores);

    // se realiza el acceso a la aplicación
    if ($es_trabajador) {

      if (mysqli_num_rows($es_trabajador) > 0) {

        $error_acceder = false;

        $fila = mysqli_fetch_array($es_trabajador, MYSQLI_ASSOC);

        // Compruebo si es admin (id-1) o trabajador
        if ($fila['id'] == 1) {
          $_SESSION['id'] = $fila['id'];
          $_SESSION['tipo_usuario'] = 'admin';
        } else {
          $_SESSION['id'] = $fila['id'];
          $_SESSION['tipo_usuario'] = 'trabajador';
        }

        // compruebo si hay que recordar la sesión con cookies
        if (isset($_POST['recordar'])) {
          $datos = session_encode();
          setcookie('datos', $datos, time()+(15*24*60*60), '/');
        }

        // redirecciono al panel de admin o trabajador
        if ($fila['id'] == 1) {
          echo "<META HTTP-EQUIV='REFRESH'CONTENT='1;URL=admin/admin-panel.php'>";
        } else {
          echo "<META HTTP-EQUIV='REFRESH'CONTENT='1;URL=trabajador/trabajador.php'>";
        }

      } else {

      }

    }

    // cierro la conexión con la BD
    mysqli_close($conexion);

  }
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
    <link rel="stylesheet" type="text/css" href="../css/custom-general.css">
    <!-- Optional JavaScript -->
    <!-- Font Awesome -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

    <title>SOS Gestión - Gestiona tu empresa de socorrismo</title>
  </head>
  <body>
    <div class="container-fluid bg-color seccion"> <!-- container fluid -->
      <nav class="navbar fixed-top bg-nav"><!-- nav superior -->
        <a class="navbar-brand" href="../index.php"><img class="img-fluid" src="../img/logo.png" alt="SOS Gestión" width="100" height="50"></a><!-- logo -->
         <form class="form-inline"><!-- Botón acceso -->
          <button class="btn btn-login" type="button"><a href="../index.php" title="Volver">Volver a la web</a></button>
        </form><!-- Botón acceso -->
      </nav> <!-- nav superior -->
      <div class="container pos-container"> <!-- container -->
        <div class="col col-md-8 offset-md-2 col-lg-6 offset-lg-3"> <!-- col -->
          <div class="card">
            <div class="card-body tarjeta-acceder"> <!-- tarjeta -->
              <h2 class="card-title" align="center">Accede a la App</h2>
              <h6 class="card-subtitle mb-2 text-muted" align="center">y gestiona la situación</h6>
              <div class="formulario-login"> <!-- formulario login -->
                <form action="#" method="post">
                  <div class="form-group">  <!-- usuario -->
                    <i class="fas fa-user"></i>
                    <label for="usuario">Usuario</label>
                    <input type="text" name="usuario" class="form-control" id="usuario" placeholder="Introduce tu nombre usuario">
                  </div> <!-- usuario -->
                  <div class="form-group"> <!-- contraseña -->
                    <i class="fas fa-key"></i>
                    <label for="pass">Contraseña</label>
                    <input type="password" name="pass" class="form-control" id="pass" placeholder="Introduce tu contraseña"> <!-- contraseña -->
                  </div>
                  <div class="form-check"> <!-- checkbox -->
                    <input type="checkbox" name="recordar" class="form-check-input" id="sesion">
                    <label class="form-check-label" for="sesion">Mantén mi sesión abierta</label>
                  </div> <!-- checkbox -->
                  <input type="submit" name="entrar" value="Acceder" class="btn btn-acceder">
                </form>
              </div> <!-- formulario login -->
            </div>
          </div> <!-- tarjeta -->
          <?php
            // muestra error de inicio de sesión
            if (isset($error_acceder)) {
              if ($error_acceder == 1) {
                echo '<div class="alert alert-danger msj-error" role="alert">
                      Ups, parace que el <b>usuario</b> o <b>contraseña</b> introducidos no es correcto
                    </div>';
              } else {
                echo '<div class="alert alert-success msj-error" role="alert">
                      <p><b>¡Acceso correcto!</b> Serás redirigido a tu panel de administración<p>
                    </div>';
              }
            }
           ?>
        </div> <!-- col -->
      </div> <!-- container -->
    </div> <!-- container fluid -->
  </body>
</html>