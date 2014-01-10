<?php

	// Incluimos la conexion a la BBDD

	include ('include/conexion.php');

		// Comprobamos si se ha realizado el metodo post

		IF ($_SERVER['REQUEST_METHOD'] == 'POST'){

			//Comprobamos que los campos "user" y "pass" no esten vacios

			if (!empty($_POST['user']) && !empty($_POST['pass'])){

				$user=mysqli_real_escape_string($conexion, trim(strip_tags($_POST['user'])));

				$password=mysqli_real_escape_string($conexion, trim(strip_tags(md5($_POST['pass']))));		

				// mysqli_real_escape_string: evitainyecciones de SQL.

				// trim: elimina espacios en blanco del inicio y final.

				// strip_tags: elimina elementos introducidos de HTML y PHP.				

				// md5: genera un codigo md5 a partir del texto indicado

				

				//Guardamos la consulta en una variable

				$select="select nick, administrador, userid from usuario where nick='".$user."' and pass='".$password."'";

				//Ejecutamos la query de mysqli y la guardamos en la variable $query

				$query=mysqli_query($conexion, $select);

				

				if(mysqli_num_rows($query)){							//Comprobamos que el query ha devuelto lineas

					session_start();									//Iniciamos la session

					while($row = mysqli_fetch_array($query)){			//Mediante un while recorremos resultado del query

						if($row['nick'] == $user){						//Comprobamos que nuestro campo "nombre" coincide

																		//con el campo "nombre" devuelto por el query

							$_SESSION['admin'] = $row['administrador']; //Guardamos el valor del campo administrador en la

																		//session

							$_SESSION['user'] = $row['userid'];			//Guardamos el userid del usuario loggeado

							header("Location: principal.php");			//Redirijimos a la pagina de menu

						}				

					}

				}

				else{ //Si el query no ha devuelto lineas...

					header("Location: index.php?mensaje=2"); //Enviamos un GET a la pagina de login para mostrar un error

				}

			}

		else{//Si algun campo del formulario esta vacio...

			header("Location: index.php?mensaje=1"); //Enviamos un GET a la pagina de login para mostrar un error

		}

	}

?>