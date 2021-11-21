<?php
include 'Pdo.php';

if (isset($_POST['name'])) {
$sql = 'SELECT  Last_Failed_Login, username, password, admin FROM users WHERE username = :User;';
$stmt = $pdo->prepare ($sql);
$Username = $_POST['name'];
$stmt-> bindParam (':User', $Username);
$stmt->execute ();
$row = $stmt->fetch ();
if ($row){
	if ($row['Last_Failed_Login'] != NULL){
$query=$pdo->prepare('SELECT TIMESTAMPDIFF(SECOND, Last_Failed_Login, NOW()) as timediff FROM users WHERE username = :User');
$query->bindvalue(':User', $_POST['name']);
$query->execute();
$row2 = $query->fetch();
var_dump($row2);
	}
if ($row['Last_Failed_Login'] == NULL || $row2['timediff'] > 60){ 
	$Password = $_POST['password'];
	if (password_verify ($Password, $row['password'])) {
		session_start();
		session_regenerate_id(true);
		$_SESSION ['userName'] = $row['username'];
		$_SESSION ['admin'] = $row['admin'];
		var_dump($row);
	}	
		else {
			echo "Passwords do not match";
			$sql2 = 'UPDATE users SET Last_Failed_Login = NOW() WHERE username = :User';
			$stmt2 = $pdo->prepare ($sql2);
			$stmt2->bindparam(':User', $Username3);
			$Username3 = $_POST['name'];
			$stmt2->execute();
			exit();
		}
}
else{
	echo("User has already attempted to sign in wrong recently");
	exit();
}
}
else {
	echo "User does not exist.";
	exit();
}

header("Location:http://localhost/MovieSite/Home.php");
exit();
}
?>
<html>
<link rel="stylesheet" href="Navigation Bar.css">
<ul>
  <li><a href="http://localhost/MovieSite/Home.php">Home</a></li>
  <li><a href="http://localhost/MovieSite/Login.php">Login</a></li>
  <li><a href="http://localhost/MovieSite/Registration.php">Register</a></li>
  <li><a href="http://localhost/MovieSite/Search.php">Search</a></li>
</ul>
<head><title> Login </head></title>
<body>
<h1> Login Page </h1>

<form method= "POST">
name: <input type="text" name="name">
password: <input type = "password" name="password" placeholder="***************">
<input type="submit" value="Submit">
</form>

<a href="http://localhost/MovieSite/Home.php">Homepage</a>
<a href="http://localhost/MovieSite/Registration.php">Not registered? Register now!</a>


<body>
<html>