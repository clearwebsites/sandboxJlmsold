<?php 
	include("../includes/sessions.php");
	include("../includes/functions.php");
	include("../includes/header.php");
	include("../includes/dbconnection.php");
	require_once("../includes/validation_functions.php"); 
	ob_start();
 ?>
<?php 
	$username = "";
	//perfom db query
	// $query = "SELECT * FROM admins ";
	// $result = mysqli_query($db, $query);
	//test if there was a query error
	// if (!$result) {
	// 	die("Database query failed");
	// }
 ?>
<?php
$username = "";

if (isset($_POST['submit'])) {
  // Process the form
  
  // validations
  $required_fields = array("username", "password");
  validate_presences($required_fields);
  
  if (empty($errors)) {
    // Attempt Login

		$username = $_POST["username"];
		$password = $_POST["password"];
		
		$found_admin = attempt_login($username, $password);

    if ($found_admin) {
      // Success
			// Mark user as logged in
			$_SESSION["admin_id"] = $found_admin["id"];
			$_SESSION["username"] = $found_admin["username"];

      redirect_to("admin.php");
    } else {
      // Failure
      $_SESSION["message"] = "Username/password not found.";
    }
  }
} else {
  // This is probably a GET request
  
} // end: if (isset($_POST['submit']))
ob_end_clean();
?>