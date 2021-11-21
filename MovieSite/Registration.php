<html>
<link rel="stylesheet" href="Navigation Bar.css">
<ul>
  <li><a href="http://localhost/MovieSite/Home.php">Home</a></li>
  <li><a href="http://localhost/MovieSite/Login.php">Login</a></li>
  <li><a href="http://localhost/MovieSite/Registration.php">Register</a></li>
  <li><a href="http://localhost/MovieSite/Search.php">Search</a></li>
</ul>
<head><title> Registration </head></title>
<body>
<h1> Registration Page </h1>

<?php
include 'Pdo.php'
?>

<form method= "POST">
Name: <input type="text" name="name">
Email: <input type="text" name="email">
Password: <input type = "password" name="password" placeholder="***************">
<input type="submit" value="Submit">
</form>

<a href="http://localhost/MovieSite/Login.php">Already registered? Login!</a>
<a href="http://localhost/MovieSite/Home.php">Homepage</a>

<?php
if (isset($_POST['name'])) {
$sql = 'SELECT Username FROM Users WHERE Username = :User;';
$stmt = $pdo->prepare ($sql);
$Username = $_POST['name'];
$stmt-> bindParam (':User', $Username);
$stmt->execute ();
$row = $stmt->fetch ();
{

if ($row){
	echo "you used a username that already exists";
	exit();
}
}
$hash = $_POST['password'];
$hash = password_hash($hash, PASSWORD_BCRYPT);
$sql = 'INSERT INTO Users (username, Password, Email, admin, super_admin, date_signed_up)
VALUES (:Username, :hash ,:Email, :Admin, :Super_Admin,:date_signed_up)';
$stmt = $pdo->prepare ($sql);

$stmt->bindParam (':Username', $Username);
$stmt->bindParam (':hash', $hash);
$stmt->bindParam (':Email', $Email);
$stmt->bindParam (':Admin', $Admin);
$stmt->bindParam ('Super_Admin', $Super_Admin);
$stmt->bindParam ('date_signed_up', $date_signed_up);

$Username = $_POST['name'];
$Password = $hash;
$Email = $_POST['email'];
$Admin = 0;
$Super_Admin = 0;
$date_signed_up = date('Y/m/d H:i:s', time());

$stmt->execute ();



header("Location:http://localhost/MovieSite/Home.php");
exit();
}
?>

<body>
<html>