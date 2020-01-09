<?php
session_start();
include_once "pages/db.php";
?>
<!DOCTYPE html>
<html>
<title>Log</title>
<head></head>
<link rel="stylesheet" href="style/style.css" type="text/css">
<body>
<div>
	<p class="add"> Enter credentials : </p>
	<form method="POST">
		<p> User:</p>
		<input name="username" type="text" placeholder="Username">
		<p> Pw: </p>
		<input name="password" type="password" placeholder="Password">
		<br>
		<br>
		<button name ="submit" type="submit" value ="submit" autofocus>Log in</button>
	</form>
<div>
<a class="signin" href="pages/signup.php">Sign in</a>

<?php
if(isset($_POST["submit"]))
{
	$dbServername = 'localhost';
	$dbAdmin = 'root';
	$dbPassword = '';
	$dbName = 'table2';

	$conn = mysqli_connect($dbServername,$dbAdmin,$dbPassword,$dbName);

	$increment = 0;
	$pw_check = 0;
	$bool = false;
	$username = $_POST['username'];
	$password = rtrim($_POST['password']);

	$_SESSION['username'] = $username;

	$sqlcode = "SELECT * FROM tablelogininfo;";
	$result = mysqli_query($conn,$sqlcode);

	while($row = mysqli_fetch_assoc($result)){
		$increment++;
		if($row['Users']==$username){
			$bool = true;
			break;
		}
	}
	$result = mysqli_query($conn,$sqlcode);
	while($pw_check != $increment){
		$row = mysqli_fetch_assoc($result);
		$pw_check++;
	}

	if($bool == false)
		echo "User does not exist.";
	elseif($bool == true) //if user exists
		if(!password_verify($password,$row['Password']))
		{
			echo $row['Password'];
			echo "\r\n";
			echo "$password";
			echo "Wrong password.";
		}
		else	{
			if($row['Users'] == 'Test2')
			header("Location: pages/admin_logged.php");
			else {
			header("Location: pages/logged.php");
			}
		}

}
	
?>

</body>
</html>
