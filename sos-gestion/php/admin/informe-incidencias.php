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
    <!-- <script type="text/javascript" src="../../js/scripts.js"></script> -->
    <title>SOS Gestión - Informe de incidencias</title>
  </head>
  <body>
    <div class="container-fluid bg-panel-ver seccion"> <!-- container fluid sup -->
        <?php navSuperior(); ?>
        <div class="container pos-container"> <!-- container -->
          <div class="row"> <!-- row -->
            <div class="col-md-8 offset-md-2 al-centro">
              <form action="#" method="post" accept-charset="utf-8">
                <div class="form-group">  <!-- buscar -->
                    <div class="input-group buscar-grupo">
                      <span>
                        <i class="fas fa-search icon-buscar"></i>
                      </span>
                      <input type="text" class="form-control buscar" placeholder="Búsqueda por cliente" size="6" name="buscar_nombre">
                    </div>
                    </div>

                   </form>
                   <form action="#" method="post" accept-charset="utf-8">
                      <div class="form-group">  <!-- buscar -->
                        <div class="input-group buscar-grupo">
                          <input type="submit" class="btn btn-primary" name="buscar_estado" value="Buscar por estado">
                          <select class="custom-select" name="estado">
                            <option value="Solventada">Solventada</option>
                            <option value="No solventada">No solventada</option>
                          </select>
                        </div>
                      </div>
                    </form>
                    <form action="#" method="post" accept-charset="utf-8">
                      <div class="form-group">  <!-- buscar -->
                        <div class="input-group buscar-grupo">
                          <input type="submit" class="btn btn-primary" name="buscar_gravedad" value="Buscar por gravedad">
                          <select class="custom-select" name="gravedad">
                            <option value="Alta">Alta</option>
                            <option value="Media">Media</option>
                            <option value="Baja">Baja</option>
                          </select>
                        </div>
                      </div>
                    </form>
                    <a class="btn btn-success separa-bt" href="informe-incidencias.php" title="ver informe de incidencias"><!-- atras -->
                      <i class="fas fa-file-alt"></i> Informe completo de incidencias
                    </a><!-- atras -->
                    <a class="btn btn-info separa-bt" href="admin-panel.php" title="volver al area de administración"><!-- atras -->
                      <i class="fas fa-chevron-circle-left"></i> Ir al panel de administración
                    </a><!-- atras -->
             </div> <!-- buscar -->
            </div> <!-- row -->
            </div>
          <div class="row"> <!-- row -->
            <div class="col-md-4 offset-md-4">
                <p align="center" class="ayuda "><i class="fas fa-info-circle"></i><b> Aquí tienes un informe completo de todas las incidencias registradas</b></p>
            </div>
            <div class="col-md-8 offset-md-2 ">

                  <?php

                    if (isset($_POST['buscar_nombre'])) { // busqueda por nombre

                      $buscar = $_POST['buscar_nombre'];

                      $conexion = abrirConexion();
                      $sql_lista = "SELECT * FROM incidencia";
                      $query = mysqli_query($conexion,$sql_lista);

                      if ($query) { // query

                        $num_incidencias = mysqli_num_rows($query);

                        if ($num_incidencias > 0) {
                          $paginacion = 10;
                          $pagina = false;
                        }

                        if (isset($_GET['pagina'])) {
                          $pagina = $_GET['pagina'];
                        }

                        if (!$pagina) {
                          $inicio = 0;
                          $pagina = 1;
                        } else {
                          $inicio = ($pagina - 1) * $paginacion;
                        }

                        $sql_incidencias = "SELECT * FROM incidencia LIMIT $inicio,$paginacion";
                        $incidencias = mysqli_query( $conexion, $sql_incidencias );

                        if ( $incidencias ) {

                          if (mysqli_num_rows($incidencias) > 0) {

                            echo "<div class='table-responsive'>
                                  <table class='table table-hover'>
                                    <thead class='cabecera-tabla'>
                                      <tr>
                                        <th scope='col'>Cliente</th>
                                        <th scope='col'>Trabajador</th>
                                        <th scope='col'>Incidencia</th>
                                        <th scope='col'>Fecha</th>
                                        <th scope='col'>Estado</th>
                                      </tr>
                                    </thead>
                                    <tbody class='tabla-incidencias'>";

                            // saco incidencias
                            while ( $fila = mysqli_fetch_array($incidencias, MYSQLI_ASSOC) ) {

                              $id_cli = $fila['id_cliente'];
                              $id_tra = $fila['id_trabajador'];

                              $sql_cli = "SELECT nombre FROM cliente WHERE id = '$id_cli' AND nombre LIKE '%$buscar%'";
                              $cli_nom = mysqli_query($conexion,$sql_cli) or die(mysqli_error($conexion));

                              // busco nombre de cliente
                              if ($cli_nom) {

                                while ($fila_cli = mysqli_fetch_array($cli_nom,MYSQLI_ASSOC)) {

                                    $sql_tra = "SELECT nombre FROM trabajador WHERE id = '$id_tra'" or die(mysqli_error($conexion));
                                    $tra_nom = mysqli_query($conexion,$sql_tra);

                                    // saco nombre de trabajador
                                    if ($tra_nom) {

                                      while ($fila_tra = mysqli_fetch_array($tra_nom,MYSQLI_ASSOC)) {

                                        echo "<tr>
                                                <td>$fila_cli[nombre]</td>
                                                <td>$fila_tra[nombre]</td>
                                                <td><button type='button' class='btn btn-info bt-accion bt-circulo' data-toggle='modal' data-target='#$fila[id]'><i class='fas fa-info-circle'></i></button> $fila[nombre]</td>
                                                <td>$fila[fecha]</td>";
                                        if ($fila['estado'] == 'Solventada') {

                                          echo "<td><button disabled type='button' class='btn btn-success' data-toggle='modal' data-target='#$fila[id]estado'>$fila[estado] <i class='fas fa-exclamation-circle'></i></i></button></td></tr>";

                                        } else {

                                          echo "<td><button disabled type='button' class='btn btn-danger' data-toggle='modal' data-target='#$fila[id]estado'>$fila[estado] <i class='fas fa-exclamation-circle'></i></i></button></td></tr>";

                                        }

                                        //modal descripción
                                        echo "<div class='modal fade' id='$fila[id]' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                                <div class='modal-dialog' role='document'>
                                                  <div class='modal-content modal-custom'>
                                                    <div class='modal-header'>
                                                      <h5 class='modal-title' id='exampleModalLabel'><b>Descripción de la incidencia</b></h5>
                                                      <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                        <span aria-hidden='true'>&times;</span>
                                                      </button>
                                                    </div>
                                                    <div class='modal-body'>
                                                      <p>$fila[descripcion]</p>
                                                      <p><b>Gravedad: </b>$fila[gravedad]</p>
                                                    </div>
                                                    <div class='modal-footer'>
                                                      <button type='button' class='btn btn-danger' data-dismiss='modal'>Cerrar</button>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>";

                                        //modal cambiar estado
                                        echo "<div class='modal fade' id='$fila[id]estado' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                                <div class='modal-dialog' role='document'>
                                                  <div class='modal-content modal-custom'>
                                                    <div class='modal-header'>
                                                      <h5 class='modal-title' id='exampleModalLabel'><b>Cambiar estado de la incidencia</b></h5>
                                                      <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                        <span aria-hidden='true'>&times;</span>
                                                      </button>
                                                    </div>
                                                    <div class='modal-body'>
                                                      <form action='#' method='post'>
                                                        <div class='form-group'>
                                                          <p><b>Elige el nuevo estado de la incidencia $fila[nombre]</b></p>
                                                          <select name='cambiar_est'>
                                                            <option value='Solventada'>Solventada</option>
                                                            <option value='No solventada'>No solventada</option>
                                                          </select>
                                                        </div>
                                                    </div>
                                                    <div class='modal-footer'>
                                                    <input type='hidden' name='id_inc' value='$fila[id]'>
                                                    <input type='submit' name='mod' value='Cambiar estado' class='btn btn-success btn-new'>
                                                      <button type='button' class='btn btn-danger' data-dismiss='modal'>Cancelar</button>
                                                      </form>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>";

                                        // cambiar estado de la incidencia
                                        if (isset($_POST['mod'])) {
                                          $cambiar_est = $_POST['cambiar_est'];
                                          $id_inc = $_POST['id_inc'];
                                          $sql_cambiar = "UPDATE incidencia SET estado='$cambiar_est' WHERE id='$id_inc'";
                                          $cambiar = mysqli_query($conexion,$sql_cambiar);

                                          if ($cambiar) {
                                            echo "<META HTTP-EQUIV='REFRESH'CONTENT='0;URL=incidencias.php'>";
                                          } else {
                                            echo '<div class="alert alert-danger separador" role="alert">
                                                      <h4><b>Vaya!</b> Parece que no se ha podido cambiar el estado de la incidencia</b></h4>
                                                  </div>';
                                          }

                                        }

                                      }

                                    }

                                }

                              }

                            }

                            echo "</tbody></table></div>"; //cierra tabla

                          } else {

                            echo '<div class="col-md-4 offset-md-4"><div class="alert alert-info separador" role="alert">
                                      <h4><b>¡Vaya, que bien!</b> parece que no tienes más incidencias</b></h4>
                                    </div></div>';

                          }

                        }

                      } // query



                    } else if (isset($_POST['buscar_estado'])) { // busqueda por estado

                      $buscar = $_POST['estado'];

                      $conexion = abrirConexion();
                      $sql_lista = "SELECT * FROM incidencia WHERE estado='$buscar'";
                      $query = mysqli_query($conexion,$sql_lista);

                      if ($query) { // query

                        $num_incidencias = mysqli_num_rows($query);

                        if ($num_incidencias > 0) {
                          $paginacion = 10;
                          $pagina = false;
                        }

                        if (isset($_GET['pagina'])) {
                          $pagina = $_GET['pagina'];
                        }

                        if (!$pagina) {
                          $inicio = 0;
                          $pagina = 1;
                        } else {
                          $inicio = ($pagina - 1) * $paginacion;
                        }

                        $sql_incidencias = "SELECT * FROM incidencia WHERE estado='$buscar' LIMIT $inicio,$paginacion";
                        $incidencias = mysqli_query( $conexion, $sql_incidencias );

                        if ( $incidencias ) {

                          if (mysqli_num_rows($incidencias) > 0) {

                            echo "<div class='table-responsive'>
                                  <table class='table table-hover'>
                                    <thead class='cabecera-tabla'>
                                      <tr>
                                        <th scope='col'>Cliente</th>
                                        <th scope='col'>Trabajador</th>
                                        <th scope='col'>Incidencia</th>
                                        <th scope='col'>Fecha</th>
                                        <th scope='col'>Estado</th>
                                      </tr>
                                    </thead>
                                    <tbody class='tabla-incidencias'>";

                            // saco incidencias
                            while ( $fila = mysqli_fetch_array($incidencias, MYSQLI_ASSOC) ) {

                              $id_cli = $fila['id_cliente'];
                              $id_tra = $fila['id_trabajador'];

                              $sql_cli = "SELECT nombre FROM cliente WHERE id = '$id_cli'";
                              $cli_nom = mysqli_query($conexion,$sql_cli) or die(mysqli_error($conexion));

                              // busco nombre de cliente
                              if ($cli_nom) {

                                while ($fila_cli = mysqli_fetch_array($cli_nom,MYSQLI_ASSOC)) {

                                    $sql_tra = "SELECT nombre FROM trabajador WHERE id = '$id_tra'" or die(mysqli_error($conexion));
                                    $tra_nom = mysqli_query($conexion,$sql_tra);

                                    // saco nombre de trabajador
                                    if ($tra_nom) {

                                      while ($fila_tra = mysqli_fetch_array($tra_nom,MYSQLI_ASSOC)) {

                                        echo "<tr>
                                                <td>$fila_cli[nombre]</td>
                                                <td>$fila_tra[nombre]</td>
                                                <td><button type='button' class='btn btn-info bt-accion bt-circulo' data-toggle='modal' data-target='#$fila[id]'><i class='fas fa-info-circle'></i></button> $fila[nombre]</td>
                                                <td>$fila[fecha]</td>";
                                        if ($fila['estado'] == 'Solventada') {

                                          echo "<td><button disabled type='button' class='btn btn-success' data-toggle='modal' data-target='#$fila[id]estado'>$fila[estado] <i class='fas fa-exclamation-circle'></i></i></button></td></tr>";

                                        } else {

                                          echo "<td><button disabled type='button' class='btn btn-danger' data-toggle='modal' data-target='#$fila[id]estado'>$fila[estado] <i class='fas fa-exclamation-circle'></i></i></button></td></tr>";

                                        }

                                        //modal descripción
                                        echo "<div class='modal fade' id='$fila[id]' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                                <div class='modal-dialog' role='document'>
                                                  <div class='modal-content modal-custom'>
                                                    <div class='modal-header'>
                                                      <h5 class='modal-title' id='exampleModalLabel'><b>Descripción de la incidencia</b></h5>
                                                      <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                        <span aria-hidden='true'>&times;</span>
                                                      </button>
                                                    </div>
                                                    <div class='modal-body'>
                                                      <p>$fila[descripcion]</p>
                                                      <p><b>Gravedad: </b>$fila[gravedad]</p>
                                                    </div>
                                                    <div class='modal-footer'>
                                                      <button type='button' class='btn btn-danger' data-dismiss='modal'>Cerrar</button>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>";

                                        //modal cambiar estado
                                        echo "<div class='modal fade' id='$fila[id]estado' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                                <div class='modal-dialog' role='document'>
                                                  <div class='modal-content modal-custom'>
                                                    <div class='modal-header'>
                                                      <h5 class='modal-title' id='exampleModalLabel'><b>Cambiar estado de la incidencia</b></h5>
                                                      <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                        <span aria-hidden='true'>&times;</span>
                                                      </button>
                                                    </div>
                                                    <div class='modal-body'>
                                                      <form action='#' method='post'>
                                                        <div class='form-group'>
                                                          <p><b>Elige el nuevo estado de la incidencia $fila[nombre]</b></p>
                                                          <select name='cambiar_est'>
                                                            <option value='Solventada'>Solventada</option>
                                                            <option value='No solventada'>No solventada</option>
                                                          </select>
                                                        </div>
                                                    </div>
                                                    <div class='modal-footer'>
                                                    <input type='hidden' name='id_inc' value='$fila[id]'>
                                                    <input type='submit' name='mod' value='Cambiar estado' class='btn btn-success btn-new'>
                                                      <button type='button' class='btn btn-danger' data-dismiss='modal'>Cancelar</button>
                                                      </form>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>";

                                        // cambiar estado de la incidencia
                                        if (isset($_POST['mod'])) {
                                          $cambiar_est = $_POST['cambiar_est'];
                                          $id_inc = $_POST['id_inc'];
                                          $sql_cambiar = "UPDATE incidencia SET estado='$cambiar_est' WHERE id='$id_inc'";
                                          $cambiar = mysqli_query($conexion,$sql_cambiar);

                                          if ($cambiar) {
                                            echo "<META HTTP-EQUIV='REFRESH'CONTENT='0;URL=incidencias.php'>";
                                          } else {
                                            echo '<div class="alert alert-danger separador" role="alert">
                                                      <h4><b>Vaya!</b> Parece que no se ha podido cambiar el estado de la incidencia</b></h4>
                                                  </div>';
                                          }

                                        }

                                      }

                                    }

                                }

                              }

                            }

                            echo "</tbody></table></div>"; //cierra tabla

                          } else {

                            echo '<div class="col-md-4 offset-md-4"><div class="alert alert-info separador" role="alert">
                                      <h4><b>¡Vaya, que bien!</b> parece que no tienes más incidencias</b></h4>
                                    </div></div>';

                          }

                        }

                      } // query

                    } else if (isset($_POST['buscar_gravedad'])) { // busqueda por gravedad

                      $buscar = $_POST['gravedad'];

                      $conexion = abrirConexion();
                      $sql_lista = "SELECT * FROM incidencia WHERE gravedad='$buscar'";
                      $query = mysqli_query($conexion,$sql_lista);

                      if ($query) { // query

                        $num_incidencias = mysqli_num_rows($query);

                        if ($num_incidencias > 0) {
                          $paginacion = 10;
                          $pagina = false;
                        }

                        if (isset($_GET['pagina'])) {
                          $pagina = $_GET['pagina'];
                        }

                        if (!$pagina) {
                          $inicio = 0;
                          $pagina = 1;
                        } else {
                          $inicio = ($pagina - 1) * $paginacion;
                        }

                        $sql_incidencias = "SELECT * FROM incidencia WHERE gravedad='$buscar' LIMIT $inicio,$paginacion";
                        $incidencias = mysqli_query( $conexion, $sql_incidencias );

                        if ( $incidencias ) {

                          if (mysqli_num_rows($incidencias) > 0) {

                            echo "<div class='table-responsive'>
                                  <table class='table table-hover'>
                                    <thead class='cabecera-tabla'>
                                      <tr>
                                        <th scope='col'>Cliente</th>
                                        <th scope='col'>Trabajador</th>
                                        <th scope='col'>Incidencia</th>
                                        <th scope='col'>Fecha</th>
                                        <th scope='col'>Estado</th>
                                      </tr>
                                    </thead>
                                    <tbody class='tabla-incidencias'>";

                            // saco incidencias
                            while ( $fila = mysqli_fetch_array($incidencias, MYSQLI_ASSOC) ) {

                              $id_cli = $fila['id_cliente'];
                              $id_tra = $fila['id_trabajador'];

                              $sql_cli = "SELECT nombre FROM cliente WHERE id = '$id_cli'";
                              $cli_nom = mysqli_query($conexion,$sql_cli) or die(mysqli_error($conexion));

                              // busco nombre de cliente
                              if ($cli_nom) {

                                while ($fila_cli = mysqli_fetch_array($cli_nom,MYSQLI_ASSOC)) {

                                    $sql_tra = "SELECT nombre FROM trabajador WHERE id = '$id_tra'" or die(mysqli_error($conexion));
                                    $tra_nom = mysqli_query($conexion,$sql_tra);

                                    // saco nombre de trabajador
                                    if ($tra_nom) {

                                      while ($fila_tra = mysqli_fetch_array($tra_nom,MYSQLI_ASSOC)) {

                                        echo "<tr>
                                                <td>$fila_cli[nombre]</td>
                                                <td>$fila_tra[nombre]</td>
                                                <td><button type='button' class='btn btn-info bt-accion bt-circulo' data-toggle='modal' data-target='#$fila[id]'><i class='fas fa-info-circle'></i></button> $fila[nombre]</td>
                                                <td>$fila[fecha]</td>";
                                        if ($fila['estado'] == 'Solventada') {

                                          echo "<td><button disabled type='button' class='btn btn-success' data-toggle='modal' data-target='#$fila[id]estado'>$fila[estado] <i class='fas fa-exclamation-circle'></i></i></button></td></tr>";

                                        } else {

                                          echo "<td><button disabled type='button' class='btn btn-danger' data-toggle='modal' data-target='#$fila[id]estado'>$fila[estado] <i class='fas fa-exclamation-circle'></i></i></button></td></tr>";

                                        }

                                        //modal descripción
                                        echo "<div class='modal fade' id='$fila[id]' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                                <div class='modal-dialog' role='document'>
                                                  <div class='modal-content modal-custom'>
                                                    <div class='modal-header'>
                                                      <h5 class='modal-title' id='exampleModalLabel'><b>Descripción de la incidencia</b></h5>
                                                      <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                        <span aria-hidden='true'>&times;</span>
                                                      </button>
                                                    </div>
                                                    <div class='modal-body'>
                                                      <p>$fila[descripcion]</p>
                                                      <p><b>Gravedad: </b>$fila[gravedad]</p>
                                                    </div>
                                                    <div class='modal-footer'>
                                                      <button type='button' class='btn btn-danger' data-dismiss='modal'>Cerrar</button>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>";

                                        //modal cambiar estado
                                        echo "<div class='modal fade' id='$fila[id]estado' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                                <div class='modal-dialog' role='document'>
                                                  <div class='modal-content modal-custom'>
                                                    <div class='modal-header'>
                                                      <h5 class='modal-title' id='exampleModalLabel'><b>Cambiar estado de la incidencia</b></h5>
                                                      <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                        <span aria-hidden='true'>&times;</span>
                                                      </button>
                                                    </div>
                                                    <div class='modal-body'>
                                                      <form action='#' method='post'>
                                                        <div class='form-group'>
                                                          <p><b>Elige el nuevo estado de la incidencia $fila[nombre]</b></p>
                                                          <select name='cambiar_est'>
                                                            <option value='Solventada'>Solventada</option>
                                                            <option value='No solventada'>No solventada</option>
                                                          </select>
                                                        </div>
                                                    </div>
                                                    <div class='modal-footer'>
                                                    <input type='hidden' name='id_inc' value='$fila[id]'>
                                                    <input type='submit' name='mod' value='Cambiar estado' class='btn btn-success btn-new'>
                                                      <button type='button' class='btn btn-danger' data-dismiss='modal'>Cancelar</button>
                                                      </form>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>";

                                        // cambiar estado de la incidencia
                                        if (isset($_POST['mod'])) {
                                          $cambiar_est = $_POST['cambiar_est'];
                                          $id_inc = $_POST['id_inc'];
                                          $sql_cambiar = "UPDATE incidencia SET estado='$cambiar_est' WHERE id='$id_inc'";
                                          $cambiar = mysqli_query($conexion,$sql_cambiar);

                                          if ($cambiar) {
                                            echo "<META HTTP-EQUIV='REFRESH'CONTENT='0;URL=incidencias.php'>";
                                          } else {
                                            echo '<div class="alert alert-danger separador" role="alert">
                                                      <h4><b>Vaya!</b> Parece que no se ha podido cambiar el estado de la incidencia</b></h4>
                                                  </div>';
                                          }

                                        }

                                      }

                                    }

                                }

                              }

                            }

                            echo "</tbody></table></div>"; //cierra tabla

                          } else {

                            echo '<div class="col-md-4 offset-md-4"><div class="alert alert-info separador" role="alert">
                                      <h4><b>¡Vaya, que bien!</b> parece que no tienes más incidencias</b></h4>
                                    </div></div>';

                          }

                        }

                      } // query

                    } else { //listo todas las incidencias
                      $conexion = abrirConexion();
                      $sql_lista = "SELECT * FROM incidencia";
                      $query = mysqli_query($conexion,$sql_lista);

                      if ($query) { // query

                        $num_incidencias = mysqli_num_rows($query);

                        if ($num_incidencias > 0) {
                          $paginacion = 10;
                          $pagina = false;
                        }

                        if (isset($_GET['pagina'])) {
                          $pagina = $_GET['pagina'];
                        }

                        if (!$pagina) {
                          $inicio = 0;
                          $pagina = 1;
                        } else {
                          $inicio = ($pagina - 1) * $paginacion;
                        }

                        $sql_incidencias = "SELECT * FROM incidencia ORDER BY fecha DESC LIMIT $inicio,$paginacion";
                        $incidencias = mysqli_query( $conexion, $sql_incidencias );

                        if ( $incidencias ) {

                          if (mysqli_num_rows($incidencias) > 0) {

                            echo "<div class='table-responsive'>
                                  <table class='table table-hover'>
                                    <thead class='cabecera-tabla'>
                                      <tr>
                                        <th scope='col'>Cliente</th>
                                        <th scope='col'>Trabajador</th>
                                        <th scope='col'>Incidencia</th>
                                        <th scope='col'>Fecha</th>
                                        <th scope='col'>Estado</th>
                                      </tr>
                                    </thead>
                                    <tbody class='tabla-incidencias'>";

                            // saco incidencias
                            while ( $fila = mysqli_fetch_array($incidencias, MYSQLI_ASSOC) ) {

                              $id_cli = $fila['id_cliente'];
                              $id_tra = $fila['id_trabajador'];

                              $sql_cli = "SELECT nombre FROM cliente WHERE id = '$id_cli'";
                              $cli_nom = mysqli_query($conexion,$sql_cli) or die(mysqli_error($conexion));

                              // busco nombre de cliente
                              if ($cli_nom) {

                                while ($fila_cli = mysqli_fetch_array($cli_nom,MYSQLI_ASSOC)) {

                                    $sql_tra = "SELECT nombre FROM trabajador WHERE id = '$id_tra'" or die(mysqli_error($conexion));
                                    $tra_nom = mysqli_query($conexion,$sql_tra);

                                    // saco nombre de trabajador
                                    if ($tra_nom) {

                                      while ($fila_tra = mysqli_fetch_array($tra_nom,MYSQLI_ASSOC)) {

                                        echo "<tr>
                                                <td>$fila_cli[nombre]</td>
                                                <td>$fila_tra[nombre]</td>
                                                <td><button disabled type='button' class='btn btn-info bt-accion bt-circulo' data-toggle='modal' data-target='#$fila[id]'><i class='fas fa-info-circle'></i></button> $fila[nombre]</td>
                                                <td>$fila[fecha]</td>";
                                        if ($fila['estado'] == 'Solventada') {

                                          echo "<td><button disabled type='button' class='btn btn-success' data-toggle='modal' data-target='#$fila[id]estado'>$fila[estado] <i class='fas fa-exclamation-circle'></i></i></button></td></tr>";

                                        } else {

                                          echo "<td><button type='button' class='btn btn-danger' data-toggle='modal' data-target='#$fila[id]estado'>$fila[estado] <i class='fas fa-exclamation-circle'></i></i></button></td></tr>";

                                        }

                                        //modal descripción
                                        echo "<div class='modal fade' id='$fila[id]' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                                <div class='modal-dialog' role='document'>
                                                  <div class='modal-content modal-custom'>
                                                    <div class='modal-header'>
                                                      <h5 class='modal-title' id='exampleModalLabel'><b>Descripción de la incidencia</b></h5>
                                                      <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                        <span aria-hidden='true'>&times;</span>
                                                      </button>
                                                    </div>
                                                    <div class='modal-body'>
                                                      <p>$fila[descripcion]</p>
                                                      <p><b>Gravedad: </b>$fila[gravedad]</p>
                                                    </div>
                                                    <div class='modal-footer'>
                                                      <button type='button' class='btn btn-danger' data-dismiss='modal'>Cerrar</button>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>";

                                        //modal cambiar estado
                                        echo "<div class='modal fade' id='$fila[id]estado' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                                <div class='modal-dialog' role='document'>
                                                  <div class='modal-content modal-custom'>
                                                    <div class='modal-header'>
                                                      <h5 class='modal-title' id='exampleModalLabel'><b>Cambiar estado de la incidencia</b></h5>
                                                      <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                        <span aria-hidden='true'>&times;</span>
                                                      </button>
                                                    </div>
                                                    <div class='modal-body'>
                                                      <form action='#' method='post'>
                                                        <div class='form-group'>
                                                          <p><b>Elige el nuevo estado de la incidencia $fila[nombre]</b></p>
                                                          <select name='cambiar_est'>
                                                            <option value='Solventada'>Solventada</option>
                                                            <option value='No solventada'>No solventada</option>
                                                          </select>
                                                        </div>
                                                    </div>
                                                    <div class='modal-footer'>
                                                    <input type='hidden' name='id_inc' value='$fila[id]'>
                                                    <input type='submit' name='mod' value='Cambiar estado' class='btn btn-success btn-new'>
                                                      <button type='button' class='btn btn-danger' data-dismiss='modal'>Cancelar</button>
                                                      </form>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>";

                                        // cambiar estado de la incidencia
                                        if (isset($_POST['mod'])) {
                                          $cambiar_est = $_POST['cambiar_est'];
                                          $id_inc = $_POST['id_inc'];
                                          $sql_cambiar = "UPDATE incidencia SET estado='$cambiar_est' WHERE id='$id_inc'";
                                          $cambiar = mysqli_query($conexion,$sql_cambiar);

                                          if ($cambiar) {
                                            echo "<META HTTP-EQUIV='REFRESH'CONTENT='0;URL=incidencias.php'>";
                                          } else {
                                            echo '<div class="alert alert-danger separador" role="alert">
                                                      <h4><b>Vaya!</b> Parece que no se ha podido cambiar el estado de la incidencia</b></h4>
                                                  </div>';
                                          }

                                        }

                                      }

                                    }

                                }

                              }

                            }

                            echo "</tbody></table></div>"; //cierra tabla

                          } else {

                            echo '<div class="col-md-4 offset-md-4"><div class="alert alert-info separador" role="alert">
                                      <h4><b>¡Vaya, que bien!</b> parece que no tienes más incidencias</b></h4>
                                    </div></div>';

                          }

                        }

                      } // query


                    } // listo todas las incidencias



                   ?>
          </div> <!-- row -->
          </div> <!-- row -->
                <div class="row">
                  <div class="col-md-2 offset-md-6"> <!-- col paginacion productos -->
                        <nav aria-label="Page navigation example">
                          <ul class="pagination">
                            <?php
                              echo "<li class='page-item'><a class='page-link' href='incidencias.php?pagina=".($pagina - 1)."'><i class='fas fa-angle-left'></i></a></li><li class='page-item'><a class='page-link' href='incidencias.php?pagina=".($pagina + 1)."'><i class='fas fa-angle-right'></i></a></li>";
                             ?>
                          </ul>
                        </nav>
                    </div> <!-- col paginacion productos -->
                </div>



        </div> <!-- container -->

      </div> <!-- container fluid sup -->
  </body>
</html>