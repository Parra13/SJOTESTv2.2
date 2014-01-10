<?php
include ('../../include/sesion_alumno'); 	//incluimos la session alumno
include ('../../include/menu.php'); 		//incluimos el head 
include ('../../include/conexion.php');		//Incluimos la conexion a la BBDD

$select="SELECT * FROM usuario WHERE userid='".$userActivo."'"; //creamos la consulta para obtener datos del usuario
$query=mysqli_query($conexion, $select);							//lanzamos la consulta
if(!mysqli_num_rows($query)){									//Comprobamos que el query ha devuelto lineas
		echo "<div style='color:#D8000C;background-color:#FFBABA;border:solid 1px;width:220px;padding:10px;'>
		No se ha podido acceder a tu usuario</div>";
		exit(1);
	}
$usuario=mysqli_fetch_array($query);								//introducimos los vamores de la consulta en una variable
include ('formulario_cambiar_password');
include ('mensajes');
include ('../../include/footer.php');

?>
			