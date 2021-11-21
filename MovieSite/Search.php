<html>
<link rel="stylesheet" href="Navigation Bar.css">
<ul>
  <li><a href="http://localhost/MovieSite/Home.php">Home</a></li>
  <li><a href="http://localhost/MovieSite/Login.php">Login</a></li>
  <li><a href="http://localhost/MovieSite/Registration.php">Register</a></li>
  <li><a href="http://localhost/MovieSite/Search.php">Search</a></li>
</ul>
<head><title> Home </head></title>
<body>
<h1> Search </h1>
<?php
include 'Pdo.php';
session_start();
if (isset($_POST['Search'])) {
$sql = 'SELECT * FROM movies WHERE Movie_Name LIKE :Moviename';
$stmt = $pdo->prepare ($sql);
$stmt-> bindValue(':Moviename', '%'.$_POST['Search'].'%'); 
$stmt->execute ();
while ($row = $stmt->fetch()){
$Id = $row['Movie_ID'];
$Name = $row['Movie_Name'];

echo '<p><a href = "http://localhost/MovieSite/Movie_Page.php?id='.$Id.'">'.$Name.'</a></p>';
}
}
?>

<form method= "POST">
<input type = "text" name = "Search">
<input type="submit" value="Submit">
</form>

</body>
</html>