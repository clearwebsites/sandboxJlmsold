<?php
	include("../includes/sessions.php");
	include("../includes/functions.php");
	include("../includes/dbconnection.php");
	confirm_logged_in();
?>
<?php	
	$id =  $_GET['id'];

	$query  = "DELETE FROM admins ";
	$query .= "WHERE id = {$id} ";
	$query .= "LIMIT 1";

	$result = mysqli_query($db, $query);

	if ($result && mysqli_affected_rows($db) == 1) {
		// Success
		$_SESSION["message"] = "Admin Deleted";
		redirect_to("manage_admins.php");
		
	} else {
		// Failure
		$message = "Admin delete failed";
		die("Database this query failed. ". $_LISTINGID ." " . mysqli_error($db));
	}
		if(isset($db)){
			mysqli_close($db);
		};
?>