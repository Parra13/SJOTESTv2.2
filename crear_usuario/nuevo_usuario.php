<html>
<head>
	<title>Crear Nuevo Usuario</title>
	<link href="../menu.css" type="text/css" rel="stylesheet"/> 
</head>
<body>
<form action="insert_user.php" method="post" name="newusuario">
	<fieldset style="width:170px;">
		<legend><strong>Nuevo Alumno</strong></legend>
			<label>Nick Alumno:</label><input type="text" name="id"/>
			<label>Nombre:</label><input type="text" name="nombre"/>
			<label>Primer apellido:</label><input type="text" name="apellido1"/>
			<label>Segundo apellido:</label><input type="text" name="apellido2"/>
			<label>Contrase�a: </label><input type="password" maxlength='15' name="pass1"/>
			<label>Confirmar contrase�a:</label><input type="password" maxlength='15' name="pass2"/>
			<!-- C�digo Nuevo: Adri� Moy� -->
			<label>C�digo de seguridad:</label><input type="password" maxlength='25' name="codigoSeguro"/>
			<!-- Fin  -->
			<p><input type="submit" value="Registrar Alumno"/></p>
	</fieldset>
</form>
<a href="../index.php">Acceder a la Aplicaci&oacute;n</a>
<p>
<?php
$error_campo=$_GET['mensaje'];
	if ($error_campo=='usuario_existe'){
		// Mensaje que se mostrar� en caso de que el Nick introducido exista.
		echo "<div style='color: #D8000C;background-color: #FFBABA;border:solid 1px;width:200px;padding:10px;'>
		Ya existe ID alumno introducido</div>";
		exit(1);
	}
	if ($error_campo=='error_pass'){
		// Mensaje que se mostrar� en caso de que las contrase�as sean las mismas.
		echo "<div style='color:#D8000C;background-color:#FFBABA;border:solid 1px;width:220px;padding:10px;'>
		Ha introducido contrase�as distintas</div>";
		exit(1);
	}
	if ($error_campo=='error_input'){
		// Mensaje que se mostrar� en caso de no se introduzcan todos los datos indicados.
		echo "<div style='color:#D8000C;background-color:#FFBABA;border:solid 1px;width:220px;padding:10px;'>
		Debe rellenar todos los campos</div>";
		exit(1);
	}
	if ($error_campo=='correcto'){
	// Mensaje que se mostrar� en caso de que se inserte el usuario correctamente. 
		echo "<div style='color:#4F8A10;background-color:#DFF2BF;border:solid 1px;width:270px;padding:10px;'>
		Usuario creado correctamente</div>";
		exit(1);
	}
	if ($error_campo=='error_sql'){
	// Mensaje que se mostrar� en caso de que se produzca un error en el proceso SQL. 
		echo "<div style='color: #D8000C;background-color: #FFBABA;border:solid 1px;width:350px;padding:10px;'>
		Se ha producido un fallo en el registro de la pregunta.<br/>
		Por favor contacte con el administrador de la aplicaci&oacute;n.<br/></div>";
		exit(1);		
	}
	//c�digo nuevo: Adri� Moy�
	if ($error_campo=='no_hay_codigo_secreto'){
	// Mensaje que se mostrar� en caso de que se no se introduzca el c�digo de seguridad. 
		echo "<div style='color: #D8000C;background-color: #FFBABA;border:solid 1px;width:350px;padding:10px;'>
		No has introducido el codido secreto.<br/></div>";
		exit(1);		
	}
	
	if ($error_campo=='codigo_secreto_erroneo'){
	// Mensaje que se mostrar� en caso de que el c�digo de seguridad no sea correcto. 
		echo "<div style='color: #D8000C;background-color: #FFBABA;border:solid 1px;width:350px;padding:10px;'>
		El codigo de seguridad no es correcto.<br/>
		Por favor contacte con el administrador para obtenerlo.<br/></div>";
		exit(1);		
	}
	//fin c�digo nuevo
?>
</p>
</body>
</html>