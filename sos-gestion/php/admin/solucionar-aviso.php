<?php
include '../funciones.php';
session_start();
comprobarAdmin();

$mensaje_ok = true;

if (isset($_GET['solucionar'])) { //isset aviso

	$id_aviso = $_GET['id_aviso'];
	$id_botiquin = $_GET['id_botiquin'];
	$id_producto = $_GET['id_producto'];

	$conexion = abrirConexion();
	$sql_solucionar_aviso = "UPDATE aviso SET estado='solucionado' WHERE id='$id_aviso'";

	$solucionar_aviso = mysqli_query($conexion,$sql_solucionar_aviso);

	// se intenta solucionar el aviso
	if ($solucionar_aviso) {

		$sql_poner_stock = "UPDATE almacena SET stock='1' WHERE id_botiquin='$id_botiquin' AND id_producto='$id_producto'";

		$poner_stock = mysqli_query($conexion,$sql_poner_stock);

		// se pone en stock de nuevo el producto
		if ($poner_stock) {

			mysqli_close($conexion);
    		header ("location:ver-avisos.php?mensaje=$mensaje_ok");

		} else {

			$mensaje_ok = false;
    		mysqli_close($conexion);
    		header ("location:ver-avisos.php?mensaje=$mensaje_ok");

		}

	}

}  //isset aviso

?>