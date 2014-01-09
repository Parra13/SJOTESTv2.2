<?php
// Incluimos sesion de profesor.
include('../../include/sesion_profesor');
// Incluimos menu.
include("../../include/menu.php");
?>
<p>
<form action="insert_pregunta.php" method="post" name="newpregunta">
	<fieldset style="width:290px;">
		<legend><strong>Nueva Pregunta</strong></legend>
			<label>Pregunta:</label><input type="text" size="40" name="pregunta"/>
			<label>Respuesta 1:</label><input type="text" size="40" name="r1"/>
			<label>Respuesta 2:</label><input type="text" size="40" name="r2"/>
			<label>Respuesta 3:</label><input type="text" size="40" name="r3"/>
			<label>Respuesta 4:</label><input type="text" size="40" name="r4"/>
			<label>Respuesta Correcta: </label><input type="text" size="2" name="rc"/>
			<p><input type="submit" value="Registrar Pregunta"/></p>
	</fieldset>
</form>
</p>
<p>
<?php
$error_campo=$_GET['mensaje'];
	if ($error_campo=='error_input'){
		// Mensaje que se mostrará en caso de que se dejen campos vacios. 
		echo "<div style='color: #D8000C;background-color: #FFBABA;border:solid 1px;width:270px;padding:10px;'>
		No se pueden dejar campos sin rellenar</div>";
		//exit(1);
	}
	if ($error_campo=='correcto'){
	// Mensaje que se mostrará en caso de que se inserte la pregunta. 
		echo "<div style='color:#4F8A10;background-color:#DFF2BF;border:solid 1px;width:270px;padding:10px;'>
		Se ha guardado correctamente la pregunta</div>";
		//exit(1);
	}
	if ($error_campo=='error_sql'){
	// Mensaje que se mostrará en caso de que se produzca un error en el proceso SQL. 
		echo "<div style='color: #D8000C;background-color: #FFBABA;border:solid 1px;width:350px;padding:10px;'>
		Se ha producido un fallo en el registro de la pregunta.<br/>
		Por favor contacte con el administrador de la aplicaci&oacute;n.<br/></div>";
		//exit(1);		
	}
?>
</p>
<?php include  ('../../include/footer.php'); ?>
