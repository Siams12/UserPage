<?php
include 'Pdo.php';
session_start();
if ($_SESSION ['admin']){
	
	 if (isset($_POST['movie_name'])) {
		 $sql = 'SELECT movie_name FROM movies WHERE movie_name = :movie;';
$stmt = $pdo->prepare ($sql);
$movie_name = $_POST['movie_name'];
$stmt-> bindParam (':movie', $movie_name);
$stmt->execute ();
$row = $stmt->fetch ();

if ($row){
	echo "you used a movie that already exists";
	exit();
}

	$sql = 'INSERT INTO Movies (Movie_Name, Description, Year, Length, Genre, Studio, Poster) VALUES (:Movie_Name, :Description, :Year, :Length, :Genre, :Studio, :Poster)';
$stmt = $pdo->prepare ($sql);

$stmt->bindparam (':Poster', $Poster);
$stmt->bindParam (':Movie_Name', $movie_name);
$stmt->bindParam (':Description', $description);
$stmt->bindParam (':Year', $year);
$stmt->bindParam (':Length', $length);
$stmt->bindParam (':Genre', $genre);
$stmt->bindParam (':Studio', $studio);

$Poster = $_FILES["Poster"]["name"];
$movie_name = $_POST['movie_name'];
$description = $_POST['description'];
$year = $_POST['year'];
$length = $_POST['length'];
$genre = $_POST['genre'];
$studio = $_POST['studio'];

$stmt->execute ();
 if ($_FILES['Poster']['error'] == UPLOAD_ERR_OK){  
		  $finfo = new finfo (FILEINFO_MIME_TYPE);
         $ftype = $finfo->file ($_FILES['Poster']["tmp_name"]);
		 
		 if($ftype == "image/jpeg")
		 {
			 move_uploaded_file($_FILES['Poster']["tmp_name"], "files/"
			 .$pdo->lastInsertId().".jpg");
			 $image = imagecreatefromjpeg ("files/" .$pdo->lastInsertId().".jpg");
$width = imagesx ($image);
$height = imagesy ($image);
$thumbWidth = 300;
$thumbHeight = floor ($height * ($thumbWidth/$width));
$thumbnail = imagecreatetruecolor ($thumbWidth, $thumbHeight);
imagecopyresampled ($thumbnail, $image, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width,
$height);
imagejpeg ($thumbnail, "files/" .$pdo->lastInsertId().".jpg"); 
		 }
		 }
}
}
else {
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
<head><title></head></title>
<h1>Add movie</h1>
<body>
<form enctype="multipart/form-data" method= "POST">
movie_name: <input type="text" name="movie_name">
description:  <input type = "text" name="description">
year: <input type = "int" name="year">
length: <input type = "int" name="length">
genre: <select name="genre" >
<?php 
$result = $pdo->query ('SELECT * FROM Genres');
while ($row = $result->fetch ())
{
?><option value=  <?php echo $row['Genre_ID'] ;
?>> <?php echo $row['Genre_Name'] ?> </option>
<?php
}
?>

</select>
studio: <input type = "Studio" name="studio">
poster: <input type = "file" name= "Poster">
<input type="submit" value="Submit">
</form>
<body>