<?php
  session_start();
  include_once "../pages/db.php";
 ?>
<!DOCTYPE html>
<title> Signup </title>
<head>
</head>
<link rel="stylesheet" href="../style/style.css" type="text/css">
<body>
  <a href="../loginPage.php"> Back </a>
  <article>
    <form method="POST">
      <p> Username: </p>
      <input type="text" name="user">
      <p> Password: </p>
      <input type="text" name="pwd">
      <button name="signup" type="submit" value="submit">Submit</button>
    </form>
    <br>
  </article>
  <?php
  if(isset($_POST["signup"]))
 {
   $exist = false;
    $signup_username = mysqli_real_escape_string($conn,$_POST['user']);
	echo $_POST['pwd'];
    $signup_pwd = password_hash(rtrim($_POST['pwd']),PASSWORD_DEFAULT);
    $sqlcode_select = "SELECT * FROM tablelogininfo;";
    $sqlcode = "INSERT INTO tablelogininfo (`Users`,`Password`) VALUES('$signup_username','$signup_pwd');";

    $result = mysqli_query($conn,$sqlcode_select);

  while($row = mysqli_fetch_assoc($result))
  {
    if($row['Users'] == $signup_username)
    {
      echo "Username already exists !";
      $exist = true;
      break;
    }
  }

  if($exist == false){
   if(mysqli_query($conn,$sqlcode))
   {
	   echo "You have been signed up successfully !";
		mkdir("./u-"."$signup_username");
   }
  }
  }
   ?>
