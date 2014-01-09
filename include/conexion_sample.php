<?php
//Datos de acceso a la BBDD

$host="INTRODUCIR SERVIDOR"; 						//Host 
$usuario="INTRODUCIR USUARIO BASE DE DATOS";		//usuario de acceso
$pass="INTRODUCIR CONTRASEÑA"; 						//contraseña del usuario

//Realizamos la conexión a la BBDD
$conexion=mysql_connect($host,$usuario,$pass);
//Seleccionamos la BBDD
$db=mysql_select_db("INTRODUCIR NOMBRE DE BASE DE DATOS",$conexion);
?>
