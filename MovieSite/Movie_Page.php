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
<h1> Movie </h1>
<?php 
include 'Pdo.php';
session_start();
$sql = 'SELECT * FROM movies WHERE Movie_ID = :ID;';
$stmt = $pdo->prepare ($sql);
$stmt-> bindParam (':ID', $_GET['id']);
$stmt->execute ();
$row = $stmt->fetch ();
if ($row){
	$Movie_ID = $row['Movie_ID'];
	?> Name: <?php
	echo $row['Movie_Name']
	;?> <br> Description: <?php
	echo $row['Description']; 
	?> <br> 
	Rating: 
	<?php 
	$sql = 'SELECT AVG(stars) AS AverageRating FROM ratings WHERE Movie_ID = :Movie_ID';
	$stmt2 = $pdo->prepare ($sql);
	$stmt2 -> bindParam ('Movie_ID', $Movie_ID);
	$stmt2 -> execute();
	$row2 = $stmt2->fetch();
	echo $row2['AverageRating']; 
	?> <br>
	Studio: <?php
	echo $row['Studio'];
	?> <br> Length: <?php
	echo $row['Length'];
	?> <br> Genre: <?php
	$result = $pdo->query ('SELECT * FROM Genres WHERE Genre_ID ='. $row['Genre']);
	$genre = $result->fetch ();
	echo $genre['Genre_Name'];
	?> <br> Year: <?php
	echo $row['Year']; ?> <br>
	<img src="files/<?php echo $row['Movie_ID'] ?>.jpg" alt="">
	<?php  
}
//Sets rating and updates rating. 
if (isset($_SESSION ['userName'])){
if (isset($_POST['Rating'])) {
	$sql = 'SELECT stars FROM Ratings WHERE Username = :Username AND Movie_ID = :Movie_ID';
	$stmt = $pdo->prepare ($sql);
	$stmt->bindParam (':Username', $Username);
	$stmt->bindParam (':Movie_ID', $Movie_ID);
	$Username = $_SESSION ['userName'];
	$stmt->execute ();
    $row = $stmt->fetch ();
	if ($row) {
	$sql = 'UPDATE Ratings SET stars = :stars, date = :date WHERE Username = :Username AND Movie_ID = :Movie_ID';
	}
	else {
	$sql = 'INSERT INTO ratings (stars, date, Username, Movie_ID) VALUES (:stars, :date, :Username, :Movie_ID)';
	}
	$stmt = $pdo->prepare ($sql);
	
	$stmt->bindparam (':stars', $stars);
	$stmt->bindParam (':date', $date);
	$stmt->bindParam (':Username', $Username);
	$stmt->bindParam (':Movie_ID', $Movie_ID);
	
	$stars = $_POST['Rating'];
	if ($stars == "Null") {
		$stars = Null;
	}
	$date = date('Y/m/d H:i:s', time());
	$Username = $_SESSION ['userName'];
	$stmt->execute ();
	
	header("Location:http://localhost/MovieSite/Movie_Page.php?id=".$Movie_ID);
	exit();
}
if (isset ($_POST['Comment'])){
	$sql = 'INSERT INTO comments (Username, Comment, Movie_ID) VALUES (:Username, :Comment, :Movie_ID)';
	$stmt = $pdo->prepare ($sql);
	$stmt->bindParam(':Username', $_SESSION ['userName']);
	$stmt->bindParam(':Comment', $_POST['Comment']); 
	$stmt->bindParam(':Movie_ID', $Movie_ID);
	$stmt->execute();
}
	?>
<form method= "POST">
Rating: <select name="Rating" >
<option value= "Null"> </option> 
<option value= "1">1</option>
<option value= "2">2</option>
<option value= "3">3</option>
<option value= "4">4</option>
<option value= "5">5</option>
</select>
<input type="submit" value="Submit">
</form>
<form method= "POST">
Comment: <input type="text" name="Comment">
<input type="submit" value="Submit">
</form>
<?php
}
?>
Comments: <br>
<?php
if (isset($_POST['Name1'])) {
$sql = 'INSERT INTO friend_requests(Username1, Username2) VALUES (:User1, :User2)';
$stmt = $pdo->prepare ($sql);
$stmt->bindParam(':User1', $Username1);
$stmt->bindParam(':User2', $Username2);
$Username1 = $_SESSION ['userName'];
$Username2 = $_POST['Name1'];
$stmt->execute ();
}

//Friend requests with comments
$sql = 'SELECT * FROM comments WHERE Movie_ID = :Movie_ID ORDER BY Comment_ID DESC LIMIT 10';
$stmt3 = $pdo->prepare($sql);
$stmt3->bindParam(':Movie_ID', $Movie_ID);
$stmt3->execute();
while($row3 = $stmt3->fetch()){ 
	echo'<a href ="http://localhost/MovieSite/UserPage.php?id=' .$row3['Username'].'"> '.$row3['Username']. '   ' . '</a>';
	//Make it so friends cant send friend requests to other friends.
	if (isset($_SESSION ['userName'])) {
	if ($_SESSION ['userName'] != $row3['Username']){
	?> 
	<form method= "POST">
	<input type="submit" value="Send friend request"> 
	<input type="hidden" value="<?php echo($row3['Username'])?>" name="Name1">
	</form>
	<?php
	}}
	?> <br> 
	<?php
	echo($row3['Comment']." "); 
	
?> 
<hr>
<?php 
}


?>
</body>
</html>