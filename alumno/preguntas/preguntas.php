<?php
// Incluimos sesion para que no puedan acceder en caso de no estar logueado.
include ('../../include/sesion_alumno');
// Incluimos la conexion a la BBDD.
include ('../../include/conexion.php');
include ('../../include/menu.php'); // Menu.
?>
<p>
	<form action="respuesta.php" method="post">
	<table style="border-style:solid;" align="center">
		<?php
		// SELECT que recoge los campos pregid,pregunta,r1,r2,r3,r4 filtrando por las que se encuentran
		// sin contestar y el usuario que ha iniciado sesion. Por ultimo ordenamos aleatoriamente 
		// indicando que solo nos devuelva un registro.
		$selectPregunta="SELECT preguntas.pregid,pregunta,r1,r2,r3,r4 
			FROM preguntas,preg_user 
			WHERE preguntas.pregid = preg_user.pregid 
			AND preg_user.correcta='2' 
			AND preg_user.userid='".$userActivo."' 
			ORDER BY RAND() LIMIT 1";			
		// Enviamos la consulta.
		$queryPreg=mysql_query($selectPregunta,$conexion);
		// Recogemos los valores.
		$query=mysql_fetch_array($queryPreg);
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
			if (mysql_num_rows($queryPreg))
			{
				echo "<tr><td style='background:#5dd26c;padding:10px;'>".$pregunta."</td></tr>";
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
			
		?>
	</table>
	</form>
</p>
<?php
	include ('../../include/footer.php');
?>

