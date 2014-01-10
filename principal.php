<?php

	session_start();

	$logType=$_SESSION['admin']; //Capturamos la session actual	


	if($logType=="1"){

	include("include/menu.php");

		
		echo "Crear Preguntas: Introducir nuevas preguntas en la aplicaci&oacute;n<br>

			Modificar Preguntas: Modificar preguntas en la aplicaci&oacute;n<br>

			Ver Resultados: Comprobar resultados de los alumnos<br>

			Gestionar Usuarios: Modificar datos de los alumnos<br>

			Cerrar sesi&oacute;n: Salir de la aplicaci&oacute;n";

	}

	else if($logType=="0"){

	include("include/menu.php");

		echo <<<start

		<table>

			<tr><td style='background:#880015;padding:10px;color:white;'>Tarea</td><td style='background:#880015;padding:10px;color:white;'>Acci&oacute;n<td></tr>

			<tr><td>Responder Preguntas:</td><td>Comienza a responder las preguntas<td></tr>

			<tr><td>Modificar Perfil:</td><td>Modifica tus datos personales<td></tr>

			<tr><td>Ver Tus Resultados:</td><td>Consulta tu cualificaci&oacute;n<td></tr>

			<tr><td>Cerrar sesi&oacute;n:</td><td>Salir de la aplicaci&oacute;n<td></tr>

		</table>

start;

	}

	else{

		header("Location: $urlRoot/index.php");

	}

?>

<?php

$error_campo=$_GET['mensaje']; // Capturamos el tipo de error

	if ($error_campo==1){	

		echo "<p><div style='color: #D8000C;background-color: #FFBABA;border:solid 1px;width:270px;padding:10px;'>

		No tienes permiso para acceder a esta p&aacute;gina</div></p>";

		exit(1);

	}

	include ('include/footer.php');

?>



