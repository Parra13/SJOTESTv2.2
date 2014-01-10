<?php # Script 9.2 - mysqli_connect.php

// This file contains the database access information. 
// This file also establishes a connection to MySQL, 
// selects the database, and sets the encoding.

// Set the database access information as constants:
DEFINE ('DB_USER', 'parra');
DEFINE ('DB_PASSWORD', 'miniavefenix15');
DEFINE ('DB_HOST', 'parra.db');
DEFINE ('DB_NAME', 'Test');

// Make the connection:
$conexion = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );

// Set the encoding...
//mysqli_set_charset($conexion, 'utf8');

?>