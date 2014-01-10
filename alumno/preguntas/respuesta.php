<?php

// Incluimos sesion para que no puedan acceder en caso de no estar logueado.

include ('../../include/sesion_alumno');

// Incluimos la conexion a la BBDD

include ('../../include/conexion.php');

//

if (isset($_POST['preg']) && isset($_POST['id'])){

	$respuesta=$_POST['preg']; // variable que contiene la respuesta del usuario.

	$pregid=$_POST['id']; // variable que contiene el ID de la pregunta contestada.

// Consulta SQL que contiene la respuesta correcta de la pregunta contestada por el usuario.

		$select="SELECT rc FROM preguntas WHERE pregid='".$pregid."'";

		// Lanzamos consulta.

		$consulta=mysqli_query($conexion, $select);

		// 

		$query=mysqli_fetch_array($consulta);

		// Finalmente comprobamos que la respuesta elegida por el usuario es = a la respuesta correcta 

		// de la pregunta contestada.

			$respuestaCorrecta=$query['rc'];

			// Si es correcto realiza un UPDATE del usuario y la pregunta con correcta='0', que significa correcta.

			// Por ultimo con Header, regresa a preguntas.php para seguir contestando.

				if ($respuesta==$respuestaCorrecta){					

					$update="UPDATE preg_user SET correcta='0' WHERE userid='".$userActivo."' AND pregid='".$pregid."'";

					$query=mysqli_query($conexion, $update);

					?>

					<script language='JavaScript'>

					alert("La respuesta es correcta");

					location.href='preguntas.php';

					</script>

					<?php

					//header('Location: preguntas.php');

				}

			// Si no realiza un UPDATE del usuario y la pregunta con correcta='1' que significa fallo.

			// Por ultimo con Header, regresa a preguntas.php para seguir contestando.

				else {					

					$update="UPDATE preg_user SET correcta='1' WHERE userid='".$userActivo."' AND pregid='".$pregid."'";

					$query=mysqli_query($conexion, $update);

					?>

					<script language='JavaScript'>

					alert("La respuesta es incorrecta");

					location.href='preguntas.php';

					</script>

					<?php

					//header('Location: preguntas.php');

				}

	}

?>