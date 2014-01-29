<?php
	//create a database connection
	$dbhost = "127.0.0.1";
	$dbuser = "root";
	$dbpass = "odie8987";
	$dbname = "jlmartin";
	$db = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);
	if (mysqli_connect_errno()) {
		die("database connection failed:". 
			mysqli_connect_error() .
			"(" . mysqli_connect_errno().")");
	}

?>