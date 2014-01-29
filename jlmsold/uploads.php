<?php 
	include("../includes/functions.php");
	include("../includes/header.php");
// if (isset($_POST['submit'])) {
// 	$allowedExts = array("gif", "jpeg", "jpg", "png");
// 	$temp = explode(".", $_FILES["file"]["name"]);
// 	$extension = end($temp);
// 	if ((($_FILES["file"]["type"] == "image/gif")
// 	|| ($_FILES["file"]["type"] == "image/jpeg")
// 	|| ($_FILES["file"]["type"] == "image/jpg")
// 	|| ($_FILES["file"]["type"] == "image/pjpeg")
// 	|| ($_FILES["file"]["type"] == "image/x-png")
// 	|| ($_FILES["file"]["type"] == "image/png"))
// 	&& ($_FILES["file"]["size"] < 20000)
// 	&& in_array($extension, $allowedExts)){
// 		if ($_FILES["file"]["error"] > 0){
// 			echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
// 		}else{
// 			echo "Upload: " . $_FILES["file"]["name"] . "<br>";
// 			echo "Type: " . $_FILES["file"]["type"] . "<br>";
// 			echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
// 			echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
// 			if (file_exists("images/listings/" .$_FILES["file"]["name"])){
// 				echo $_FILES["file"]["name"] . " already exists. ";
// 			}else{
// 				move_uploaded_file($_FILES["file"]["tmp_name"],
// 				"images/listings/" . $_FILES["file"]["name"]);
// 				echo "Stored in: " . "images/listings/" . $_FILES["file"]["name"];
// 			}
// 		}
// 	}else{
// 		echo "Invalid file";
// 	}
// }
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
				    <form action="uploads.php" method="POST" enctype="multipart/form-data">
				    <?php moveFromDB(); ?>
						<p>Main Image:<input type="file" name="file" id='image' ></p>
						<input type="submit" name="submit" value="Submit" />
				    </form>
			</fieldset>
			
		</div>	
	</div>
<!-- content end -->
 <?php include("../includes/footer.php"); ?>