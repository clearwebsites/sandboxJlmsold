<?php include("../includes/sessions.php"); ?>
<?php include("../includes/functions.php"); ?>
<?php include("../includes/dbconnection.php"); ?>
<?php include("../includes/validation_functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php
	$layout = "admin"; 
	include("../includes/header.php");
 ?>

<?php 
if (isset($_POST['submit'])) {
	$id = $_GET['id'];
	$address = mysql_prep($_GET["address"]);
	$addressFile = str_replace(" ", "-", $address);
	$fileName = str_replace(" ", "-", $_FILES['file']['name']);
	$allowedExts = array("gif", "jpeg", "jpg","JPG", "png");
	$temp = explode(".", $_FILES["file"]["name"]);
	$extension = end($temp);
	//$file = "images/listings/".$addressFile."/" .$fileName;
	if ((($_FILES["file"]["type"] == "image/gif")
	|| ($_FILES["file"]["type"] == "image/jpeg")
	|| ($_FILES["file"]["type"] == "image/jpg")
	|| ($_FILES["file"]["type"] == "image/JPG")
	|| ($_FILES["file"]["type"] == "image/pjpeg")
	|| ($_FILES["file"]["type"] == "image/x-png")
	|| ($_FILES["file"]["type"] == "image/png"))
	&& ($_FILES["file"]["size"] < 5000000)
	&& in_array($extension, $allowedExts)){
		if ($_FILES["file"]["error"] > 0){
			//echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
		}else{
			// echo "Upload: " . $fileName . "<br>";
			// echo "Type: " . $_FILES["file"]["type"] . "<br>";
			// echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
			// echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
			if (file_exists("images/listings/".$addressFile."/" .$fileName)){
				$exists;
				$_SESSION['errors'] = $_FILES["file"]["name"] . " already exists. ";
			}else{
				mkdir("images/listings/".$addressFile."/",0777);

				move_uploaded_file($_FILES["file"]["tmp_name"],
				"images/listings/".$addressFile."/" . $fileName);
				//echo "Stored in: " . "images/listings/".$addressFile."/" . $fileName;
				$image="images/listings/".$addressFile."/" .$fileName;
				$final_image = scaleImageFileToBlob($image,$image);
				//$final_image = base64_encode($final_image);
			}
		}
	}else{
	}

	$query  = "INSERT INTO images (";
    $query .= "listingID, listingAddress,  fileLocation ";
    $query .= " ) VALUES (";
    $query .= " {$id}, '{$address}', '{$image}' ";
    $query .= " )";

	if(isset($final_image)){
		$result = mysqli_query($db, $query);
		if ($result){
			$_SESSION["message"] =$image. " photo saved.";
			redirect_to("addPhotos.php?id=".$id."&address=".$address);
		}else{
			$_SESSION["message"] = "Photo save failed.";
			redirect_to("addPhotos.php?id=".$id."&address=".$address);
    	}
	}else{
		$_SESSION["message"] = "Photo save failed.";
		redirect_to("addPhotos.php?id=".$id."&address=".$address);
	}
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
				<?php echo errors(); ?>
				<h2>Add Photos To: <?php echo htmlentities($_GET['address']); ?></h2>
					<form action="addPhotos.php?id=<?php echo urlencode($_GET['id']); ?>&address=<?php echo urlencode($_GET['address']); ?>" method="post" enctype="multipart/form-data">
			  <ul class="image">
			  
				<li><input type="file" name="file" id="file"></li>
			  </ul>
			  
			  
			  
			  
			  <?php  ?>
						
						<input type="submit" name="submit" value="submit" class="submit" />
					</form>
					<br />
			</fieldset>
		</div>	
	</div>
<!-- content end -->

			
<?php include("../includes/footer.php"); ?>