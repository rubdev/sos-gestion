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
    <title>SOS Gestión - Panel de Gestión</title>
  </head>
  <body>
    <div class="container-fluid bg-panel seccion"> <!-- container fluid sup -->
        <?php navSuperior(); ?>
        <div class="container pos-container">
          <div class="row"> <!-- row -->
            <div class="col  al-centro">
              <h1 align="center" class="separa-titulo">Gestionar</h1>
              <a class="btn btn-primary separa-bt btn-block" href="ver-trabajador.php" title="añadir puesto"><!-- trabajadores -->
                <i class="fas fa-id-card-alt"></i> Trabajadores
              </a><!-- trabajadores -->

              <a class="btn btn-primary separa-bt btn-block" href="ver-cliente.php" title="asignar puesto"><!-- clientes -->
                <i class="fas fa-briefcase"></i> Clientes
              </a><!-- clientes -->

              <a class="btn btn-primary separa-bt btn-block" href="gestion-puestos.php" title="volver al area de administración"><!-- Puestos de trabajo -->
                <i class="fas fa-hockey-puck"></i> Puestos de trabajo
              </a><!-- Puestos de trabajo -->

              <a class="btn btn-primary separa-bt btn-block" href="incidencias.php" title="volver al area de administración"><!-- incidencias -->
                <i class="fas fa-exclamation-circle"></i></i> Incidencias
              </a><!-- incidencias -->

              <a class="btn btn-primary separa-bt btn-block" href="botiquin.php" title="volver al area de administración"><!-- botiquin -->
                <i class="fas fa-prescription-bottle-alt"></i> Botiquín
              </a><!-- botiquin -->

              </div>
              <div class="col al-centro">
                <h1 align="center" class="separa-titulo">Información rápida</h1>
                <div class="card"> <!-- info -->
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                      <!-- muestro datos sobre trabajadores -->
                      <?php

                        $conexion = abrirConexion();
                        $sql_tra = "SELECT id FROM trabajador";

                        $trabajadores = mysqli_query($conexion,$sql_tra);

                        if ($trabajadores) {

                          $num_trabajadores = mysqli_num_rows($trabajadores);
                          $trabajadores_sin_admin = $num_trabajadores - 1;
                          echo '<p align="center"><b>Trabajadores en nómina</b> <span class="badge badge-pill badge-info">'.$trabajadores_sin_admin.'</span></p>
                                ';

                        }

                        mysqli_close($conexion);

                       ?> <!-- sobre trabajadores -->
                    </li>
                    <li class="list-group-item">
                      <!-- muestro datos sobre clientes -->
                      <?php

                        $conexion = abrirConexion();
                        $sql_cli = "SELECT id FROM cliente";

                        $clientes = mysqli_query($conexion,$sql_cli);

                        if ($clientes) {

                          $num_clientes = mysqli_num_rows($clientes);

                          echo '<p align="center"><b>Clientes actuales</b> <span class="badge badge-pill badge-info">'.$num_clientes.'</span></p>';

                        }

                        mysqli_close($conexion);

                       ?> <!-- sobre clientes -->
                    </li>
                    <li class="list-group-item">
                      <!-- muestro datos sobre puestos -->
                      <?php

                        $conexion = abrirConexion();
                        $sql_puesto = "SELECT id FROM puesto";

                        $puesto = mysqli_query($conexion,$sql_puesto);

                        if ($puesto) {

                          $num_puesto = mysqli_num_rows($puesto);

                          echo '<p align="center"><b>Puestos de trabajo</b> <span class="badge badge-pill badge-info">'.$num_puesto.'</span></p>
                                ';

                        }

                        $sql_ocupa = "SELECT id_trabajador FROM ocupa";

                        $ocupa = mysqli_query($conexion,$sql_ocupa);

                        if ($ocupa) {

                          $num_ocupa = mysqli_num_rows($ocupa);

                          echo '<p align="center"><b>De los cuales ocupados</b> <span class="badge badge-pill badge-info">'.$num_ocupa.'</span></p>
                                ';

                        }

                        mysqli_close($conexion);

                       ?> <!-- sobre puestos -->
                    </li>
                  </ul>
                </div> <!-- info -->
                 <!-- muestro datos sobre incidencias -->
                 <!-- muestro datos sobre botiquin -->
              </div>
          </div> <!-- row -->
        </div>

      </div> <!-- container fluid sup -->
  </body>
</html>