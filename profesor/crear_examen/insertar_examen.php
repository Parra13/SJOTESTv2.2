<?php 

// Incluimos sesion de profesor.

include('../../include/sesion_profesor');
include ('../../include/conexion.php');

	if (!empty($_POST['tipo_examen'])) {
		
		$tipo_examen=mysqli_real_escape_string($conexion, trim(strip_tags($_POST['tipo_examen'])));

			$insert="INSERT INTO examen (tipo) values ('".$tipo_examen."')";

			$query=mysqli_query($conexion, $insert);

			if ($query) {
				
				header("Location: crear_examen.php?mensaje=correcto");

			}
			else{
				header("Location: crear_examen.php?mensaje=error_sql");
			}
	}
	else{
		header("Location: crear_examen.php?mensaje=error_input");
	}




?>