<?php

	/*
	* ÍNDICE DE FUNCIONES
	*	1. ABRIR CONEXIÓN
	*	2. COMPROBAR SI ES ADMINISTRADOR
	*	3. COMPROBAR SI ES TRABAJADOR
	*	4. COMPROBAR SI ES CLIENTE
  * 5. NAVBAR SUPERIOR
  * 6. COMPROBAR EL TIPO DE USUARIO EN INDEX Y REDIRIGIRLO
	*/


	/*
	* 1. Función para abrir conexión con la base de datos
	*/

	function abrirConexion() {

		$conexion = mysqli_connect('localhost', 'root', 'root','sos_gestion');
		mysqli_set_charset($conexion, 'utf8');

		if (!$conexion) {
			echo "<b>¡ERROR! Conexión a la BD fallida</b>";
		}

		return $conexion;

	}

	/*
	* 2. Función para comprobar si el que accede es un usuario administrador,
	* mediante sesión o recuerdo de cookie, si el id no es igual a 1
	* lo expulsa a la página de inicio
	*/

	function comprobarAdmin() {

    if (isset($_SESSION['id'])) {

      if ($_SESSION['id'] != '1') {
        header ("location:../../index.php");
      } elseif ($_SESSION['id']>1) {
      header ("location:../../index.php");
      }
      } elseif (isset($_COOKIE['datos'])) {
        session_decode($_COOKIE['datos']);
        if ($_SESSION['id'] != '1') {
          header ("location:../../index.php");
        }
      } else {
  		header ("location:../../index.php");
  	  }

  }

  /*
	* 3. Función para comprobar si el que accede es un usuario trabajador,
	* mediante sesión o recuerdo de cookie, si el tipo de usuario no es
	* 'trabajador' lo expulsa a la página de inicio
	*/

	function comprobarTrabajador() {

    if (isset($_SESSION['tipo_usuario'])) {

      if ($_SESSION['tipo_usuario'] != 'trabajador') {
        header ("location:../../index.php");
      }

    } elseif (isset($_COOKIE['datos'])) {

        session_decode($_COOKIE['datos']);
        if ($_SESSION['tipo_usuario'] != 'trabajador') {
          header ("location:../../index.php");
        }

    } else {
      header ("location:../../index.php");
    }

  }

  /*
	* 4. Función para comprobar si el que accede es un usuario trabajador,
	* mediante sesión o recuerdo de cookie, si el tipo de usuario no es
	* 'trabajador' lo expulsa a la página de inicio
	*/

	function comprobarCliente() {

    if (isset($_SESSION['tipo_usuario'])) {

      if ($_SESSION['tipo_usuario'] != 'cliente') {
        header ("location:../../index.php");
      }

    } elseif (isset($_COOKIE['datos'])) {

        session_decode($_COOKIE['datos']);
        if ($_SESSION['tipo_usuario'] != 'cliente') {
          header ("location:../../index.php");
        }

    } else {
      header ("location:../../index.php");
    }

  }


  /*
  * 5. Función para insertar el menú de navegación en las distintas páginas de la aplicación
  */

  function navSuperior() {
    echo "<nav class='navbar fixed-top bg-nav'>
            <a class='navbar-brand' href='#'><img class='img-fluid' src='../../img/logo.png' alt='SOS Gestión' width='100' height='50'></a>
            <form class='form-inline'>
              <button align='center' class='btn btn-cerrar' type='button'><a href='../cerrar-sesion.php' title='Cerrar sesión'>Cerrar sesión</a></button>
            </form>
          </nav> ";
  }

  /*
  * 6. Función para comprobar si existe algún usuario logeado y redirgirlo desde index
  * a su página principal
  */

  function usuarioLogueado() {

    if (isset($_SESSION['tipo_usuario'])) {

      if ($_SESSION['tipo_usuario'] == 'admin') {
        header ("location:php/admin/admin-panel.php");
      } else if ($_SESSION['tipo_usuario'] == 'trabajador') {
        header ("location:php/trabajador/trabajador.php");
      } else if ($_SESSION['tipo_usuario'] == 'cliente') {
        header ("location:php/cliente/cliente.php");
      } else {

      }

    } elseif (isset($_COOKIE['datos'])) {

        session_decode($_COOKIE['datos']);

        if ($_SESSION['tipo_usuario'] == 'admin') {
          header ("location:php/admin/admin-panel.php");
        } else if ($_SESSION['tipo_usuario'] == 'trabajador') {
          header ("location:php/trabajador/trabajador.php");
        } else if ($_SESSION['tipo_usuario'] == 'cliente') {
          header ("location:php/cliente/cliente.php");
        } else {

      }

    } else {

    }

  }

 ?>