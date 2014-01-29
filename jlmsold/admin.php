<?php 
	include("../includes/sessions.php");
	include("../includes/functions.php");
	include("../includes/header.php");
	include("../includes/dbconnection.php");
	confirm_logged_in();
 ?>
<?php 
	//perfom db query
	$query = "SELECT * FROM listings WHERE status = 0 ";
	$result = mysqli_query($db, $query);
	//test if there was a query error
	if (!$result) {
		die("Database query failed");
	}



 ?>



<!-- content -->
	<div data-role="content">
		
		<div id="scrollingbanner">
			
			<fieldset class="banner">
				<?php echo message(); ?>
				<div class="adminMenu">
				<h2><?php 
						echo htmlentities($_SESSION["username"]); 
				?></h2>
				<ul>

					<li><a href="new_listing.php">+ Add New Listing</a></li>
					<li><a href="manage_admins.php">Manage Users</a></li>
					<li><a href="logout.php">Logout</a></li>

					<h3>Review and Edit</h3>
					<ul>
						<li><a href="listings.php?type=residential" class="residential">Residential</a></li>
						<li><a href="listings.php?type=farm/ranches" id="land">Farm/Ranches</a></li>
						<li><a href="listings.php?type=commercial" id="commercial">Commercial</a></li>
						<li><a href="listings.php?type=lake" id="lake">Lake</a></li>
					</ul>
				</ul> 
			</div>
			</fieldset>
			

		</div>
		
		
	</div>
<!-- content end -->

			
<?php include("../includes/footer.php"); ?>