<?php
//gitplus check 
// Access the $_FILES global variable for this specific file being uploaded
// and create local PHP variables from the $_FILES array of information
$fileName = $_FILES["uploaded_file"]["name"]; // The file name
$fileTmpLoc = $_FILES["uploaded_file"]["tmp_name"]; // File in the PHP tmp folder
$fileType = $_FILES["uploaded_file"]["type"]; // The type of file it is
$fileSize = $_FILES["uploaded_file"]["size"]; // File size in bytes
$fileErrorMsg = $_FILES["uploaded_file"]["error"]; // 0 for false... and 1 for true
$fileName = preg_replace('#[^a-z.0-9]#i', '', $fileName); // filter
$kaboom = explode(".", $fileName); // Split file name into an array using the dot
$fileExt = end($kaboom); // Now target the last array element to get the file extension

// START PHP Image Upload Error Handling -------------------------------
if (!$fileTmpLoc) { // if file not chosen
    echo "ERROR: Please browse for a file before clicking the upload button.";
    exit();
} else if($fileSize > 5242880) { // if file size is larger than 5 Megabytes
    echo "ERROR: Your file was larger than 5 Megabytes in size.";
    unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
    exit();
} else if (!preg_match("/.(gif|jpg|png)$/i", $fileName) ) {
     // This condition is only if you wish to allow uploading of specific file types
     echo "ERROR: Your image was not .gif, .jpg, or .png.";
     unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
     exit();
} else if ($fileErrorMsg == 1) { // if file upload error key is equal to 1
    echo "ERROR: An error occured while processing the file. Try again.";
    exit();
}
// END PHP Image Upload Error Handling ---------------------------------
// Place it into your "uploads" folder mow using the move_uploaded_file() function
$moveResult = move_uploaded_file($fileTmpLoc, "images/$fileName");
// Check to make sure the move result is true before continuing
if ($moveResult != true) {
    echo "ERROR: File not uploaded. Try again.";
    exit();
}
// Include the file that houses all of our custom image functions
include_once("watermarklib.php");
// ---------- Start Universal Image Resizing Function --------
$target_file = "images/$fileName";
$resized_file = "images/resized_$fileName";
$wmax = 500;
$hmax = 500;
ak_img_resize($target_file, $resized_file, $wmax, $hmax, $fileExt);
// ----------- End Universal Image Resizing Function ----------
// ---------- Start Convert to JPG Function --------
if (strtolower($fileExt) != "jpg") {
    $target_file = "images/resized_$fileName";
    $new_jpg = "images/resized_".$kaboom[0].".jpg";
    ak_img_convert_to_jpg($target_file, $new_jpg, $fileExt);
}
// ----------- End Convert to JPG Function -----------
// ---------- Start Image Watermark Function --------
$target_file = "images/resized_".$kaboom[0].".jpg";
$wtrmrk_file = "watermark.png";
$new_file = "images/protected_".$kaboom[0].".jpg";
ak_img_watermark($target_file, $wtrmrk_file, $new_file);
// ----------- End Image Watermark Function -----------
// Display things to the page so you can see what is happening for testing purposes
$kb=$fileSize/1024;
$mb=$kb/1024;
$nn=round($mb,2);
echo "The file named <strong>$fileName</strong> uploaded successfuly.<br /><br />";
echo "It is <strong>$nn</strong> MB in size.<br /><br />";
echo "It is an <strong>$fileType</strong> type of file.<br /><br />";
echo "The file extension is <strong>$fileExt</strong><br /><br />";
echo "The Error Message output for this upload is: $fileErrorMsg";
echo "</br>";

?>
<html>
<head>
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
  <a href="index.php" class="btn btn-default">Go back </a> </br>
<a href="<?php echo $new_file?>" download="<?php echo $fileName ?>" class="btn btn-success">Download</a>
</body>
</body>
</html>
<?php unlink($resized_file);
$s='images/'.$fileName;
unlink ($s);
 ?>
