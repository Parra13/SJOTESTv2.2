<?php

// Incluimos sesion de alumno.

include ('../../include/sesion_alumno');

// Incluimos la conexion a la BBDD.

include ('../../include/conexion.php');

// Incluimos el menu.

include ('../../include/menu.php');

// Consulta SQL, que devuelve el nombre, apellidos, el registro total del preguntas, el nº de preguntas sin contestar,

// el nº de preguntas falladas y el nº de preguntas acertadas filtrado por el usuario que ha iniciado sesion.

	$exams="SELECT (examenid) AS NumExams FROM Test.examen";

	$select_exams=mysqli_query($conexion, $exams);

	while ($queryExams=mysqli_fetch_array($select_exams)) {

	$i=$queryExams['NumExams'];

	$select_notas_user="SELECT apellido1,apellido2,nombre,tipo,

	COUNT(preg_user.pregid)  as PreguntasBBDD,

	(SELECT COUNT(correcta) FROM preguntas,preg_user,examen WHERE preguntas.pregid = preg_user.pregid 
	AND examen.examenid = preguntas.examenid AND correcta='2' AND examen.examenid='".$i."' AND userid='".$userActivo."') as PreguntasSinContestar,

	(SELECT COUNT(correcta) FROM preguntas,preg_user,examen WHERE preguntas.pregid = preg_user.pregid 
	AND examen.examenid = preguntas.examenid AND correcta='1' AND examen.examenid='".$i."' AND userid='".$userActivo."') as PreguntasFalladas,

	(SELECT COUNT(correcta) FROM preguntas,preg_user,examen WHERE preguntas.pregid = preg_user.pregid 
	AND examen.examenid = preguntas.examenid AND correcta='0' AND examen.examenid='".$i."' AND userid='".$userActivo."') as PreguntasAcertadas

	FROM usuario,preguntas,preg_user,examen WHERE usuario.userid = preg_user.userid AND preguntas.pregid = preg_user.pregid 
	
	AND examen.examenid = preguntas.examenid AND usuario.userid='".$userActivo."' and examen.examenid='".$i."'";
 
	// Lanzamos Consulta.

		$sel_notas_user=mysqli_query($conexion, $select_notas_user);

		$query=mysqli_fetch_array($sel_notas_user);

		// Guardamos los datos en variables.

			$nombre=$query['nombre'];

			$apellido1=$query['apellido1'];

			$apellido2=$query['apellido2'];

			$PreguntasBBDD=$query['PreguntasBBDD'];

			$PreguntasSinContestar=$query['PreguntasSinContestar'];

			$PreguntasFalladas=$query['PreguntasFalladas'];

			$PreguntasAcertadas=$query['PreguntasAcertadas'];

			$TipoExamen=$query['tipo'];

			// Realizamos Operciones.

			$contestadas_usuario=$PreguntasAcertadas+$PreguntasFalladas;

				// Aqui realizamos la comprobacion de si es cero, por que puede ser que el usuario no conteste

				// ninguna pregunta. Entonces si dividimos un numero entre 0, es erroneo y PHP realiza un 

				// Warning indicando un mensaje.

				if ($PreguntasBBDD <> '0'){
					
					if ($contestadas_usuario=='0'){

					// Si es igual a 0, la variable se queda a cero.

						$porcentaje_acierto='0';
					}

					else {

					// Si no es cero, realiza la operacion de porcentaje de preguntas acertadas.

						$porcentaje_acierto=($PreguntasAcertadas/$contestadas_usuario)*100;	
						
					}
					
					$porcentaje_contestadas=($contestadas_usuario/$PreguntasBBDD)*100;
				// Porcentaje de Preguntas contestadas.

				

			// Los porcentajes devuelven muchos decimales, con sprintf mostramos solo dos decimales.

				$acierto=sprintf("%.2f",$porcentaje_acierto);

				$contestado=sprintf("%.2f",$porcentaje_contestadas);

			// Mostramos datos.

			echo "<p align='center'><table style='border:solid;'>";

				echo "<tr><td style='background:#880015;color:white;padding:10px;' colspan='2'>Tus resultados en $TipoExamen, $apellido1 $apellido2, $nombre</td></tr>";

				echo "<tr><td>Preguntas totales:</td><td>$PreguntasBBDD</td></tr>";

				echo "<tr><td>No contestadas:</td><td>$PreguntasSinContestar</td></tr>";

				echo "<tr><td>Aciertos:</td><td>$PreguntasAcertadas</td></tr>";

				echo "<tr><td>Fallos:</td><td>$PreguntasFalladas</td></tr>";

				echo "<tr><td>Porcentaje Contestadas:</td><td>$contestado %</td></tr>";

					if ($acierto < '50.00'){

						echo "<tr><td>Porcentaje Acertadas:</td><td style='color:red;'>$acierto %</td></tr>";

					}

					else{

						echo "<tr><td>Porcentaje Acertadas:</td><td style='color:green;'>$acierto %</td></tr>";

					}

			echo "</p></table>";
			}
	}
// Cerramos conexion a la BBDD.

	mysqli_close($conexion);



include ('../../include/footer.php');

?>