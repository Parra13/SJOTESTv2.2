<?php
	$urlRoot="http://iaw-ramses.zxq.net/sjotest"; //Variable que contiene la ruta principal de nuestro hosting	
	if($logType=="1") //Si nuestra session esta iniciada como profesor muestra este menu
	{		
		echo //Echo que escribe el menu en nuestra pagina
		<<<start
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
				<head>
					<title>SJOTEST</title>
					<link rel="stylesheet" href="$urlRoot/menu.css">
				</head>
				<body>
				<div id="header">
					<div id="menu">
						<ul>
							<li><a href="$urlRoot/profesor/crear_pregunta/nueva_pregunta.php">Crear Pregunta</a></li>
							<li><a href="$urlRoot/profesor/mod_pregunta/mod_preg.php">Modificar Pregunta</a></li>
							<li><a href="$urlRoot/profesor/notas/notas.php">Ver Resultados</a></li>
							<li><a href="$urlRoot/profesor/gestion_usuario/gestion_usuarios.php">Gestionar Usuarios</a></li>
							<li><a href="$urlRoot/index.php">Cerrar Sesi&oacute;n</a></li>
						</ul>
					</div>
				</div>
				<div id="centrado">
start;
	}
	else if ($logType=="0") //Si nuestra session esta iniciada como alumno muestra este otro menu
	{
		echo //Echo que escribe el menu en nuestra pagina
		<<<start
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html>
				<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
					<title>SJOTEST</title>
					<link rel="stylesheet" href="$urlRoot/menu.css">
				</head>
				<body>
				<div id="header">
					<div id="menu">
						<ul>
							<li><a href="$urlRoot/alumno/preguntas/preguntas.php">Responder Preguntas</a></li>
							<li><a href="$urlRoot/alumno/gestion_cuenta/gestion_cuenta.php">Modificar Perfil</a></li>							
							<li><a href="$urlRoot/alumno/notas/notas.php">Ver Tus Resultados</a></li>
							<li><a href="$urlRoot/index.php">Cerrar Sesi&oacute;n</a></li>							
						</ul>
					</div>
				</div>
				<div id="centrado">
start;
	}
	else{
	<<<start
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html>
				<head>
					<link rel="stylesheet" href="$urlRoot/menu.css">
				</head>
				<body>					
start;
	}
?>