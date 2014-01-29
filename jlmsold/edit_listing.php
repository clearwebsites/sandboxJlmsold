<?php
	include("../includes/sessions.php");
	include("../includes/functions.php"); 
	include("../includes/header.php");
	include("../includes/dbconnection.php");
	confirm_logged_in();
 ?>
<?php 	
if (isset($_POST['submit'])) {
	$id=$_GET['id'];
	$type= mysql_prep($_POST["type"]);
	$address = mysql_prep($_POST["address"]);
	$city = mysql_prep($_POST["city"]);
	$county = mysql_prep($_POST["county"]);
	$zip = $_POST["zip"];
	$region = mysql_prep($_POST["region"]);
	$price = $_POST["price"];
	$bedrooms = mysql_prep($_POST["bedrooms"]);
	$bathrooms = mysql_prep($_POST["bathrooms"]);
	$schools = mysql_prep($_POST["school_dist"]);
	$sq_ft = mysql_prep($_POST["sq_ft"]);
	$lot = mysql_prep($_POST["lot_size"]);
	$year = mysql_prep($_POST["year_built"]);
	$hoa = $_POST["hoa"];
	$taxes = mysql_prep($_POST["taxes"]);
	$status = $_POST["status"];
	$full_desc = mysql_prep($_POST["full_desc"]);
	$visible = $_POST["visible"];
	$perAc = $_POST["perAc"];
	$address = mysql_prep($_POST["address"]);
	$addressFile = str_replace(" ", "-", $address);
	$fileName = str_replace(" ", "-", $_FILES['file']['name']);
	$allowedExts = array("gif", "jpeg", "jpg","JPG", "png");
	$temp = explode(".", $_FILES["file"]["name"]);
	$extension = end($temp);
	if ((($_FILES["file"]["type"] == "image/gif")
	|| ($_FILES["file"]["type"] == "image/jpeg")
	|| ($_FILES["file"]["type"] == "image/jpg")
	|| ($_FILES["file"]["type"] == "image/JPG")
	|| ($_FILES["file"]["type"] == "image/pjpeg")
	|| ($_FILES["file"]["type"] == "image/x-png")
	|| ($_FILES["file"]["type"] == "image/png"))
	&& ($_FILES["file"]["size"] < 5000000)
	&& in_array($extension, $allowedExts)){
		$invalid = "";
		if ($_FILES["file"]["error"] > 0){
			//echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
		}else{
			$upload = $fileName;
			$imagetype = $_FILES["file"]["type"];
			$size = ($_FILES["file"]["size"] / 1024) . " kB";
			// echo "Upload: " . $fileName . "<br>";
			// echo "Type: " . $_FILES["file"]["type"] . "<br>";
			// echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
			// echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
			if (file_exists("images/listings/".$addressFile."/" .$fileName)){
				$errors =  $_FILES["file"]["name"] . " already exists. ";
				$image="images/listings/".$addressFile."/" .$fileName;
				$invalid = 'invalid';
			}else{
				if(file_exists("images/listings/".$addressFile."/")){
					//echo 'file exist';
				}else{
					mkdir("images/listings/".$addressFile."/");
				}
				move_uploaded_file($_FILES["file"]["tmp_name"],
				"images/listings/".$addressFile."/" . $fileName);
				$errors = "Image ".$addressFile."/". $fileName . " Image was Saved properly.";
				$image="images/listings/".$addressFile."/" .$fileName;
				$final_image = scaleImageFileToBlob($image,$image);
			}
		}
	}else{
		if($_FILES['file']['tmp_name']){
			$errors = "File Possibly to Large must be smaller then 5Megabites(5MB).";
		}else{
			$errors = "No photo was submitted.";
		}
	}

		

		$query  = "UPDATE listings SET ";
		$query .= "type = '{$type}', address = '{$address}', city = '{$city}', county = '{$county}', zip = {$zip}, region = '{$region}', price = {$price}, ";
		$query .= "bedrooms = '{$bedrooms}', bathrooms = '{$bathrooms}', school_dist = '{$schools}', sq_ft = '{$sq_ft}',lot_size = '{$lot}', ";
		$query .= "year_built = '{$year}', hoa = '{$hoa}', taxes = '{$taxes}', status = {$status}, full_desc = '{$full_desc}', visible = '{$visible}', perAc = '{$perAc}' ";
		if(isset($image)){
			//echo 'image var set';
			$query .= ", imageLocation = '${image}' ";
		}else{
			if(file_exists("images/listings/".$addressFile."/")){

			}else{
				$image= "images/nophoto.jpg";
				$query .= ", imageLocation = '${image}' ";
			}
		}
		$query .= " WHERE id = {$id} ";
		$query .= "LIMIT 1 ";
		if(isset($image)){
			$result = mysqli_query($db, $query);
		}else{
			if(file_exists("images/listings/".$addressFile."/")){
				$result = mysqli_query($db, $query);
			}else{
			$result= null;
			}
		}
		if ($result && mysqli_affected_rows($db) >= 0 ){
			$changed = "All Changes Saved.";
		}else{
			$errors = "Nothing was changed or there was an error.".mysqli_error($db);
		}

}else{
	
}

 ?>

<?php 
	$query = "SELECT * FROM listings WHERE id = '$_GET[id]'";
	$result = mysqli_query($db, $query);
	
			
 ?>



<!-- content -->
	<div data-role="content">
		<div class="manageMenu">
				<ul>
					<li><a href="new_listing.php">New Listing</a></li>
					<li><a href="index.php">Logout</a></li>
					<li><a href="admin.php">&laquo; Main Menu</a></li>
				</ul> 
			</div>
		
		<div >
			<fieldset class="form">
				<h2>New Listing</h2>
				    <form action="edit_listing.php?id=<?php echo urlencode($_GET['id']); ?>&type=<?php echo urlencode($_GET['type']); ?>" method="POST" enctype="multipart/form-data">

				    	<?php 

				    		while ($row =  mysqli_fetch_assoc($result)) {
				    			$id=$row["id"];
								$type = $row["type"];
								$address = $row["address"];
								$city = $row["city"];
								$county = $row["county"];
								$zip = $row["zip"];
								$region = $row["region"];
								$price = $row["price"];
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
								// $img = base64_encode( $row['image'] );
								$visible = $row["visible"];
								$perAc = $row["perAc"];
							
								
						?>

				    	<p>* = Required Fields</p><p class="errors"><?php if(isset($errors)){ echo $errors; } ?></p><p class="changes"><?php if(isset($changed)){ echo $changed; } ?></p>
				    	<input  type="text" name="id" value="<?php echo $id; ?>" hidden />
				    	<p>Type:
							<select name="type" id="type" data-role="slider">
								<option value="residential" <?php if($type == 'residential'){ echo 'selected';} ?>>Residential</option>
								<option value="commercial" <?php if($type == 'commercial'){ echo 'selected';} ?>>Commercial</option>
								<option value="farm/ranches" <?php if($type == 'farm/ranches'){ echo 'selected';} ?>>Farm/Ranches</option>
								<option value="lake"<?php if($type == 'lake'){ echo 'selected';} ?>>Lake</option>
							</select>
						</p> 
						<p>Address*:
							<input type="text" name="address" value="<?php echo $address; ?>" />
						</p>
						<p>City*:
							<input type="text" name="city" value="<?php echo $city; ?>" />
						</p>
						<p>County*:
							<input type="text" name="county" value="<?php echo $county; ?>" />
						</p>
						<p>Zip:
							<input type="text" name="zip" value="<?php echo $zip; ?>" />
						</p>
						<p>Region:
							<input type="text" name="region" value="<?php echo $region; ?>" />
						</p>
						<p>Price*:
							<input type="text" name="price" value="<?php echo $price; ?>" />
						</p>
						<p>Bedrooms:
							<input type="text" name="bedrooms" value="<?php echo $bedrooms; ?>" />
						</p>
						<p>bathrooms:
							<input type="text" name="bathrooms" value="<?php echo $bathrooms; ?>" />
						</p>
						<p>School District:
							<input type="text" name="school_dist" value="<?php echo $schools; ?>" />
						</p>
						<p>Sq. Ft.:
							<input type="text" name="sq_ft" value="<?php echo $sq_ft; ?>" />
						</p>
						<p>Lot Size:
							<input type="text" name="lot_size" value="<?php echo $lot; ?>" />
						</p>
						<p>Year Built:
							<input type="text" name="year_built" value="<?php $year; ?>" />
						</p>
						
						<p>Taxes:
							<input type="text" name="taxes" value="<?php echo $taxes; ?>" />
						</p>
						<p>hoa:
							<select name="hoa" id="status" data-role="slider">
								<?php  
									if($hoa == 0){
										echo "<option value='0' selected >No</option><option value='1'>Yes</option>";
									}else{
										echo "<option value='0' >No</option><option value='1' selected >Yes</option>";
									}
								?>
								
							</select>
						</p>
						<p>Full Description*:
							<textarea name="full_desc" placeholder="Full Description of Property listing." rows="10" cols="75"><?php echo $full_desc ?></textarea>
						</p>
						<p>*Main Image:<input type="file" name="file" id='image' ></p>
						<p>Status:
							<select name="status" id="status" data-role="slider">
								<option value="1" <?php if($status == 1){ echo 'selected'; } ?>>Open</option>
								<option value="0" <?php if($status == 0){ echo 'selected'; } ?>>Sold</option>
							</select>
						</p>
						<p>visible:
							<select name="visible" id="visible" data-role="slider">
								<option value="0" <?php if($visible == 0){ echo 'selected'; } ?>>No</option>
								<option value="1" <?php if($visible == 1){ echo 'selected'; } ?> >Yes</option>
								
							</select>
						</p>
						<p>Per Acre:
							<select name="perAc" id="perAc" >
								<option value="0" <?php if($perAc == 0){ echo 'selected'; } ?>>No</option>
								<option value="1" <?php if($perAc == 1){ echo 'selected'; } ?>>Yes</option>
								
							</select>
						</p>
						
						<input type="submit" name="submit" value="Submit" />
 						<a href="property.php?id=<?php echo urlencode($_GET['id']); ?>">Cancel</a>
						<?php };?>
				    </form>
			</fieldset>
			
		</div>	
	</div>
<!-- content end -->

			
<?php include("../includes/footer.php"); ?>