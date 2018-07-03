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
    <title>SOS Gestión - Mis datos</title>
  </head>
  <body>
    <div class="container-fluid bg-panel seccion"> <!-- container fluid sup -->
        <?php navSuperior(); ?>
        <div class="container pos-container">
          <div class="row"> <!-- row -->
            <div class="col-md-3 offset-md-4 al-centro coloca-botiq-pan-sup"> <!-- col -->
              <a class="btn btn-info separa-bt bot-ir-adp" href="trabajador.php" title="volver al panel de administración"><!-- atras -->
                <i class="fas fa-chevron-circle-left"></i> Ir al panel de administración
              </a><!-- atras -->
            </div> <!-- col -->
          </div><!-- row -->
          <div class="row">
            <div class="col-md-5 offset-md-1  al-centro">
              <h2 class="separa-titulo" align="center">Mis datos personales</h2>
              <?php

                $conexion = abrirConexion();
                $sql_trabajador = "SELECT * FROM trabajador WHERE id='$_SESSION[id]'";

                $datos_trabajador = mysqli_query($conexion,$sql_trabajador);

                if ($datos_trabajador) {

                  $datos = mysqli_fetch_array($datos_trabajador,MYSQLI_ASSOC);

                  $marca_ini = strtotime($datos['fecha_nacimiento']);
                  $fecha_formateada = date('d-m-Y',$marca_ini);

                  if (is_null($datos['foto'])) {
                    echo "<div align='center'><img class='img-fluid img-thumbnail borde-sos rounded-circle' width='150' src='../../img/img_trabajadores/perfil.png'></div>"; //img
                  } else {
                    echo "<div align='center'><img class='img-fluid img-thumbnail borde-sos rounded-circle' width='150' src='$datos[foto]' alt='$datos[usuario]'></div>"; //img

                  }

                  echo "
                        <p class='separa-titulo' align='center' style='color: #6c757d'><b>Datos personales</b></p>
                        <p align='center'><b>Nombre completo:</b><br>$datos[nombre] $datos[apellidos]</p>
                        <p align='center'><b>DNI:</b><br>$datos[dni]</p>
                        <p align='center'><b>Fecha de nacimiento:</b><br>$fecha_formateada</p>
                        <p align='center'><b>Teléfono:</b><br>$datos[telefono]</p>
                        <p align='center'><b>Dirección:</b><br>$datos[direccion]</p>
                        <p align='center'><b>Email:</b><br>$datos[email]</p>
                        <hr><p align='center' style='color: #6c757d'><b>Datos profesionales</b></p>
                        <p align='center'><b>Tipo de trabajador:</b><br>$datos[tipo]</p>
                        <p align='center'><b>Nº Seguridad Social:</b><br>$datos[numero_ss]</p>
                        <hr><p align='center' style='color: #6c757d'><b>Datos bancarios</b></p>
                        <p align='center'><b>Nº cuenta corriente:</b><br>$datos[cuenta_bancaria]</p>
                        <p align='center' class='separa-titulo' style='color: #6c757d'><b>Datos de acceso</b></p>
                        <p align='center'><b>Usuario:</b><br>$datos[usuario]</p>";

                }

               ?>
            </div>
            <div class="col-md-5 offset-md-1  al-centro">
              <h2 class="separa-titulo" align="center">Historial de puestos ocupados</h2>
              <?php

                $conexion = abrirConexion();
                $sql_trabajador = "SELECT o.id_trabajador, o.id_puesto, t.id, t.nombre,t.tipo FROM ocupa o, trabajador t WHERE o.id_trabajador=t.id AND o.id_trabajador='$_SESSION[id]'";
                $trabajador = mysqli_query($conexion,$sql_trabajador);

                if ($trabajador) {

                  $cuenta = mysqli_num_rows($trabajador);

                  echo '<div class="alert alert-info separador" role="alert">
                          <h5><b>Has ocupado '.$cuenta.' puestos</b></h5>
                        </div>';

                  if ($cuenta > 0) {

                    echo "<div class='table-responsive'>"; //responsive
                          echo "<table class='table table-hover'>";
                            echo "<thead class='cabecera-tabla'>
                                      <tr>
                                        <th scope='col'>Fecha de ocupación</th>
                                        <th scope='col'>Para el cliente</th>
                                        <th scope='col'>Tipo de puesto</th>
                                      </tr>
                                  </thead>
                                  <tbody>";

                    while ($fila = mysqli_fetch_array($trabajador, MYSQLI_ASSOC)) {

                      $id_puesto = $fila['id_puesto'];

                      $sql_cliente = "SELECT p.id as id_pu, p.fecha_inicio, p.id_cliente, c.id as id_cli, c.nombre FROM puesto p, cliente c WHERE p.id_cliente=c.id AND p.id = $id_puesto";

                      $cliente = mysqli_query($conexion,$sql_cliente);

                      if ($cliente) {

                        if (mysqli_num_rows($cliente) > 0) {

                          while ($fila2 = mysqli_fetch_array($cliente,MYSQLI_ASSOC)) {

                            $marca_ini = strtotime($fila2['fecha_inicio']);
                            $fecha_formateada = date("d-m-Y", $marca_ini);

                            echo  "<tr>
                                    <td>$fecha_formateada</td>
                                    <td>$fila2[nombre]</td>
                                    <td>$fila[tipo]</td>
                                  </tr>";

                          }

                        }

                      }

                    }

                  }

                  echo "</tbody></table>"; // table

                    echo "</div>"; // responsive

                } else {

                  echo '<div class="alert alert-warning separador" role="alert">
                          <h4><b>Vaya!</b> Parece que aún no has ocupado ningún puesto de trabajo</b></h4>
                        </div>';

                }
               ?>

            </div>
          </div>


        </div> <!-- col -->
      </div> <!-- container fluid sup -->
  </body>
</html>