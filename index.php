<?php

session_start(); //Habilitamos sesion

$_SESSION = array(); //Vaciamos la sesion

session_destroy(); //Destrimos la sesion

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">

	<head>

		<title>SJOTEST - Acceso</title>

		<link href="menu.css" type="text/css" rel="stylesheet"/>

	</head>

	<body>

	<div id="centrado_login">

	<p align="center"><img src="images/logo2.JPG" width="76" height="76" alt=""/></p> 
		<form action="loginPHP.php" method="post" name="log">

			<fieldset>
			<legend>SJOTEST</legend>
			<table>
				<tr><td><label>Usuario:</label></td><td><input type="text" name="user"/></td></tr>
				<tr><td><label>Contrase&ntilde;a:</label></td><td><input type="password" maxlength="15" name="pass"/></td></tr>
				<tr><td><input type="submit" value="Log in"/></td></tr>
				<tr><td><a href="crear_usuario/nuevo_usuario.php">Reg&iacute;strarse</a></td></tr>
			</table>
			</fieldset>
		</form>
<p>

<?php

// Mensaje que se mostrara en caso de que se dejen campos vacios 

	$error_campo=$_GET['mensaje'];

		if ($error_campo==2){	

			echo "<div style='color: #D8000C;background-color: #FFBABA;border:solid 1px;width:320px;padding:10px;'>

			El usuario o contrase&ntilde;a no son correctos</div>";

			exit(1);

		}

		if ($error_campo==1){	

			echo "<div style='color:#D8000C;background-color:#FFBABA;border:solid 1px;width:320px;padding:10px;'>

			Para iniciar sesi&oacute;n no puedes dejar campos vacios</div>";

			exit(2);

		}

		if ($error_campo==3){

			echo "<div style='color:#D8000C;background-color:#FFBABA;border:solid 1px;width:320px;padding:10px;'>

			Has intentado acceder a una pagina sin estar autenticado, por favor, autenticate.</div>";

			exit(3);

		}

?>

</p>

</div>

</body>

</html>