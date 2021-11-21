<html>
<head>
<ul>
  <li><a href="http://localhost/MovieSite/Home.php">Home</a></li>
  <li><a href="http://localhost/MovieSite/Login.php">Login</a></li>
  <li><a href="http://localhost/MovieSite/Registration.php">Register</a></li>
  <li><a href="http://localhost/MovieSite/Search.php">Search</a></li>
</head>
<body>
<?php 
include 'Pdo.php';
session_start();
if ($_SESSION['userName'] != $_GET['id']) {
header("Location:http://localhost/MovieSite/Home.php");
exit();
}
else {
	$files = 'C:\Users\Shane\Documents\UniServerZ\www\MovieSite\files\\'.$_GET['id']. '.jpg';
	var_dump($files);
	if (isset($_FILES['Pic'])) {
		if (file_exists($files)) {
			unlink($files);
		}
		if ($_FILES['Pic']['error'] == UPLOAD_ERR_OK){  
		  $finfo = new finfo (FILEINFO_MIME_TYPE);
         $ftype = $finfo->file ($_FILES['Pic']["tmp_name"]);
		 
		 if($ftype == "image/jpeg")
		 {
			 move_uploaded_file($_FILES['Pic']["tmp_name"], "files/"
			 .$_SESSION['userName'].".jpg");
			 $image = imagecreatefromjpeg ("files/" .$_SESSION['userName'].".jpg");
$width = imagesx ($image);
$height = imagesy ($image);
$thumbWidth = 300;
$thumbHeight = floor ($height * ($thumbWidth/$width));
$thumbnail = imagecreatetruecolor ($thumbWidth, $thumbHeight);
imagecopyresampled ($thumbnail, $image, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width,
$height);
imagejpeg ($thumbnail, "files/" .$_SESSION['userName'].".jpg"); 
		 }
		 }
	}
	//gets bio
$sql = 'SELECT Bio FROM users WHERE username = :user';
$stmt = $pdo->prepare ($sql);
	$stmt->bindParam(':user', $_SESSION['userName']);
	$stmt->execute();
	$row = $stmt->fetch ();
	if (isset($_POST['Bio'])) {
		//if bio is already set changes bio
		if ($row) {
$sql = 'UPDATE users SET Bio = :Bio WHERE username = :users';
$stmt2 = $pdo->prepare ($sql);
$stmt2->bindParam(':Bio', $_POST['Bio']);
$stmt2->bindParam(':users', $_SESSION['userName']);
$stmt2->execute();
		}
		else{
$sql = 'INSERT INTO users (Bio) VALUES (:Bio) WHERE username = :users';
$stmt3 = $pdo->prepare ($sql);
$stmt3->bindParam(':Bio', $_POST['Bio']);
$stmt3->bindParam(':users', $_SESSION['userName']);
$stmt3->execute();	
		}
	}
	?>
	<form method= "POST">
Bio: <input type="text" name="Bio">
<input type="submit" value="Submit">
</form>
<form enctype="multipart/form-data" method= "POST">
Profile Pic <input type = "file" name= "Pic">
<input type="submit" value="Submit">
</form>
	<?php
}
?>
<body>
<html>