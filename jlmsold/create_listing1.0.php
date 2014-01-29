<?php
	include("../includes/sessions.php");
	include("../includes/functions.php");
	include("../includes/dbconnection.php");
	confirm_logged_in();
?> 
<?php
if (isset($_POST['submit'])) {
	$address = mysql_prep($_POST["address"]);
	$addressFile = str_replace(" ", "-", $address);
	$fileName = str_replace(" ", "-", $_FILES['file']['name']);
	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$temp = explode(".", $_FILES["file"]["name"]);
	$extension = end($temp);
	if ((($_FILES["file"]["type"] == "image/gif")
	|| ($_FILES["file"]["type"] == "image/jpeg")
	|| ($_FILES["file"]["type"] == "image/jpg")
	|| ($_FILES["file"]["type"] == "image/pjpeg")
	|| ($_FILES["file"]["type"] == "image/x-png")
	|| ($_FILES["file"]["type"] == "image/png"))
	&& ($_FILES["file"]["size"] < 20000)
	&& in_array($extension, $allowedExts)){
		if ($_FILES["file"]["error"] > 0){
			echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
		}else{
			echo "Upload: " . $fileName . "<br>";
			echo "Type: " . $_FILES["file"]["type"] . "<br>";
			echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
			echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
			if (file_exists("images/listings/".$addressFile."/" .$fileName)){
				echo $_FILES["file"]["name"] . " already exists. ";
			}else{
				mkdir("images/listings/".$addressFile."/");
				move_uploaded_file($_FILES["file"]["tmp_name"],
				"images/listings/".$addressFile."/" . $fileName);
				echo "Stored in: " . "images/listings/".$addressFile."/" . $fileName;
			}
		}
	}else{
		echo "Invalid file";
	}
}



if(isset($_POST['submit'])){
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
	$taxes = $_POST["taxes"];
	$status = $_POST["status"];
	$full_desc = mysql_prep($_POST["full_desc"]);
	$visible = $_POST["visible"];
	$perAc = $_POST["perAc"];
	$image = "images/listings/".$addressFile."/" $fileName;

	$query  = "INSERT INTO listings (";
	$query .= " type, address, city, county, zip, region, price, bedrooms, bathrooms, school_dist, sq_ft, lot_size, year_built, hoa, taxes, status, full_desc, imageLocation, visible, perAc ";
	$query .= ") VALUES (";
	$query .= " '{$type}', '{$address}', '{$city}', '{$county}', '{$zip}', '{$region}', '{$price}', '{$bedrooms}', '{$bathrooms}', '{$schools}', '{$sq_ft}', '{$lot}', '{$year}', '{$hoa}', '{$taxes}', '{$status}', '{$full_desc}', '{$image}', '{$visible}', {$perAc}" ;
	$query .= ")";

	$result = mysqli_query($db, $query);
	if ($result){
		$_SESSION["message"] = "Listing saved.";
		redirect_to("admin.php");
	}else{
		$_SESSION["message"] = "Missing Required Field/s. Failed to save new listing. Please make sure the required fields are not blank.";
		redirect_to('new_listing.php');
		
	}
}else{
	redirect_to("new_listing.php");
}



		if(isset($db)){
			mysqli_close($db);
		};
?>