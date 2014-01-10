<?php 

// Incluimos la sesion del profesor.

include('../../include/sesion_profesor');

// Conexion a la BBDD.

include('../../include/conexion.php');

// Incluimos el menu.

include('../../include/menu.php');

?>

<table border="1" align="center" style="text-align:center;">

<tr>

	<th>Apellidos</th>

	<th>Nombre</th>

	<th>Preguntas Total</th>

	<th>Aciertos</th>

	<th>Fallos</th>

	<th>No Respondidas</th>

	<th>% Contestado</th>

	<th>% de Aciertos</th>

</tr>

<?php

	// Consulta SQL.

	$select_user="SELECT userid FROM usuario WHERE administrador='0'";

	$users=mysqli_query($conexion, $select_user);

		// WHILE para recorrer todos los usuarios de la BBDD.

		while($alumno=mysqli_fetch_array($users)){

			$userid=$alumno['userid'];

			// // Consulta SQL, que devuelve el nombre, apellidos, el registro total del preguntas, el nº de preguntas sin contestar,

			// el nº de preguntas falladas y el nº de preguntas acertadas por todos los usuarios.

			$select_notas_user="SELECT apellido1,apellido2,nombre,

			COUNT(preg_user.pregid) as PreguntasBBDD,

			(SELECT COUNT(correcta) FROM preg_user WHERE correcta='2' AND userid='".$userid."') as PreguntasSinContestar,

			(SELECT COUNT(correcta) FROM preg_user WHERE correcta='1' AND userid='".$userid."') as PreguntasFalladas,

			(SELECT COUNT(correcta) FROM preg_user WHERE correcta='0' AND userid='".$userid."') as PreguntasAcertadas

			FROM usuario,preguntas,preg_user WHERE usuario.userid = preg_user.userid AND preguntas.pregid = preg_user.pregid 

			AND usuario.userid='".$userid."'";

			// Lanzamos consulta.

			$user_notas=mysqli_query($conexion, $select_notas_user);

			// Recorremos los datos devueltos.

			$notas=mysqli_fetch_array($user_notas);

			// Guardamos en variables los valores obtenidos de la consulta.

			$alumno=$notas['nombre'];

			$apellido1=$notas['apellido1'];

			$apellido2=$notas['apellido2'];

			$total_preg=$notas['PreguntasBBDD'];

			$preguntasSinContestar=$notas['PreguntasSinContestar'];

			$preguntasFalladas=$notas['PreguntasFalladas'];

			$preguntasAcertadas=$notas['PreguntasAcertadas'];

			// Extraemos porcentajes con los datos Obtenidos.

				$contestadas_usuario=$preguntasAcertadas+$preguntasFalladas;

				// Aqui realizamos la comprobacion de si es cero, por que puede ser que el usuario no conteste

				// ninguna pregunta. Entonces si dividimos un numero entre 0, es erroneo y PHP realiza un 

				// Warning indicando un mensaje.

					if ($contestadas_usuario=='0'){

					// Si es igual a 0, la variable se queda a cero.

						$porcentaje_acierto='0';

					}

					else {

					// Si no es cero, realiza la operacion de porcentaje de preguntas acertadas.

						$porcentaje_acierto=($preguntasAcertadas/$contestadas_usuario)*100;	

					}

				$porcentaje_contestadas=($contestadas_usuario/$total_preg)*100;

			// Los porcentajes devuelven muchos decimales, con sprintf mostramos solo dos decimales.

				$acierto=sprintf("%.2f",$porcentaje_acierto);

				$contestado=sprintf("%.2f",$porcentaje_contestadas);

			// Por ultimo mostramos los datos.

			echo "<tr>";

				echo "<td>".$apellido1." ".$apellido2."</td>";

				echo "<td>".$alumno."</td>";

				echo "<td>".$total_preg."</td>";

				echo "<td>".$preguntasAcertadas."</td>";

				echo "<td>".$preguntasFalladas."</td>";

				echo "<td>".$preguntasSinContestar."</td>";

				echo "<td>".$contestado." %</td>";

				// if para comprobar que si es menor de 50% el color de texto sea rojo

				// si no que se de color verde.

					if ($acierto < '50.00'){

						echo "<td style='color:red;'>".$acierto." %</td>";

					}

					else{

						echo "<td style='color:green;'>".$acierto." %</td>";

					}

			echo "</tr>";

	}

	?>

</table>

<?php include  ('../../include/footer.php'); ?>



