<?php include("../includes/sessions.php"); ?>
<?php include("../includes/functions.php"); ?>
<?php include("../includes/dbconnection.php"); ?>
<?php include("../includes/validation_functions.php"); ?>
<?php confirm_logged_in(); ?>

<?php
  $admin = find_admin_by_id($_GET["id"]);
  
  if (!$admin) {
    // admin ID was missing or invalid or 
    // admin couldn't be found in database
    redirect_to("manage_admins.php");
  }
?>
<?php
if (isset($_POST['submit'])) {
  // Process the form
  
  // validations
  // $required_fields = array("username", "password");
  // validate_presences($required_fields);
  
  // $fields_with_max_lengths = array("username" => 30);
  // validate_max_lengths($fields_with_max_lengths);
  
  if (empty($errors)) {
    
    // Perform Update

    $id = $admin["id"];
    $username = mysql_prep($_POST["username"]);
    $hashed_password = password_encrypt($_POST["password"]);
  
    $query  = "UPDATE admins SET ";
    $query .= "username = '{$username}', ";
    $query .= "password = '{$hashed_password}' ";
    $query .= "WHERE id = {$id} ";
    $query .= "LIMIT 1";
    $result = mysqli_query($db, $query);

    if ($result && mysqli_affected_rows($db) == 1) {
      // Success
      $_SESSION["message"] = "Admin updated.";
      redirect_to("manage_admins.php");
    } else {
      // Failure
      $_SESSION["message"] = "Admin update failed.";
    }
  
  }
}
  //}
//} else {
  // This is probably a GET request
  
 // end: if (isset($_POST['submit']))

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
				<h2>Edit Admin: <?php echo htmlentities($admin["username"]); ?></h2>
				    <form action="edit_admin.php?id=<?php echo urlencode($admin["id"]); ?>" method="post">
						<p>Username:
							<input type="text" name="username" value="<?php echo htmlentities($admin["username"]); ?>" />
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