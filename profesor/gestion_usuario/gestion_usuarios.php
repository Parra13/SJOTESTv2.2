<?php
include ('../../include/sesion_profesor'); //incluimos la sesion del profesor
include ('../../include/menu.php'); // incluimos el head 
include ('../../include/conexion.php');// Incluimos la conexion a la BBDD
?>
<!-- Parte nueva: Adri� Moy�-->
<form action="cambiar_pregunta_secreta.php" method="post">
	Contrase�a segura: 
	<?php
		include ('pregunta_segura');
	?>
	<br />
	<input type="submit" value="Cambia"/>
</form>
<!-- Fin parte nueva-->
<br />
Elige usuario:<br />
<form action="gestion_usuarios.php" method="post">
<select name="users" > 
	<option value="noseleccionado" selected> Elige un usuario... </option>
	<?php
	//incluimos la opciones del select
	include ('form_seleccion_usuarios');
	?>
</select>
<input type="submit" name="cambiarPreguntaSegura" value="Muestra">
</form>
<?php
	//incluimos el formulario del usuario seleccionado
	include ('form_usuario_seleccionado');
	//incluimos los mensajes de aviso
	include ('mensajes');
	// Cerramos conexi�n a la BBDD
	mysql_close($conexion); 
	include  ('../../include/footer.php');
?>
