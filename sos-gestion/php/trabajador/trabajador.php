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
    <title>SOS Gestión - Panel de trabajador</title>
  </head>
  <body>
    <div class="container-fluid bg-panel seccion"> <!-- container fluid sup -->
        <?php navSuperior(); ?>
        <div class="container pos-container">
          <div class="row"> <!-- row -->

            <div class="col  al-centro">
              <?php
                  $tu_id = $_SESSION['id'];
                  $conexion = abrirConexion();
                  $sql_nombre = "SELECT nombre FROM trabajador WHERE id='$tu_id'";
                  $tu_nombre = mysqli_query($conexion,$sql_nombre);

                  if ($tu_nombre) {

                    $fila = mysqli_fetch_array($tu_nombre, MYSQLI_ASSOC);
                    echo "<h1 align='center' class='separa-titulo'>Bienvenido, $fila[nombre]</h1>";

                  }

                  mysqli_close($conexion);
               ?>
               <h4 align="center">¿Qué quieres hacer?</h2>
                <a class="btn btn-primary separa-bt btn-block" href="datos-trabajador.php" title="Ver mis datos"><!-- trabajadores -->
                  <i class="fas fa-id-card-alt"></i> Ver mis datos
                </a><!-- trabajadores -->

                <a class="btn btn-primary separa-bt btn-block" href="mis-incidencias.php" title="Mis incidencias"><!-- incidencias -->
                  <i class="fas fa-exclamation-circle"></i></i> Incidencias
                </a><!-- incidencias -->

                <a class="btn btn-primary separa-bt btn-block" href="mi-botiquin.php" title="Aviso de stock en botiquín"><!-- botiquin -->
                  <i class="fas fa-prescription-bottle-alt"></i> Botiquín
                </a><!-- botiquin -->
            </div> <!-- col -->

            <div class="col al-centro">
              <?php

                $tu_id = $_SESSION['id'];
                $conexion = abrirConexion();

                $sql_empleo = "SELECT tipo FROM trabajador WHERE id='$_SESSION[id]'";
                $query_empleo = mysqli_query($conexion,$sql_empleo);

                if ($query_empleo) {
                  $tr = mysqli_fetch_array($query_empleo,MYSQLI_ASSOC);
                  $mi_puesto = $tr['tipo'];
                }

                $sql_puesto = "SELECT o.id_trabajador, o.id_puesto, t.tipo as empleo FROM ocupa o, trabajador t WHERE o.id_trabajador = '$tu_id'";
                $tiene_trabajo = mysqli_query($conexion,$sql_puesto);

                if ( $tiene_trabajo ) {

                  if (mysqli_num_rows($tiene_trabajo) > 0) {

                    $fila = mysqli_fetch_array($tiene_trabajo,MYSQLI_ASSOC);
                    $tipo_puesto = $fila['empleo'];
                    $puesto_id = $fila['id_puesto'];
                    $sql_cliente = "SELECT id_cliente FROM puesto WHERE id = '$puesto_id'";
                    $id_puesto = mysqli_query($conexion, $sql_cliente);



                    if ($id_puesto) {

                      $fila = mysqli_fetch_array($id_puesto,MYSQLI_ASSOC);
                      $id_cliente = $fila['id_cliente'];

                      $sql_nombre_cliente = "SELECT nombre,direccion FROM cliente WHERE id='$id_cliente'";
                      $nom_cli = mysqli_query($conexion,$sql_nombre_cliente);

                      if ($nom_cli) {
                        $fila = mysqli_fetch_array($nom_cli,MYSQLI_ASSOC);
                        $nombre_cli = $fila['nombre'];
                        $direccion = $fila['direccion'];

                      } else {
                        echo "Error al obterner el nombre del cliente";
                      }

                    } else {
                      echo 'error al obtener el id del cliente';
                    }

                    echo "<h3 align='center' class='separa-titulo'>Tu lugar de trabajo es <b> $nombre_cli </b></h3>
                          <p align='center'>La dirección del trabajo es <b>$direccion</b></p>
                          <p align='center'>Puesto que ocupas:<b> $mi_puesto </b></p>
                          <p align='center'>Tu horario de trabajo es de <b>10:00 a 19:30</b></p>
                          <div align='center' class='alert alert-warning' role='alert'>
                            <h5><b>Información de contacto importante</b></h5>
                            <p>Teléfono del supervisor: <a href='tel:+34666777888'>666777888</a></p>
                            <p>Email del supervisor: <a href='mailto:supervisor@tusupervisor.com?Subject=Consulta trabajo' target='_top'>supervisor@tusupervisor.com</a></p>
                            <p>Emergencias: <a href='tel:112'>112</a></p>
                            <p>Policía: <a href='tel:091'>091</a></p>
                          </div>";

                  } else {

                    echo "<div class='alert alert-warning' role='alert'>
                          <h3>Vaya, aún no te han asignado un puesto de trabajo</h3>
                        </div>";

                  }

                } else {
                  echo "<div class='alert alert-warning separa-titulo' role='alert'>
                          <h3>Vaya, aún no te han asignado un puesto de trabajo</h3>
                        </div>";
                }

                mysqli_close($conexion);

               ?>
            </div>

          </div><!-- row -->
        </div> <!-- col -->
      </div> <!-- container fluid sup -->
  </body>
</html>