<?php

// Incluimos sesion de profesor.

include("../../include/sesion_profesor");

// Incluimos la conexion a la BBDD.

include("../../include/conexion.php");

// Incluimos menu.

include("../../include/menu.php");

?>

<?php

// Inicializamos variable $busqueda vacia.

$busqueda = ""; 

// Si el textbox 'busqueda' no esta vacio almacena el texto

// en la variable $txt_busqueda.

if ($_GET["busqueda"]!=""){ 

   	$txt_busqueda = $_GET["busqueda"];

// Ahora la variable $busqueda contiene la condición WHERE con un LIKE sobre preguntas

// con el texto que el usuario ha introducido en el textbox.	

   	$busqueda="where pregunta like '%".$txt_busqueda."%'"; 

}

?>

<!-- 

	Formulario para buscar las palabras clave o preguntas

	junto a un Link para mostrar todas las preguntas.

-->

	<form action="mod_preg.php" method="get"> 

	<table align="center">

			<tr>

				<td><input type="submit" value="Buscar palabra clave"></td>

				<td><input type="text" name="busqueda" size="22" maxlength="150"></td> 

	</form>

				<td><a href="mod_preg.php">Mostrar todas las preguntas</a></td>

			</tr>

		</table>

<!-- -->

<div id="preguntas">

<table border='1' align="center">

<?php

// Limite de la paginacion: 5 registros.

$tm_pagina="5";

// Paso parámetro por URL. Si no se recibe una pagina se supone que es la primera.

// Si habíamos recibido algo como pagina, calculo el inicio con una simple 

// multiplicacion de la pagina a mostrar por el tamaño de paginacion definido antes.

	if (!isset($_GET['pagina'])) {

		$pagina="1";

		$inicio="0";

		}

	else {

		$pagina=$_GET['pagina'];

		$inicio=($pagina -1)*$tm_pagina;

	}

	// Orden SQL que incluye la variable $busqueda, que puede estar

	// vacia si el usuario no realiza una busqueda en el textbox.

	$select="SELECT * FROM preguntas ".$busqueda;

	$query=mysqli_query($conexion, $select);

	$num_total_registros=mysqli_num_rows($query);

	// La funcion CEIL de PHP sirve para redondear un numero siempre hacia arriba,

	// es decir devuelve el entero por arriba mas proximo.

	$paginas_total=ceil($num_total_registros / $tm_pagina);

		// Variables que utilizo para incrementar y decrementar.

		$limit_anterior="1";

		$limit_siguiente="1";

		// Recorremos los datos con un WHILE. Realizamos una comprobacion:

		// Si el $limit_anterior es mayor que $inicio y el $limit_siguiente

		// es menor o igual que el $tm_pagina (el numero que defino arriba

		// para la paginacion) imprime las preguntas y le suma +1 al

		// $limit_siguiente hasta que llegue al numero definido en $tm_pagina.

		//

		// En caso contrario le sumará +1 a la variable $limit_anterior.

		while($fila=mysqli_fetch_array($query)){

			if ($limit_anterior > $inicio && $limit_siguiente <= $tm_pagina){

			// Guardamos los datos de la BBDD en una variable.

				$id=$fila['pregid'];

				$preg=$fila['pregunta'];

			// ECHO que imprime las preguntas.

				echo "<tr><td>".$id."</td><td>".$preg."</td><td><a href='mod_preg_del.php?id=".$id."'>Modificar</a></td></tr>";  

				$limit_siguiente=$limit_siguiente+1;}

			else {

				$limit_anterior=$limit_anterior+1;

			}

		}

		?>

</table>

</div>

<!-- -->

<div id="paginacion">

<p>

		<?php

			// Variables que utilizo para las '<<>>', es decir, la variable $pagina

			// contendra la pagina en la que se encuentra en ese momento. Por tanto

			// a $anterior le resto un valor -1 y a $siguiente le sumo un valor +1.

			$anterior=$pagina-1;

			$siguiente=$pagina+1;

			// IF: si $anterior se encuentra a 0, significa que se encuentra

			// en la primera pagina, por tanto imprime '<<' sin LINK.

			if ($anterior==0){

				echo " << ";

			}

			else {

				// En caso contrario imprime '>>' en un link con la variable $anterior.

				echo "<a href='mod_preg.php?pagina=".$anterior."&busqueda=".$txt_busqueda."'> << </a>";

			}

			// IF: si la variable $paginas_total es mayor que 1, significa que hay

			// mas de una pagina. Hacemos un FOR para imprimir los numeros.

			// Si $pagina es = $i significa que el numero que va imprimir es la pagina

			// que esta activa en este momento, por tanto se imprime, pero sin LINK.

			// En caso cntrario imprime LINK con el numero correspondiente hasta 

			// que $i sea menor o igual que $paginas_total

			if ($paginas_total > 1){

				for($i=1;$i<=$paginas_total;$i++){

					if ($pagina==$i){

						echo $pagina."";}

					else {

						echo "<a href='mod_preg.php?pagina=".$i."&busqueda=".$txt_busqueda."'>".$i."</a>";}

					}		

			}

			// IF: si $siguiente es mayor que $paginas_total, significa

			// que no ha mas paginas, por tanto imprime '>>' sin LINK.

			if ($siguiente > $paginas_total){

				echo " >> ";

			}

			else {

			// En caso contrario imprime '>>' en un link con la variable $anterior.

				echo "<a href='mod_preg.php?pagina=".$siguiente."&busqueda=".$txt_busqueda."'> >> </a>";

			}

		?>

</p>

</div>

		<?php

		// Informacion sobre las paginas existentes.

		echo "<table align='center' style='border:solid 1px;font-style: italic;'>";

			echo "<tr><td>N&uacute;mero de registros encontrados: ".$num_total_registros."</td></tr>";

			echo "<tr><td>Mostrando p&aacute;gina ".$pagina." de ".$paginas_total."</td></tr>";

		echo "</table>";

?>

<p>

		<?php

			// Validamos los resultados que se producen en ac_pregunta.php y que redireccionan

			// a estos datos. En este caso validamos si se ha eliminado o bien actualizado.

				$validar=$_GET['mensaje'];

				if ($validar=='delete'){

					echo "<div style='color:#4F8A10;background-color:#DFF2BF;border:solid 1px;width:220px;padding:10px;'>

					Pregunta eliminada correctamente</div>";

					//exit(1);

				}

				if ($validar=='update'){

					echo "<div style='color:#4F8A10;background-color:#DFF2BF;border:solid 1px;width:220px;padding:10px;'>

					Pregunta actualizada correctamente</div>";

					//exit(1);

				}

				if ($validar=='error'){

					// Mensaje que se mostrará en caso de que se produzca un error en el proceso SQL. 

					echo "<div style='color: #D8000C;background-color: #FFBABA;border:solid 1px;width:350px;padding:10px;'>

					Se ha producido un fallo durante el proceso.<br/>

					Por favor contacte con el administrador de la aplicaci&oacute;n.<br/></div>";

					//exit(1);		

				}

		?>

</p>

<?php 

// Incluimos footer de la aplicacion.

include("../../include/footer.php"); 

?>