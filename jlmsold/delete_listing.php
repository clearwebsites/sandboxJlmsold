<?php
	include("../includes/sessions.php");
	include("../includes/functions.php");
	include("../includes/dbconnection.php");
	confirm_logged_in();
?>
<?php	
	$address = $_GET['address'];
	$address = str_replace(" ", "-", $address);
	$fileName = 'images/listings/'. $address;
	chmod($fileName, 0777);
	echo $fileName;
	//print_r(scandir($fileName));
	$files = scandir($fileName);
	//unlink($filename."download.jpg");
	foreach (glob($fileName . '/*') as $value) {
		echo($value);
		chmod($value, 0777);
		unlink($value);
	}
	rmdir($fileName);
	$id =  $_GET['id']; 

	$query  = "DELETE FROM images ";
	$query .= "WHERE listingID = {$id} ";

	$result = mysqli_query($db, $query);

	$query  = "DELETE FROM listings ";
	$query .= "WHERE id = {$id} ";
	$query .= "LIMIT 1";

	$result = mysqli_query($db, $query);

	if ($result && mysqli_affected_rows($db) == 1) {
		// Success

		$_SESSION["message"] = "Listing Deleted";
		redirect_to("listings.php?type=" . $_GET['type']);
		
	} else {
		// Failure
		$message = "Subject delete failed";
		die("Database this query failed. ". $_LISTINGID ." " . mysqli_error($db));
	}
		if(isset($db)){
			mysqli_close($db);
		};
?>