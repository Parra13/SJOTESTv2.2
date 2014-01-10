<?php 

// Incluimos sesion de profesor.

include ("../../include/sesion_profesor");

// Incluimos la conexion a la BBDD.

include ("../../include/conexion.php");

// Incluimos menu.

include("../../include/menu.php");

?>

<p>

<?php

			// Orden SQL.

			$consulta="SELECT * FROM preguntas WHERE pregid=".$_GET['id'];

			// Lanzamos Consulta.

			$query=mysqli_query($conexion, $consulta);

			// Recorremos los datos obtenidos de la consulta.

			$mod_pregunta=mysqli_fetch_array($query);


				$id=$mod_pregunta['pregid'];

				$pr=$mod_pregunta['pregunta'];

				$r1=$mod_pregunta['r1'];

				$r2=$mod_pregunta['r2'];

				$r3=$mod_pregunta['r3'];

				$r4=$mod_pregunta['r4'];

				$rc=$mod_pregunta['rc'];

				$ex=$id_examen['tipo'];

		// Mostramos Datos en un Formulario, para posteriormente reenviarlo ac_pregunta

		// que realizara las acciones pertinentes.

		echo "<form action='ac_pregunta.php' method='post'>";

			echo "<table align='center'><tr><td>";

			echo "<fieldset style='width:290px;'>";

			echo "<legend><strong>Modificar Pregunta</strong></legend>";

				echo "<label>Pregunta: </label><input type='text' name='pregunta' size='40' value='".$pr."'/><br/>";

				echo "<label>Respuesta 1: </label><input type='text' name='r1' size='40' value='".$r1."'/><br/>";

				echo "<label>Respuesta 2: </label><input type='text' name='r2' size='40' value='".$r2."'/><br/>";

				echo "<label>Respuesta 3: </label><input type='text' name='r3' size='40' value='".$r3."'/><br/>";

				echo "<label>Respuesta 4: </label><input type='text' name='r4' size='40' value='".$r4."'/><br/>";

				echo "<label>Respuesta Correcta: </label><input type='text' name='rc' size='3' value='".$rc."'/><br/>";

				echo "<input type='text' name='pregid' size='3' hidden='hidden' value='".$id."'/>";

/******************************************************************************************************************************/

				echo "<p><label>Examen: </label>
					  <select require name=\"ex\">";
					
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
							    	
				echo "</select></p>";

/********************************************************************************************************************************/

				echo "<p><input type='submit' name='act' value='Actualizar Pregunta'/>";

				echo "<input type='submit' name='borrar' value='Borrar Pregunta'/></p>";

			echo "</fieldset>";

			echo "</td></tr></table>";

		echo "</form>";

?>

</p>



<?php 

// Cerramos conexión a la BBDD.

include  ('../../include/footer.php');

?>