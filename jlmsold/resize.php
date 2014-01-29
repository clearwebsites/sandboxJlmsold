<!DOCTYPE html>
<html lang="en">
	<head>
		<title>php project</title>
	</head>
	<body>
		<!-- content -->
<?php
if(isset($_POST['Submit'])) {
	$image=$_FILES['file']['name'];
	$temp=resizeImage($_FILES['file']['tmp_name'],512,384);
    $imgfile=$image;
	imagejpeg ( $temp, $null, 20 );
 }else{
}
function resizeImage($imgSrc,$thumbnail_width,$thumbnail_height) { //$imgSrc is a FILE - Returns an image resource.
    //getting the image dimensions  
    list($width_orig, $height_orig) = getimagesize($imgSrc);  
    echo  getimagesize($imgSrc);
    $myImage = imagecreatefromjpeg($imgSrc);
    $ratio_orig = $width_orig/$height_orig;
      
    if ($thumbnail_width/$thumbnail_height > $ratio_orig) {
       $new_height = $thumbnail_width/$ratio_orig;
       $new_width = $thumbnail_width;
    } else {
       $new_width = $thumbnail_height*$ratio_orig;
       $new_height = $thumbnail_height;
    }
      
    $x_mid = $new_width/2;  //horizontal middle
    $y_mid = $new_height/2; //vertical middle
      
    $process = imagecreatetruecolor(round($new_width), round($new_height)); 
      
    imagecopyresampled($process, $myImage, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig);
    $thumb = imagecreatetruecolor($thumbnail_width, $thumbnail_height); 
    imagecopyresampled($thumb, $process, 0, 0, ($x_mid-($thumbnail_width/2)), ($y_mid-($thumbnail_height/2)), $thumbnail_width, $thumbnail_height, $thumbnail_width, $thumbnail_height);
  
    imagedestroy($process);
    imagedestroy($myImage);
    return $thumb;
}
 ?>
  
 <!--next comes the form, you must set the enctype to "multipart/frm-data" and use an input type "file" -->
 <form name="newad" method="post" enctype="multipart/form-data"  action="">
 <table>
    <tr><td><input type="file" name="file"></td></tr>
    <tr><td><input name="Submit" type="submit" value="Upload image"></td></tr>
 </table> 
 </form>

<!-- content end -->
		
	</body>

</html?