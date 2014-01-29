<?php
	include("../includes/sessions.php");
	include("../includes/functions.php");
	include("../includes/dbconnection.php");
	confirm_logged_in();
?> 
<?php 
//define a maxim size for the uploaded images in Kb
 define ("MAX_SIZE","10000"); 
  
//This function reads the extension of the file. It is used to determine if the file  is an image by checking the extension.
 function getExtension($str) {
		 $i = strrpos($str,".");
		 if (!$i) { return ""; }
		 $l = strlen($str) - $i;
		 $ext = substr($str,$i+1,$l);
		 return $ext;
 }
  
//This variable is used as a flag. The value is initialized with 0 (meaning no error  found)  
//and it will be changed to 1 if an errro occures.  
//If the error occures the file will not be uploaded.
 $errors=0;
//checks if the form has been submitted
if(isset($_POST['Submit'])){
	//reads the name of the file the user submitted for uploading
	$image=$_FILES['image']['name'];
	//if it is not empty
	if ($image) {
	//get the original name of the file from the clients machine
		$filename = stripslashes($_FILES['image']['name']);
	//get the extension of the file in a lower case format
		$extension = getExtension($filename);
		$extension = strtolower($extension);
	//if it is not a known extension, we will suppose it is an error and will not  upload the file,  
	//otherwise we will do more tests
		if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
			//print error message
				echo '<h1>Unknown extension!</h1>';
				$errors=1;
		}else{
			//get the size of the image in bytes
			//$_FILES['image']['tmp_name'] is the temporary filename of the file
			//in which the uploaded file was stored on the server
			$size=filesize($_FILES['image']['tmp_name']);
			//compare the size with the maxim size we defined and print error if bigger
			if ($size > MAX_SIZE*1024){
				echo '<h1>You have exceeded the size limit!</h1>';
				echo "Type: " . $_FILES["image"]["type"] . "<br>";
				echo "Size: " . $_FILES["image"]["size"] . " kB<br>";
				echo "Temp file: " . $_FILES["image"]["tmp_name"] . "<br>";
				$errors=1;
			}else{
			//the new name will be containing the full path where will be stored (images folder)
			$temp=resizeImage($_FILES['image']['tmp_name'],512,384);
			$imgfile="upload/".$image;
			imagejpeg ( $temp, null, 20 );
			}
		}
	}else{
		echo "<h1>Select Image File</h1>";
		$errors=1;
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
	$image = null;

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