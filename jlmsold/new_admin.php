<?php include("../includes/sessions.php"); ?>
<?php include("../includes/functions.php"); ?>
<?php include("../includes/dbconnection.php"); ?>
<?php include("../includes/validation_functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php
if (isset($_POST['submit'])) {
  // Process the form
  
  // validations
  // $required_fields = array("username", "password");
  // validate_presences($required_fields);
  
  // $fields_with_max_lengths = array("username" => 30);
  // validate_max_lengths($fields_with_max_lengths);
  
  //if (empty($errors)) {
    // Perform Create

    $username = $_POST["username"];
    $hashed_password = password_encrypt($_POST["password"], PASSWORD_DEFAULT);
    
    $query  = "INSERT INTO admins (";
    $query .= "  username, password";
    $query .= ") VALUES (";
    $query .= "  '{$username}', '{$hashed_password}'";
    $query .= ")";
    $result = mysqli_query($db, $query);

    if ($result) {
      // Success
      $_SESSION["message"] = "Admin created.";
      redirect_to("manage_admins.php");
    } else {
      // Failure
      $_SESSION["message"] = "Admin creation failed.";
    }
  //}
//} else {
  // This is probably a GET request
  
} // end: if (isset($_POST['submit']))

?>


<?php
	$layout = "admin"; 
	include("../includes/header.php");
 ?>





<!-- content -->
	<div data-role="content">
		<?php
			if($layout == "admin"){
				echo "<div class=\"manageMenu\"><ul><li><a href=\"new_listing.php\">New Listing</a></li><li><a href=\"logout.php\">Logout</a></li><li><a href=\"admin.php\">&laquo; Main Menu</a></li></ul></div>";
			}

			?>
		<div id="scrollingbanner">
			<fieldset class="banner">
				<?php echo message(); ?>
				<?php echo form_errors($errors); ?>
				<h2>Create Admin</h2>
				    <form action="new_admin.php" method="post">
						<p>Username:
							<input type="text" name="username" value="" />
						</p>
						<p>Password:
							<input type="password" name="password" value="" />
						</p>
						<input type="submit" name="submit" value="submit" />
					</form>
					<br />
					<a href="manage_admins.php">Cancel</a>
			</fieldset>
		</div>	
	</div>
<!-- content end -->

			
<?php include("../includes/footer.php"); ?>