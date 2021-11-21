<html>
<?php
include 'Pdo.php';
session_start();
?>
<head>
<h1> User </h1>
<ul>
  <li><a href="http://localhost/MovieSite/Home.php">Home</a></li>
  <li><a href="http://localhost/MovieSite/Login.php">Login</a></li>
  <li><a href="http://localhost/MovieSite/Registration.php">Register</a></li>
  <li><a href="http://localhost/MovieSite/Search.php">Search</a></li>
<?php
?>
<head>
<body>
<?php
$sql = 'SELECT * FROM users WHERE username = :User';
$stmt3 = $pdo->prepare ($sql);
$stmt3-> bindParam (':User', $_GET['id']);
$stmt3->execute ();
$row = $stmt3->fetch ();
if ($row) {
	?>
	Name: 
	<?php echo $row['username'];
	?>
	<br>
	<img src="files/<?php echo ($_GET['id']) ?>.jpg" alt="">
	<br>Bio: 
	<?php 
		echo $row['Bio'];
	?>
	<br> Signed Up:
	<?php
	echo $row['date_signed_up']; 
	?>
	<br> 
	<?php
}
if ($_SESSION['userName'] == $row['username']) {	  
  echo '<p><a href = "http://localhost/MovieSite/EditPage.php?id='.($row['username']).'"> Edit Page</a></p>';
}
?>
<h2> Friends</h2>
<?php 
$sql = 'Select * FROM friends WHERE Username1 = :This_User LIMIT 10';
$stmt = $pdo->prepare ($sql);
$stmt -> bindParam (':This_User', $row['username']);
$stmt->execute ();
while($row2 = $stmt->fetch ()) { 
      echo($row2['Username2']);
}
?>
<h2> Recently Rated </h2>
<?php
$sql = 'SELECT * FROM ratings, movies 
WHERE ratings.Username = :name 
AND 
ratings.Movie_ID = movies.Movie_ID ORDER BY ratings.date DESC LIMIT 10';
$stmt2 = $pdo->prepare ($sql);
$stmt2-> bindParam (':name', $row['username']);
$stmt2->execute ();
while ($row3 = $stmt2->fetch()) {
	echo($row3['Movie_Name']. ' ');
	echo ($row3['date']);
	?>
	<br>
	<?php
	echo($row3['stars']);
	?>
	<br> <br>
	<?php
}
?>
<body>
<html>