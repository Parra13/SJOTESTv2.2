<?php 

include ('../../include/conexion.php');

// Incluimos sesion de profesor.

include('../../include/sesion_profesor');

// Incluimos menu.

include("../../include/menu.php");


echo '
<p>

<form action="insertar_examen.php" method="post" name="newexam">

	<fieldset style="width:290px;">

		<legend><strong>Examen nuevo</strong></legend>

			<label>Tipo de examen:</label><input type="text" size="40" name="tipo_examen"/>

			<p><input type="submit" value="Registrar Examen"/></p>

	</fieldset>

</form>

</p>';


$error_campo=$_GET['mensaje'];

	if ($error_campo=='error_input'){

		// Mensaje que se mostrará en caso de que se dejen campos vacios. 

		echo "<div style='color: #D8000C;background-color: #FFBABA;border:solid 1px;width:270px;padding:10px;'>

		Debes especificar el nombre del examen.</div>";

		//exit(1);

	}

	if ($error_campo=='correcto'){

	// Mensaje que se mostrará en caso de que se inserte la pregunta. 

		echo "<div style='color:#4F8A10;background-color:#DFF2BF;border:solid 1px;width:270px;padding:10px;'>

		Se ha guardado correctamente el examen</div>";

		//exit(1);

	}

	if ($error_campo=='error_sql'){

	// Mensaje que se mostrará en caso de que se produzca un error en el proceso SQL. 

		echo "<div style='color: #D8000C;background-color: #FFBABA;border:solid 1px;width:350px;padding:10px;'>

		Se ha producido un fallo en el registro del examen.<br/>

		Por favor contacte con el administrador de la aplicaci&oacute;n.<br/></div>";

		//exit(1);		

	}

include  ('../../include/footer.php'); ?>
?>