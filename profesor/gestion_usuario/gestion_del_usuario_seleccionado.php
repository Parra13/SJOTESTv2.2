<?php
include ('../../include/sesion_profesor');
// Incluimos la conexion a la BBDD
include ('../../include/conexion.php');

if(isset($_POST['borrar'])){ //ejecuta la opción de borrado	
	$userid=$_POST['userid']; //capturamos el id de usuario
	$consultaBorrado="DELETE FROM usuario WHERE userid='".$userid."'"; //creamos la consulta
	$queryBorrado=mysql_query($consultaBorrado,$conexion); //lanzamos la consulta	
	if ($queryBorrado){
		header('Location: gestion_usuarios.php?mensaje=borrado_ok');
	}
	else{
		header('Location: gestion_usuarios.php?mensaje=borrado_fail');
	}
 }
 if (isset($_POST['modificar'])){ // ejecuta la opción de modificación
	$userid=$_POST['userid']; //capturamos el id de usuario	
	$nickModificado=mysql_real_escape_string(trim(strip_tags($_POST['nick'])));//capturamos el nuevo nick
	$nombreModificado=mysql_real_escape_string(trim(strip_tags($_POST['nombre'])));//capturamos el nuevo nombre
	$apellido1Modificado=mysql_real_escape_string(trim(strip_tags($_POST['apellido1'])));//capturamos el nuevo apellido 1
	$apellido2Modificado=mysql_real_escape_string(trim(strip_tags($_POST['apellido2'])));//capturamos el nuevo apellido 2
	$select="SELECT nick FROM usuario WHERE nombre='".$nickModificado."'";//Guardamos la consulta en una variable
	$querySelect=mysql_query($select,$conexion);
	if(mysql_num_rows($querySelect)){//Comprobamos que el query ha devuelto lineas
		header('Location: gestion_usuarios.php?mensaje=nick_existe');
		exit(1);
	}
			
	$consultaModifica="UPDATE usuario SET nombre='".$nombreModificado."', nick='".$nickModificado."', apellido1='".$apellido1Modificado."', apellido2='".$apellido2Modificado."' WHERE userid='".$userid."'"; //creamos la consulta
	$queryModificar=mysql_query($consultaModifica,$conexion); //lanzamos la consulta		
		if ($queryModificar){
			header('Location: gestion_usuarios.php?mensaje=modificado_ok');
		}
		else{
			header('Location: gestion_usuarios.php?mensaje=modificado_fail');
		}	
 }
 // Cerramos conexión a la BBDD
mysql_close($conexion);
 ?>
 
 