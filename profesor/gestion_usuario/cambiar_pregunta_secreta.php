<?php
include ('../../include/sesion_profesor'); //Incluimos la sesion
include ('../../include/conexion.php'); // Incluimos la conexion a la BBDD

if(isset($_POST['preguntaSegura'])){
	$preguntaSecreta=$_POST['preguntaSegura'];
	$consulta="UPDATE configuracion SET configuracion='".$preguntaSecreta."' WHERE nombre='preguntaSegura'";//creamos consulta
	$querySegura=mysql_query($consulta,$conexion); //lanzamos la consulta	
	if ($querySegura){
		header('Location: gestion_usuarios.php?mensaje=segura_ok');
	}
	else{
		header('Location: gestion_usuarios.php?mensaje=segura_fail');
	}
}
?>