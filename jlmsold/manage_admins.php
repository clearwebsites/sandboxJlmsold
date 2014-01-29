
<?php 
	include("../includes/sessions.php");
	include("../includes/functions.php");
	include("../includes/header.php");
	include("../includes/dbconnection.php");
	confirm_logged_in();
 ?>
<?php 
	if(!isset($layout)){
		$layout = "admin"; 
	}
?>
<?php 
	//perfom db query
	$query = "SELECT * FROM admins ";
	$result = mysqli_query($db, $query);
	//test if there was a query error
	if (!$result) {
		die("Database query failed");
	}
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
				<h2>Manage Users</h2>
				<table>
			      <tr>
			        <th style="text-align: left; width: 200px;">Username</th>
			        <th colspan="2" style="text-align: left;">Actions</th>
			      </tr>
				<?php
					while ($row =  mysqli_fetch_assoc($result))  {
						$id = $row['id'];
						$usr =$row['username'];

				?>
				
			      <tr>
			        <td><?php echo htmlentities($usr); ?></td>
			        <td><a href="edit_admin.php?id=<?php echo urlencode($id); ?>" >Edit</a></td>
			        <td><a href="delete_admin.php?id=<?php echo urlencode($id); ?>" onclick="return confirm('Are you sure? This Cannot Be Undone.');" >Delete</a></td>
			      </tr>
			    <?php } ?>
			    </table>
			    <br/>
				 <a href="new_admin.php">Create Admin</a>
			</fieldset>
		</div>	
	</div>
<!-- content end -->

			
<?php include("../includes/footer.php"); ?>