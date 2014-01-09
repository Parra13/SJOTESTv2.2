<?php
// Incluimos sesion de alumno.
include ('../../include/sesion_alumno');
// Incluimos la conexion a la BBDD.
include ('../../include/conexion.php');
// Incluimos el menu.
include ('../../include/menu.php');
// Consulta SQL, que devuelve el nombre, apellidos, el registro total del preguntas, el n� de preguntas sin contestar,
// el n� de preguntas falladas y el n� de preguntas acertadas filtrado por el usuario que ha iniciado sesion.
	$select_notas_user="SELECT apellido1,apellido2,nombre,
	COUNT(preg_user.pregid) as PreguntasBBDD,
	(SELECT COUNT(correcta) FROM preg_user WHERE correcta='2' AND userid='".$userActivo."') as PreguntasSinContestar,
	(SELECT COUNT(correcta) FROM preg_user WHERE correcta='1' AND userid='".$userActivo."') as PreguntasFalladas,
	(SELECT COUNT(correcta) FROM preg_user WHERE correcta='0' AND userid='".$userActivo."') as PreguntasAcertadas
	FROM usuario,preguntas,preg_user WHERE usuario.userid = preg_user.userid AND preguntas.pregid = preg_user.pregid 
	AND usuario.userid='".$userActivo."'";
	// Lanzamos Consulta.
		$sel_notas_user=mysql_query($select_notas_user,$conexion);
		$query=mysql_fetch_array($sel_notas_user);
		// Guardamos los datos en variables.
			$nombre=$query['nombre'];
			$apellido1=$query['apellido1'];
			$apellido2=$query['apellido2'];
			$PreguntasBBDD=$query['PreguntasBBDD'];
			$PreguntasSinContestar=$query['PreguntasSinContestar'];
			$PreguntasFalladas=$query['PreguntasFalladas'];
			$PreguntasAcertadas=$query['PreguntasAcertadas'];
			// Realizamos Operciones.
			$contestadas_usuario=$PreguntasAcertadas+$PreguntasFalladas;
				// Aqui realizamos la comprobacion de si es cero, por que puede ser que el usuario no conteste
				// ninguna pregunta. Entonces si dividimos un numero entre 0, es erroneo y PHP realiza un 
				// Warning indicando un mensaje.
					if ($contestadas_usuario=='0'){
					// Si es igual a 0, la variable se queda a cero.
						$porcentaje_acierto='0';
					}
					else {
					// Si no es cero, realiza la operacion de porcentaje de preguntas acertadas.
						$porcentaje_acierto=($PreguntasAcertadas/$contestadas_usuario)*100;	
					}
				// Porcentaje de Preguntas contestadas.
				$porcentaje_contestadas=($contestadas_usuario/$PreguntasBBDD)*100;
			// Los porcentajes devuelven muchos decimales, con sprintf mostramos solo dos decimales.
				$acierto=sprintf("%.2f",$porcentaje_acierto);
				$contestado=sprintf("%.2f",$porcentaje_contestadas);
			// Mostramos datos.
			echo "<p align='center'><table style='border:solid;'>";
				echo "<tr><td style='background:#880015;color:white;padding:10px;' colspan='2'>Tus resultados $apellido1 $apellido2, $nombre</td></tr>";
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
// Cerramos conexion a la BBDD.
mysql_close($conexion);
include ('../../include/footer.php');
?>