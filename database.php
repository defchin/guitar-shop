<?php
//Create database connection
	$dbhost = "localhost";
	$dbuser = "hamidkar_admin";
	$dbpass = "13trdsport";
	$dbname = "hamidkar_guitar";
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
//Test for successful connection.
	if (mysqli_connect_errno()) {
		header("Location: database_error.php");
		exit;
	}
?>