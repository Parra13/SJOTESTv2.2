<?php
// Incluimos la conexion a la BBDD.
include ('../include/conexion.php');
// Comprobamos que los campos no se encuentren vacios.
if ($_SERVER['REQUEST_METHOD'] = 'POST'){
	//Código Nuevo: Adrià Moyá
	if (empty($_POST['codigoSeguro'])){
			header("Location: nuevo_usuario.php?mensaje=no_hay_codigo_secreto");			
	}
	else {
		$consulta="SELECT configuracion FROM configuracion WHERE nombre='preguntaSegura'"; //creamos consulta
		$query=mysql_query($consulta,$conexion); //lanzamos la consulta
	
		while($pregunta=mysql_fetch_array($query)) //capturamos la configuracion
		{ 
			$preguntaSecreta=$pregunta['configuracion'];		
		}
		if ($_POST['codigoSeguro'] != $preguntaSecreta){ //comprobamos que la pregunta sae correcta
			header("Location: nuevo_usuario.php?mensaje=codigo_secreto_erroneo");
			exit(1);
		}
	}
	if (!empty($_POST['id']) && !empty($_POST['pass2']) && !empty($_POST['pass1'])){
		// mysql_real_escape_string: evita inyecciones de SQL.
		// trim: elimina espacios en blanco del inicio y final.
		// strip_tags: elimina elementos introducidos de HTML y PHP.
			$id=mysql_real_escape_string(trim(strip_tags($_POST['id'])));
			$nombre=mysql_real_escape_string(trim(strip_tags($_POST['nombre'])));
			$apellido1=mysql_real_escape_string(trim(strip_tags($_POST['apellido1'])));
			$apellido2=mysql_real_escape_string(trim(strip_tags($_POST['apellido2'])));
		// SELECT para comprobar si el usuario ya existe.
			$select="SELECT nick FROM usuario WHERE nick='".$id."'";
		// Ejecutamos Orden SQL.
			$queryNick=mysql_query($select,$conexion);
		// Condicion para validar si existe el usuario Introducido en la BBDD.
			if (mysql_num_rows($queryNick)){
			header("Location: nuevo_usuario.php?mensaje=usuario_existe");
			exit(1);
			}
		// Comprobamos que las contraseñas introducidas sean iguales.
			if ($_POST['pass1'] == $_POST['pass2']){			
				$id_pass=mysql_real_escape_string(trim(strip_tags($_POST['pass2'])));
				// Enciptacion en MD5 de la contraseña.
				$pass_md5=md5($id_pass);
				// Orden SQL para insertar los datos.
				$insert="INSERT INTO usuario (nick,nombre,apellido1,apellido2,pass,fecha,administrador) VALUES 
				('".$id."','".$nombre."','".$apellido1."','".$apellido2."','".$pass_md5."',CURDATE(),'0')";
				// Ejecucion de las ordenes.
				$query=mysql_query($insert,$conexion);
				// Comprobamos que el INSERT se ha producido correctamente.
					if ($query){
						// Se produce correctamente las ordenes anteriores ejecutaremos otras:
						// $select_preg: SELECT con todas las preguntas de la BBDD.
						// $select_user: SELECT que contiene el userid del usuario que se acaba
						// de registrar en la BBDD.
						$select_preg="SELECT * FROM preguntas";
						$select_user="SELECT userid FROM usuario WHERE nick='".$id."'";
						// Ejecutamos las ordenes.
						$preguntas=mysql_query($select_preg,$conexion);
						$usuario=mysql_query($select_user,$conexion);
						// con la función mysql_fetch_array() recorremos la fila que tiene que devolver
						// para obtener el ID del usuario creado y la guardamos en una variable para 
						// utilizarla posteriormente.
						$userid=mysql_fetch_array($usuario);
						$userid_one=$userid['userid'];
						// Ahora utilizamos un WHILE con la funcion mysql_fetch_array() para 
						// recorrer todas las filas de la tabla preguntas.
						while ($preg=mysql_fetch_array($preguntas)){
							// Finalmente por cada pregunta, se realiza un INSERT en preg_user con el ID de la pregunta,
							// el ID de usuario (guardado anteriormente y que sera siempre el mismo) y en 'correcta' 
							// dejamos por defecto el valor '2' indicando que la pregunta no ha sido contestada.
							$question=$preg['pregid'];
							$insert_preg_user="INSERT INTO preg_user (userid,pregid,correcta) VALUES ('".$userid_one."','".$question."','2')";
							$q_insert_preg_user=mysql_query($insert_preg_user,$conexion);
						}
						// Finalmente una vez insertados los nuevos datos en preg_user y finalizado el 
						// WHILE regresa a nueva_pregunta.php para seguir introduciendo preguntas.
							header("Location: nuevo_usuario.php?mensaje=correcto");
					}
					else {
						// En caso de producirse un error en instrucciones SQL regresa a la página nueva_pregunta.php
						// indicando un mensaje.
							header("Location: nuevo_usuario.php?mensaje=error_sql");
					}
				// Cerramos Conexion a la BBDD.
				mysql_close($conexion);
			}
			else{
				// Redirección indicando que las contraseñas son distintas si se produce este evento.
				header("Location: nuevo_usuario.php?mensaje=error_pass");
			}
	}
	else{
	// Redirección indicando que los campos se encuentran vacios si se produce este evento.
	header("Location: nuevo_usuario.php?mensaje=error_input");
	}
}	
?>