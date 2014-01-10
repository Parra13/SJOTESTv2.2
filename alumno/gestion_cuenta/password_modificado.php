<?php
include ('../../include/sesion_alumno'); //incluimos la session alumno
include ('../../include/conexion.php'); // Incluimos la conexion a la BBDD

if(!empty($_POST['passwordAntiguo'])){
	$password=mysqli_real_escape_string($conexion, trim(strip_tags(md5($_POST['passwordAntiguo']))));//obtenemos el password antiguo
	$select="SELECT pass FROM usuario WHERE userid='".$userActivo."' AND pass='".$password."'";//preparamos un select
	$querySelect=mysqli_query($conexion, $select);//lanzamos la conexion
	
	if(!mysqli_num_rows($querySelect)){//comprobamos que haya coincidencia
		header('location: gestion_cuenta.php?mensaje=password_incorrecta');
		exit(1);
	}
	if($_POST['passwordNuevo'] != $_POST['passwordConfirmar']){//comprobamos que los 2 campos de password sean iguales
		header('location: gestion_cuenta.php?mensaje=password_no_coincide');
		exit(1);
	}
	
	$passwordNuevo=mysqli_real_escape_string($conexion, trim(strip_tags(md5($_POST['passwordNuevo']))));//obtenemos el nuevo password
	$update="UPDATE usuario SET pass='".$passwordNuevo."' WHERE userid='".$userActivo."'";//preparamos el update
	$queryUpdate=mysqli_query($conexion, $update);//realizamos el update
	if($queryUpdate){// si ha funcioando bien
		header('location: gestion_cuenta.php?mensaje=password_cambiado'); 
		exit(1);
	}
	else{ //si no ha funcionado bien
		header('location: gestion_cuenta.php?mensaje=password_no_cambiado');
		exit(1);
	}
	
}
else{//password vacio
	header('location: gestion_cuenta.php?mensaje=password_vacia');
}
include ('../../include/footer.php');
?>