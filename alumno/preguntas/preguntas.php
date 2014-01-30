<?php

// Incluimos sesion para que no puedan acceder en caso de no estar logueado.

include ('../../include/sesion_alumno');

// Incluimos la conexion a la BBDD.

include ('../../include/conexion.php');

		if ($_SERVER['REQUEST_METHOD'] <> 'POST') {
			
			if (isset($_COOKIE['examen'])) {
				setcookie('examen', '');
			}

			include ('../../include/menu.php'); // Menu.
			
			echo '<h2 align="center">Elige el tipo de examen que deseas hacer.</h2>';

			echo '<form action="" align="center" method="post">
					<select name="ex">';
								
					$examen="SELECT `examen`.`tipo` FROM `Test`.`examen`"; /*Hacemos un select del tipo de examen*/
										
						$query_examen=mysqli_query($conexion, $examen); /*Ejecutamos la consulta*/
										
						while ($tipo_examen=mysqli_fetch_array($query_examen)) { /*Iniciamos un while por cada fila devuelta por la consulta*/
							/*Hacemos un select del id del tipo de examen*/
						 	$examenid="SELECT `examen`.`examenid` FROM `Test`.`examen` where `examen`.`tipo`='".$tipo_examen['tipo']."'";
							/*Ejecutamos la consulta*/
							$query_examenid=mysqli_query($conexion, $examenid);
							/*Capturamos el resultado*/
							$id_examen=mysqli_fetch_array($query_examenid);
							/*Imprimimos en value el id del examen y como nombre a elegir el tipo de examen*/
							echo "<option value=".$id_examen['examenid'].">".$tipo_examen['tipo']."</option>";		
								    	
					   	}

			echo '</select>
				<input type="submit" value="Mostrar"/>
				</form>';

		}
		
		else {
		
		if(!isset($_COOKIE['examen'])){
			setcookie('examen', $_POST['ex']);
		}

		include ('../../include/menu.php'); // Menu.

		echo '<form action="respuesta.php" method="post">
				<table style="border-style:solid;" align="center">';

		// SELECT que recoge los campos pregid,pregunta,r1,r2,r3,r4 filtrando por las que se encuentran

		// sin contestar y el usuario que ha iniciado sesion. Por ultimo ordenamos aleatoriamente 

		// indicando que solo nos devuelva un registro.
		
		$examen=$_POST['ex'];

		if(isset($_COOKIE['examen']))
		{
			echo "<input type='text' hidden name='ex' value=".$_COOKIE['examen']." />"; 
		} 													
		else
		{
			echo '<input type="text" hidden name="ex" value="'.$examen.'" />';
			
		}
		
		if(isset($_COOKIE['examen'])){
		
		$selectPregunta="SELECT preguntas.pregid,pregunta,r1,r2,r3,r4 

			FROM preguntas,preg_user 

			WHERE preguntas.pregid = preg_user.pregid 

			AND preguntas.examenid ='" .$_COOKIE['examen']. "' 

			AND preg_user.correcta='2' 

			AND preg_user.userid='".$userActivo."' 

			ORDER BY RAND() LIMIT 1";	

		}
		
		else{

		$selectPregunta="SELECT preguntas.pregid,pregunta,r1,r2,r3,r4 

			FROM preguntas,preg_user 

			WHERE preguntas.pregid = preg_user.pregid 

			AND preguntas.examenid ='" .$examen. "' 

			AND preg_user.correcta='2' 

			AND preg_user.userid='".$userActivo."' 

			ORDER BY RAND() LIMIT 1";

		} 

		// Enviamos la consulta.

		$queryPreg=mysqli_query($conexion, $selectPregunta);

		// Recogemos los valores.

		$query=mysqli_fetch_array($queryPreg);

		// Guardamos los datos en variables.

			$pregid=$query['pregid'];

			$pregunta=$query['pregunta'];

			$r1=$query['r1'];

			$r2=$query['r2'];

			$r3=$query['r3'];

			$r4=$query['r4'];

		// Comprobamos que nos devuelve filas. Si devuelve filas es que faltan preguntas por responder.

		// y muestra la pregunta escogida aleatoriamente para que la responda el usuario. Una vez 

		// respondida se gestiona la respuesta elegida en respuesta.php

			if (mysqli_num_rows($queryPreg))

			{
				if(isset($_COOKIE['examen'])){
													 
				$contar= "SELECT count(preguntas.pregid) 
				
					FROM preguntas,preg_user 
				
					WHERE preguntas.pregid = preg_user.pregid 
				
					AND preguntas.examenid ='".$_COOKIE['examen']."' 
				
					AND preg_user.correcta='2' 
				
					AND preg_user.userid='".$userActivo."'";

					$queryContar=mysqli_query($conexion, $contar);

					$contarQuery=mysqli_fetch_array($queryContar);

					$numpregs=$contarQuery['count(preguntas.pregid)'];


				} 
				else{

				$contar= "SELECT count(preguntas.pregid) 
				
					FROM preguntas,preg_user 
				
					WHERE preguntas.pregid = preg_user.pregid 
				
					AND preguntas.examenid ='".$examen."' 
				
					AND preg_user.correcta='2' 
				
					AND preg_user.userid='".$userActivo."'";

					$queryContar=mysqli_query($conexion, $contar);

					$contarQuery=mysqli_fetch_array($queryContar);

					$numpregs=$contarQuery['count(preguntas.pregid)'];

				}
					



				echo "<tr><td style='background:#5dd26c;padding:10px;'>".$pregunta."</td></tr>";

				echo "<tr><td>Preguntas restantes: " . $numpregs . "</td></tr>";

				echo "<tr><td><input type='text' name='id' hidden value='".$pregid."'/></td></tr>";

				echo "<tr><td><input type='radio' name='preg' value='1'/>".$r1."</td></tr>";

				echo "<tr><td><input type='radio' name='preg' value='2'/>".$r2."</td></tr>";

				echo "<tr><td><input type='radio' name='preg' value='3'/>".$r3."</td></tr>";

				echo "<tr><td><input type='radio' name='preg' value='4'/>".$r4."</td></tr>";

				echo "<tr><td align='center' colspan='2'><input type='submit' value='Responder'/></td></tr>";

				

			}

			else

		// Si no devuelve filas, el usuario ha contestado todas las preguntas

		// y se lo indicamos con un mensaje informativo.

			{

				echo "<tr><td style='background:#880015;color:white;padding:10px;'>Enhorabuena!</td></tr>";

				echo "<tr><td>- Has contestado todas las preguntas...</td></tr>";

				echo "<tr><td>- Puedes visualizar tus notas en '<b>Ver tus resultados</b>'</td></tr>";

				echo "<tr><td>- El profesor puede exponer m&aacute;s preguntas...</td></tr>";

			}

		echo '</table>
			</form>';
		}

	include ('../../include/footer.php');

?>



