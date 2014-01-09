<?php
//Datos de acceso a la BBDD

$host="localhost"; 				//Host 
$usuario="606428_admin";		//usuario de acceso
$pass="LL1512ss"; 				//contraseña del usuario

//Realizamos la conexión a la BBDD
$conexion=mysql_connect($host,$usuario,$pass);
//Seleccionamos la BBDD
$db=mysql_select_db("iaw-ramses_zxq_mallorca",$conexion);
?>