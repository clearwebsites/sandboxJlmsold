<?php
	//create a database connection
	$dbhost = "127.0.0.1";
	$dbuser = "jlmartin";
	$dbpass = "23cFr$13";
	$dbname = "jlmartin";
	$db = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);
	if (mysqli_connect_errno()) {
		die("database connection failed:". 
			mysqli_connect_error() .
			"(" . mysqli_connect_errno().")");
	}

?>