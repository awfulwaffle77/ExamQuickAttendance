
<!DOCTYPE html>
<html>
<body>

  <?php
    echo "Hello";
  ?>

<form action="upload-manager.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html>
