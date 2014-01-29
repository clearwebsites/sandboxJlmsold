<?php
	include("../includes/sessions.php");
	include("../includes/functions.php");
	include("../includes/header.php");
	include("../includes/dbconnection.php");
	ob_start();

?>
<?php 
	if(isset($_SESSION['admin_id'])) {
		$layout = "admin";
	}else{
		$layout = "public";
	}
 ?>
<?php 




 ?>



<!-- content -->
	<div data-role="content">
		<!-- needs user auth to hide and display -->
		<?php
			if($layout == "admin"){
				echo "<div class=\"manageMenu\"><ul><li><a href=\"new_listing.php\">New Listing</a></li><li><a href=\"logout.php\">Logout</a></li><li><a href=\"admin.php\">&laquo; Main Menu</a></li></ul></div>";
			}

			?>
		<div id="lists">
			<?php echo message(); ?>

			<?php 
				// 3 use returned data if any
				//perfom db query
				$type = $_GET['type'];
				$query = "SELECT * FROM listings ";
				$query .= "WHERE type = '$type' ";
					if($layout == "public"){ 
						$query .= "AND visible = 1 ";
					}
				$query .= "ORDER BY price DESC ";
				$result = mysqli_query($db, $query);
				//test if there was a query error
				confirm_query($result);
				while ($row =  mysqli_fetch_assoc($result))  {
					$id= $row["id"];
					$address = $row["address"];
					$city = $row["city"];
					$county = $row["county"];
					$price = number_format($row["price"]);
					$bedrooms = $row["bedrooms"];
					$bathrooms = $row["bathrooms"];
					$schools = $row["school_dist"];
					$sq_ft = $row["sq_ft"];
					$lot = $row["lot_size"];
					$year = $row["year_built"];
					$hoa = $row["hoa"];
					$taxes = $row["taxes"];
					$status = $row["status"];
					$perAc = $row['perAc'];
					$visible = $row['visible'];
					$img=$row['imageLocation'];
					
				?>

				<a href="property.php?type=<?php echo urlencode($type)?>&id=<?php echo urlencode($id) ?>" class="location" >
				<div class="listview">
					<fieldset class="lists" >
						<?php 
							if ($img == null){
								?><img src="images/noPhoto.jpg" class="thumb">
						<?php	}else{
								 ?> <img src="<?php echo $img; ?>" class="thumb">
						<?php
							}
						 ?>
						
						<ul class="listItem">
							<?php if($status == 0){ echo "<li> <p id='soldlist'>SOLD!</p> -".$address. ", ". $city." </li>";}else if($_GET['type']== 'farm/ranches' && $perAc == 1){ echo "<li> $" . $price."/ac" . "- ".$address. ", ". $city."</li>"; } else{ echo "<li> $" . $price . "- ".$address. ", ". $city."</li>";} ?>
							<ul class="listDesc">
								<!-- farm/ranch extra info -->
								<?php	if($_GET['type']== 'farm/ranches'){ echo "<li> " ."</li>";  } ?>
								<?php	if($_GET['type']== 'farm/ranches'){ echo "<li> " ."</li>";  } ?>
								<!-- farm/ranch extra info -->
								<?php if($bedrooms != null){ echo "<li >Bedrooms: ". $bedrooms . "</li>"; }else{ echo " ";}; ?> 
								<?php if($bathrooms != null){ echo  "<li > Bathrooms: " . $bathrooms . "</li>"; }else{ echo " ";}; ?> 
								<?php if($schools != null){ echo "<li > School District: " . $schools . "</li>"; }else{ echo " ";}; ?> 
								<?php if($sq_ft != null){ echo "<li >" . $sq_ft . " Sq. Ft.</li>"; }else{ echo " ";}; ?> 
								
								<?php
									if($visible == 1 ){
										$visible = "visible";
									}else{
										$visible = " Not Visible";
									}
									if($layout == 'admin'){
										echo "<p class='usrEdit'>Click to edit listing.</p>"." ". $visible;
									}
								?>

						</ul>

					</fieldset>
				</div>
				</a>

			<?php

				};
			?>
			
			 
			
		</div>

		<?php ob_flush(); ?>
	</div>
<!-- content end -->
<?php include("../includes/footer.php"); ?>
