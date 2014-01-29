<?php
	//ob_start();
	include("../includes/sessions.php");
	include("../includes/functions.php");
	include("../includes/header.php");
	include("../includes/dbconnection.php");
	require_once("../includes/validation_functions.php"); 
    
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
	  //ob_end_flush();
      redirect_to("admin.php");
    } else {
      // Failure
      $_SESSION["message"] = "Username/password not found.";
    }
  }
} else {
  // This is probably a GET request
  
} // end: if (isset($_POST['submit']))

?>



<!-- content -->
	<div data-role="content">
		<div id="scrollingbanner">
			<fieldset class="banner">
				<h2>Login</h2>
					<form action="login.php" method="post">
						<?php echo message(); ?>
						<?php echo form_errors($errors); ?>
						<p>Username:
							<input type="text" name="username" value="" />
						</p>
						<p>Password:
							<input type="password" name="password" value="" />
						</p>
						<input type="submit" name="submit" value="Submit" />
					</form>
			</fieldset>
		</div>	
	</div>
<!-- content end -->

			
<?php include("../includes/footer.php"); ?>