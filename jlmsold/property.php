<?php
	include("../includes/sessions.php");
	include("../includes/functions.php");
	include("../includes/header.php");
	include("../includes/dbconnection.php");
?>
<?php 
	if(isset($_SESSION['admin_id'])) {
		$layout = "admin";
	}else{
		$layout = "public";
	}
 ?>
<!-- content -->
	<div data-role="content" id="content">
		<!-- needs user auth to hide and display -->
		<?php
			if($layout == "admin"){
				echo "<div class=\"manageMenu\"><ul><li><a href=\"new_listing.php\">New Listing</a></li><li><a href=\"logout.php\">Logout</a></li><li><a href=\"admin.php\">&laquo; Main Menu</a></li></ul></div>";
			}

			?> 
		<div id="lists">

			<?php 
				// 3 use returned data if any
				$query = "SELECT * FROM listings ";
				$query .= "WHERE id = '$_GET[id]' ";
					if($layout == "public"){ 
						$query .= "AND visible = 1 ";
					}
				$result = mysqli_query($db, $query);
				//test if there was a query error
				confirm_query($result);
				while ($row =  mysqli_fetch_assoc($result)) {
					$type = $row["type"];
					$address = $row["address"];
					$city = $row["city"];
					$county = $row["county"];
					$zip = $row["zip"];
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
					$full_desc = $row["full_desc"];
					$img = $row["imageLocation"];
					$perAc = $row["perAc"];
					$visible = $row['visible']		
			?>		
		</div>
		<div id="itemInfo">			
			<fieldset id="descImg">
				<a href="listings.php?type=<?php echo urlencode($type) ?> " class='back'>Back</a>&nbsp;|
				<a title="Print Screen" alt="Print Screen" onclick="window.print();" target="_blank" style="cursor:pointer;" media="print" class="print">&nbsp;Print</a>
						<div class="fotorama" >
								<?php 
										if ($img == null){
											 ?><img src="images/noPhoto.jpg"  class="descImg" width="600px" height= "340px">
								<?php	}else{ ?> 
											<img src="<?php echo $img; ?>" class="descImg" >	 
									<?php
										};
									 ?>
							<?php find_all_imagesIE($_GET['id']); ?>
						</div>
			</fieldset>
			<fieldset id="descList">
				<?php if($zip == 0){ $zip = "Zip: N/A";} ?>
				<?php if($status == 0){ echo "<h3 id='listingTitle'>" . $address . ", " . $city . " - <p id='sold'>SOLD!</p> </h3>";}else if( $type == 'farm/ranches' && $perAc == 1){ echo "<h3 id='listingTitle'>" . $address . ", " . $city . " - $" . $price."/ac</h3>"; }else{ echo "<h3 id='listingTitle'>" . $address . ", " . $city . " - $" . $price."</h3>"; } ?>
				<ul class="listDesc">
					<?php if($bedrooms != null){ echo "<li >Bedrooms: ". $bedrooms . "</li>"; }else{ echo " ";}; ?> 
					<?php if($bathrooms != null){ echo  "<li > Bathrooms: " . $bathrooms . "</li>"; }else{ echo " ";}; ?> 
					<?php if($schools != null){ echo "<li > School District: " . $schools . "</li>"; }else{ echo " ";}; ?> 
				</ul>
				<ul class="listDesc">	
					<?php if($county != null){ echo "<li >County: ". $county . ", ".$zip. "</li>"; }else{ echo " ";}; ?> 
					<?php if($sq_ft != null){ echo "<li >Sq. Ft.- " . $sq_ft . " Sq. Ft.</li>"; }else{ echo " ";}; ?> 
					<?php if($lot != null){ echo "<li > Lot Size: " . $lot . "  </li>"; }else{ echo " ";}; ?> 
				
				</ul>
				<ul class="listDesc">
					<?php if($year != null){ echo "<li > Year Built: " . $year . " </li>"; }else{ echo " ";}; ?> 
					<?php if($hoa == 1){ echo "<li >HOA: Yes </li>"; }else{ echo "<li>HOA: No</li> ";}; ?> 
					<?php if($taxes != null ){ echo  "<li > Taxes: " . $taxes . "</li>"; }else{ echo "<li> Taxes: N/A</li>";}; ?> 
				</ul> 
				<p class="desc"><?php echo $full_desc ?> </p>

				<!-- this needs php if user isset adn logged in -->
				<ul class="print">
					<?php
						if($visible == 1 ){
							$visible = "VIEWABLE";
						}else{
							$visible = " NOT VIEWABLE";
						}
						if($layout == 'admin'){
							echo "<li><a href=\"delete_listing.php?id=";
							echo urlencode($_GET['id']);
							echo "& type=";
							echo urlencode($type);
							echo "& address=";
							echo urlencode($address);
							echo " \"class=\"delete\" onclick=\"return confirm('This Can Not Be Undone. If you want to keep this listing and not delete it choose cancel and make it NONVISIBLE in the edit options instead.')\">Delete</a> &nbsp| &nbsp<a href=\"edit_listing.php?id=";
							echo urlencode($_GET['id']);
							echo "&type=";
							echo urlencode($type);
							/*echo "&address=";
							echo urlencode($_GET['address']);*/
							echo " \"class=\"edit\">Edit</a>&nbsp| &nbsp<a href=\"addPhotos.php?id=";
							echo urlencode($_GET['id']);
							echo "&address=";
							echo urlencode($address);
							echo "\" class=\"addPhotos\">Add Photos</a>&nbsp| &nbsp" . $visible ."</li>";
						}
						
		
					?>
				</ul>
				
			</fieldset>
		</div>
		<?php 
				};
			 ?>
	</div>
<!-- content end -->
<?php include("../includes/footer.php"); ?>
