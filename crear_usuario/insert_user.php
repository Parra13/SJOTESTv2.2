<?php

// Incluimos la conexion a la BBDD.

include ('../include/conexion.php');

// Comprobamos que los campos no se encuentren vacios.

if ($_SERVER['REQUEST_METHOD'] = 'POST'){


	if (!empty($_POST['id']) && !empty($_POST['pass2']) && !empty($_POST['pass1'])){

		// mysqli_real_escape_string: evita inyecciones de SQL.

		// trim: elimina espacios en blanco del inicio y final.

		// strip_tags: elimina elementos introducidos de HTML y PHP.

			$id=mysqli_real_escape_string($conexion, trim(strip_tags($_POST['id'])));

			$nombre=mysqli_real_escape_string($conexion, trim(strip_tags($_POST['nombre'])));

			$apellido1=mysqli_real_escape_string($conexion, trim(strip_tags($_POST['apellido1'])));

			$apellido2=mysqli_real_escape_string($conexion, trim(strip_tags($_POST['apellido2'])));

		// SELECT para comprobar si el usuario ya existe.

			$select="SELECT nick FROM usuario WHERE nick='".$id."'";
			echo "$nick";
		// Ejecutamos Orden SQL.

			$queryNick= mysqli_query($conexion, $select);
		// Condicion para validar si existe el usuario Introducido en la BBDD.

			if (mysqli_num_rows($queryNick)){

			header("Location: nuevo_usuario.php?mensaje=usuario_existe");

			exit(1);

			}

		// Comprobamos que las contraseñas introducidas sean iguales.

			if ($_POST['pass1'] == $_POST['pass2']){			

				$id_pass=mysqli_real_escape_string($conexion, trim(strip_tags($_POST['pass2'])));

				// Enciptacion en MD5 de la contraseña.

				$pass_md5=md5($id_pass);

				// Orden SQL para insertar los datos.

				$insert="INSERT INTO usuario (nick,nombre,apellido1,apellido2,pass,fecha,administrador) VALUES 

				('".$id."','".$nombre."','".$apellido1."','".$apellido2."','".$pass_md5."', NOW(), '0')";

				// Ejecucion de las ordenes.

				$query=mysqli_query($conexion, $insert);

				// Comprobamos que el INSERT se ha producido correctamente.

					if ($query){

						// Se produce correctamente las ordenes anteriores ejecutaremos otras:

						// $select_preg: SELECT con todas las preguntas de la BBDD.

						// $select_user: SELECT que contiene el userid del usuario que se acaba

						// de registrar en la BBDD.

						$select_preg="SELECT * FROM preguntas";

						$select_user="SELECT userid FROM usuario WHERE nick='".$id."'";

						// Ejecutamos las ordenes.

						$preguntas=mysqli_query($conexion,$select_preg);

						$usuario=mysqli_query($conexion,$select_user);

						// con la función mysqli_fetch_array() recorremos la fila que tiene que devolver

						// para obtener el ID del usuario creado y la guardamos en una variable para 

						// utilizarla posteriormente.

						$userid=mysqli_fetch_array($usuario);

						$userid_one=$userid['userid'];

						// Ahora utilizamos un WHILE con la funcion mysqli_fetch_array() para 

						// recorrer todas las filas de la tabla preguntas.

						while ($preg=mysqli_fetch_array($preguntas)){

							// Finalmente por cada pregunta, se realiza un INSERT en preg_user con el ID de la pregunta,

							// el ID de usuario (guardado anteriormente y que sera siempre el mismo) y en 'correcta' 

							// dejamos por defecto el valor '2' indicando que la pregunta no ha sido contestada.

							$question=$preg['pregid'];

							$insert_preg_user="INSERT INTO preg_user (userid,pregid,correcta) VALUES ('".$userid_one."','".$question."','2')";

							$q_insert_preg_user=mysqli_query($conexion,$insert_preg_user);

						}

						// Finalmente una vez insertados los nuevos datos en preg_user y finalizado el 

						// WHILE regresa a nueva_pregunta.php para seguir introduciendo preguntas.

							header("Location: nuevo_usuario.php?mensaje=correcto");

					}

					else {

						// En caso de producirse un error en instrucciones SQL regresa a la página nueva_pregunta.php

						// indicando un mensaje.

							// header("Location: nuevo_usuario.php?mensaje=error_sql");
					echo '<p class="error">The current users could not be retrieved. We apologize for any inconvenience.</p>';
					echo '<p>' . mysqli_error($conexion) . '<br /><br />Query: ' . $q . '</p>';
					}

				// Cerramos Conexion a la BBDD.

				mysqli_close($conexion);

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