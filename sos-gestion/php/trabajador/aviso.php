<?php
include '../funciones.php';
session_start();
comprobarTrabajador();

$mensaje_ok = true;

if (isset($_GET['stock_producto'])) { //isset stock

    $id_botiquin = $_GET['id_botiquin'];
    $id_producto = $_GET['id_producto'];

    $fecha_actual = date("y-m-d");

    $conexion = abrirConexion();
    $sql_aviso = "INSERT INTO aviso VALUES (null,'sin stock','$fecha_actual','$id_botiquin','$id_producto')";

    $aviso = mysqli_query($conexion,$sql_aviso);

    // se intenta dar el aviso
    if ($aviso) {

    	$sql_stock = "UPDATE almacena SET stock='0' WHERE id_botiquin='$id_botiquin' AND id_producto='$id_producto'";

    	$cambiar_stock = mysqli_query($conexion,$sql_stock);

    	// si se da el aviso se cambia el stock del producto
    	if ($cambiar_stock) {

    		mysqli_close($conexion);
    		header ("location:mi-botiquin.php?mensaje=$mensaje_ok");

    	} else {

            $mensaje_ok = false;
    		mysqli_close($conexion);
    		header ("location:mi-botiquin.php?mensaje=$mensaje_ok");

    	}

    } else {

    	mysqli_close($conexion);
    	header ("location:mi-botiquin.php?mensaje=$mensaje");

    }

} // isset stock

?>