<?php
session_start();
error_reporting(0); # turn on to make the Notice disappear
?>
<!DOCTYPE html>
<html>
<title>Log</title>
<head></head>
<link rel="stylesheet" href="style.css" type="text/css">
<body>
<p class="add"> GREETINGS !</p>
<div>
	<form method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <button type="submit" value="Upload Image" name="submit"> Upload </button>
	</form>
</div>

<?php
	echo "Hello,".$_SESSION["username"]."!";
	
	if(isset($_POST["submit"])){
	$target_dir = "u-".(string)$_SESSION["username"] . "/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	
	
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "Imaginea a fost incarcata cu succes! Va multumim!";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . date("Y-m-d H-i-s") . ".jpeg");
?>
</body>
</html>
