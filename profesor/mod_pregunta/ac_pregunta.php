<?php
// Incluimos la sesion de profesor.
include ("../../include/sesion_profesor");
// Incluimos conexion a la BBDD.
include ('../../include/conexion.php');
	if (isset($_POST['act'])){
		// mysql_real_escape_string: evita inyecciones de SQL.
		// trim: elimina espacios en blanco del inicio y final.
		// strip_tags: elimina elementos introducidos de HTML y PHP.
		$preg_id=mysql_real_escape_string(trim(strip_tags($_POST['pregid'])));
		$pregunta=mysql_real_escape_string(trim(strip_tags($_POST['pregunta'])));
		$r1=mysql_real_escape_string(trim(strip_tags($_POST['r1'])));
		$r2=mysql_real_escape_string(trim(strip_tags($_POST['r2'])));
		$r3=mysql_real_escape_string(trim(strip_tags($_POST['r3'])));
		$r4=mysql_real_escape_string(trim(strip_tags($_POST['r4'])));
		$rc=mysql_real_escape_string(trim(strip_tags($_POST['rc'])));
		// Consulta que Contiene el UPDATE con los datos.
			$update="UPDATE preguntas SET pregunta='".$pregunta."',r1='".$r1."',r2='".$r2."',r3='".$r3."',r4='".$r4."',rc='".$rc."' WHERE pregid='".$preg_id."'";
			$q_update=mysql_query($update,$conexion);
			// Comprobamos que se ha ejecutado correctamente
			// mostrando un mensaje en mod_preg, indicando 
			// si se ha actualizado o bien se ha producido 
			// un error.
				if ($q_update){
					//
					header('Location: mod_preg.php?mensaje=update');
				}
				else{
				
					header('Location: mod_preg.php?mensaje=error_sql');
				}
	}
	else if (isset($_POST['borrar'])){
		// mysql_real_escape_string: evita inyecciones de SQL.
		// trim: elimina espacios en blanco del inicio y final.
		// strip_tags: elimina elementos introducidos de HTML y PHP.
		$pregid=mysql_real_escape_string(trim(strip_tags($_POST['pregid'])));
		// Orden SQL que contiene que borra el registro escogido.
			$delete="DELETE FROM preguntas WHERE pregid=".$pregid;
			// Lanzamos consulta.
			$query=mysql_query($delete,$conexion);
			// Comprobamos que se ha ejecutado correctamente
			// mostrando un mensaje en mod_preg, indicando 
			// si se ha eliminado o bien se ha producido 
			// un error.
				if ($query){
					header('Location: mod_preg.php?mensaje=delete');
				}
				else {
				
					header('Location: mod_preg.php?mensaje=error_sql');
				}
	}
// Cerramos conexion a la BBDD.
mysql_close($conexion);
?>