<?php
  include 'php/funciones.php';
  session_start();
  usuarioLogueado();
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
    <link rel="stylesheet" type="text/css" href="css/custom-general.css">
    <!-- Optional JavaScript -->
    <!-- Font Awesome -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

    <title>SOS Gestión - Socorrismo profesional</title>
  </head>
  <body>
    <div class="container-fluid bg-fondo seccion"> <!-- container fluid sup -->

      <nav class="navbar navbar-expand-lg fixed-top bg-nav">
        <a class="navbar-brand" href="index.php"><img  src="img/logo.png" alt="SOS Gestión" width="100" height="50"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav alinea-menu">
            <li class="nav-item">
               <a class="nav-link tipo-enl" href="#sec1">Nosotros</a>
            </li>
            <li class="nav-item">
              <a class="nav-link tipo-enl" href="#sec2">Servicios</a>
            </li>
            <li class="nav-item">
              <a class="nav-link tipo-enl" href="#sec3">Trabaja con nosotros</a>
            </li>
          </ul>
          <form class="form-inline alinea-acceder">
            <button class="btn btn-login" type="button">
              <a href="php/login.php" title="Acceder">Acceder a la aplicación</a>
            </button>
          </form>
        </div>
      </nav>
    </div> <!-- container fluid sup -->
    <div class="container-fluid contenido1" id="sec1"> <!-- contenido1 -->
      <div class="container pagina-principal"> <!-- container -->
        <div class="row">
            <div class="col-md-7">
              <div class="seccion-titulo" ><!-- seccion titulo -->
              <h1 align="center" class="tipo-fo" id="titulo">SOS Gestion</h1>
              <h2 align="center" class="tipo-fo" id="subtitulo">Servicio de socorrismo profesional</h2>
              <p>Nuestra empresa nace de la ilusión por trabajar en lo que nos gusta y poder prestar un servicio espezializado en socorrismo acuático, preventivo y asistencial.</p>
              <h3>Tenemos más de 7 años de experiencia</h3>
              <p>Por eso sabemos lo que hacemos, también porque hemos trabajado en espacios naturales e instalaciones acuáticas privadas y públicas de todo tipo.</p>
            </div><!-- seccion titulo -->
            </div>
            <div class="col-md-4">
              <img class="img-fluid" src="img/iconos/Recurso8.png" alt="">
            </div>
        </div>
      </div> <!-- container -->
    </div> <!-- cotenido1 -->
    <div class="container-fluid contenido1"> <!-- contenido2 -->
      <div class="container pagina-principal"> <!-- container -->
        <div class="row">
          <div class="col-md-4">
            <img class="img-fluid" src="img/iconos/Recurso7.png" alt="">
          </div>
          <div class="col-md-7">
            <div class="seccion-titulo"><!-- seccion titulo -->
              <h1 align="center" class="tipo-fo" id="titulo">Nuestro compromiso</h1>
              <h2 align="center" class="tipo-fo" id="subtitulo">Tu seguridad</h2>
              <p>Nuestro servicio es de vital importancia para la salud y seguridad usuarios. Por ello, la seguridad es más que un requisito, es una actitud vinculada a nuestro compromiso con la excelencia en todo lo que hacemos. La seguridad de nuestros productos y servicios, desde la planificación a la implantación, tienen una importancia fundamental en nuestra organización.</p>
              <p>El salvamento y socorrismo están en constante contacto con el usuario. Nuestros socorristas realizan tareas de vigilancia, prevención y rescate, por lo que deben estar preparados en todo momento para dar una atención de calidad a los usuarios.</p>
            </div><!-- seccion titulo -->
          </div>
        </div>
      </div> <!-- container -->
    </div> <!-- fluid cotenido2 -->

    <div class="container-fluid contenido2" id="sec2" > <!-- contenido4 -->
      <div class="container pagina-principal recurso2"> <!-- container -->
        <div class="row">
          <div class="col-md-7">
            <div class="seccion-titulo" "><!-- seccion titulo -->
              <h1 align="center" class="tipo-fo" id="titulo">Servicios</h1>
              <h2 align="center" class="tipo-fo" id="subtitulo">Tenemos un alto grado de especializacion en diferentes servicios, pero principalmente lo nuestro es</h2>
              <h3 align="center">Socorrismo y salvamento</h3>
              <h3 align="center">Servicios sanitarios</h3>
              <h3 align="center">Actividades infatiles en espacios acuáticos</h3>
            </div><!-- seccion titulo -->
          </div>
          <div class="col-md-4">
             <img class="img-fluid" src="img/iconos/Recurso4.png" alt="">
          </div>
        </div>

      </div> <!-- container -->

    <div class="container-fluid contenido2"> <!-- contenido3 -->
      <div class="container pagina-principal"> <!-- container -->
        <div class="row">
          <div class="col-md-4">
            <img class="img-fluid" src="img/iconos/Recurso1.png" alt="">
          </div>
          <div class="col-md-7">
            <div class="seccion-titulo"><!-- seccion titulo -->
              <h1 align="center" class="tipo-fo" id="titulo">Siempre al dia</h1>
              <h2 align="center" class="tipo-fo" id="subtitulo">Gracias a nuestra app</h2>
              <p align="center">Nos gusta ser profesionales tanto con el cliente como con nuestros trabajadores y además nos gusta tener un alto grado de comunicación y conocimiento entre todos nosotros para así poder ofrecer el mejor servicio. Por ello tenemos nuestra propia aplicación para gestionar todo lo que nuestra empresa ofrece.</p>
              <h3>Algunas tareas que puedes realizar son</h3>
                <div align="center">
                  <p>Control de tus trabajadores</p>
                  <p>Puestos de trabajo</p>
                  <p>Visualización de incidencias diarias</p>
                  <p>Gestión del botiquín</p>
                </div>
        </div><!-- seccion titulo -->
      </div>
          </div>
        </div>

      </div> <!-- container -->
    </div> <!-- cotenido3 -->


    <div class="container-fluid contenido5" id="sec3"> <!-- contenido5 -->
      <div class="container pagina-principal"> <!-- container -->

      <div class="seccion-titulo"><!-- seccion titulo -->
        <h1 align="center" class="tipo-fo" id="titulo">Trabaja con nosotros</h1>
        <h2 align="center" class="tipo-fo" id="subtitulo">Siempre estamos buscando nuevas incorporaciones</h2>
        <p align="center"></p>
        <h3>Rellena el siguiente formulario y te tendremos en cuenta para futuras contrataciones</h3>
        <div class="col-6 offset-3">
          <form action="#" method="post" accept-charset="utf-8">
          <div class="form-group">
            <label>Nombre completo</label>
            <input type="text" class="form-control">
          </div>
            <div class="form-group">
              <label>Puesto de trabajo al que accederias</label>
            </div>
          <div class="form-group">
           <select class="form-control" name="puesto">
             <option value="socorrista">Socorrista</option>
             <option value="Monitor">Monitor</option>
             <option value="Enfermero">Enfermero</option>
           </select>
          </div>
          <div class="form-group">
            <label>Teléfono</label>
            <input type="text" class="form-control">
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control">
            <small id="emailHelp" class="form-text text-muted">Nunca compartiremos tu email con nadie</small>
          </div>
          <button type="submit" class="btn btn-success">Enviar petición de trabajo</button>
        </form>
        </div>
      </div><!-- seccion titulo -->


      </div>

      </div> <!-- container -->
    </div> <!-- cotenido5 -->
  </div>
    <div class="container-fluid footer"><!-- footer -->
      <div class="row">
        <div class="col">
          <h3 align="center" class="separa-titulo">Contacto</h3>
          <p>Estamos ubicados en Jaén, en Avenida de Andalucía Nº33, 1º A CP 23006</p>
          <p>Teléfono: <a href="tel:953224455" >953 22 44 55</a></p>
          <p>Email: <a href="mailto:contacto@sosgestion.com">contacto@sosgestion.com</a></p>
        </div>
        <div class="col">
          <h3 align="center" class="separa-titulo">Redes sociales</h3>
          <p align="center">
            <a href="#" title="Linkedin"><i class="fab fa-linkedin-in social"></i></a>
            <a href="#" title="Linkedin"><i class="fab fa-facebook-f social"></i></a>
            <a href="#" title="Linkedin"><i class="fab fa-twitter social"></i></a>
          </p>
        </div>
      </div>
    </div><!-- footer -->
    <div class="container-fluid sub-footer"><!--sub-footer -->
        <p align="center"><b>©2018 SOS Gestión - Socorrismo profesional | <a href="#" title="">Aviso legal y Política de privacidad</a></b></p>
    </div><!-- sub-footer -->
  </body>
</html>