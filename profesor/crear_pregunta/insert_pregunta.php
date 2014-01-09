<?php
// Incluimos la sesion del profesor.
include('../../include/sesion_profesor');
// Incluimos la conexion a la BBDD.
include ('../../include/conexion.php');
// Comprobamos que se han introducido datos en todos los campos.
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	if (!empty($_POST['pregunta']) && !empty($_POST['r1']) && !empty($_POST['r2']) && !empty($_POST['r3']) && !empty($_POST['r4']) && !empty($_POST['rc'])){
	// mysql_real_escape_string: evita inyecciones de SQL.
	// trim: elimina espacios en blanco del inicio y final.
	// strip_tags: elimina elementos introducidos de HTML y PHP.
		$pregunta=mysql_real_escape_string(trim(strip_tags($_POST['pregunta'])));	
		$r1=mysql_real_escape_string(trim(strip_tags($_POST['r1'])));
		$r2=mysql_real_escape_string(trim(strip_tags($_POST['r2'])));
		$r3=mysql_real_escape_string(trim(strip_tags($_POST['r3'])));
		$r4=mysql_real_escape_string(trim(strip_tags($_POST['r4'])));
		$rc=mysql_real_escape_string(trim(strip_tags($_POST['rc'])));
	//
	// Orden SQL para insertar los datos.
	$insert="INSERT INTO preguntas(pregunta,r1,r2,r3,r4,rc) 
	VALUES ('".$pregunta."','".$r1."','".$r2."','".$r3."','".$r4."','".$rc."')";
	// Ejecucion de las ordenes
	$query=mysql_query($insert,$conexion);
	// Comprobamos que el INSERT se ha realizado correctamente.
		if ($query){
			// Si se ha realizado correctamente:
			// $select: SELECT con todos los usuarios.
			// $select_preg: recogemos el pregid creado anteriormente desde el INSERT de la nueva pregunta.
			// Filtramos por la pregunta en concreto ya que el pregid es autonumerico y solo se inserta cuando
			// se crea un registro nuevo.
				$select="SELECT * FROM usuario WHERE administrador='0'";
				$select_preg="SELECT pregid FROM preguntas WHERE pregunta='".$pregunta."'";
				// Ejecutamos las ordenes.
					$query_preg_user=mysql_query($select,$conexion);
					$query_preg_user2=mysql_query($select_preg,$conexion);
				// con la función mysql_fetch_array() recorremos la fila que tiene que devolver
				// para obtener el ID de la pregunta creada y la guardamos en una variable para 
				// utilizarla posteriormente.
					$preg_user_preg=mysql_fetch_array($query_preg_user2);
					$question=$preg_user_preg['pregid'];
				// Ahora utilizamos un WHILE con la funcion mysql_fetch_array() para 
				// recorrer todas las filas de la tabla usuario.
					while ($preg_user=mysql_fetch_array($query_preg_user)){
					// Finalmente por cada usuario, se realiza un INSERT en preg_user con el ID del alumno,
					// el ID de pregunta (guardado anteriormente y que sera siempre el mismo) y en 'correcta' 
					// dejamos por defecto el valor '2' indicando que la pregunta no ha sido contestada.
						$user=$preg_user['userid'];
						$insert="INSERT INTO preg_user (userid,pregid,correcta) VALUES ('".$user."','".$question."','2')";
						$q_insert=mysql_query($insert,$conexion);
					 }
					// Finalmente una vez insertados los nuevos datos en preg_user y finalizado el 
					// WHILE regresa a nueva_pregunta.php para seguir introduciendo preguntas.
						header("Location: nueva_pregunta.php?mensaje=correcto");
		}
		else {
		// En caso de producirse un error en el INSERT sql regresa a la página nueva_pregunta.php
		// indicando un mensaje.
			header("Location: nueva_pregunta.php?mensaje=error_sql");
		}
	// Cerramos la conexion a la BBDD.
		mysql_close($conexion);
	}
	else{
		// En caso de no rellenarse todos los campos vuelve al formulario de preguntas
		// con una variable a 2 que controlaremos en el formulario.
			header("Location: nueva_pregunta.php?mensaje=error_input");
	}
}	
	
?>