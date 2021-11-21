<html>
<head>
<link rel="stylesheet" href="Navigation Bar.css">
<link rel="stylesheet" href="HomeStyle.css">
<script type="text/javascript" src="jquery-3.6.0.min.js"></script>
</head>
<body>
<ul>
  <li><a href="http://localhost/MovieSite/Home.php">Home</a></li>
  <li><a href="http://localhost/MovieSite/Login.php">Login</a></li>
  <li><a href="http://localhost/MovieSite/Registration.php">Register</a></li>
  <li><a href="http://localhost/MovieSite/Search.php">Search</a></li>
</ul>
<h1> Home page </h1>
<!-- Jquery and ajax stuff -->
<script> 
$(document).ready(function ()
{
$('#Accept').click (function ()
{
	var t = $(this) .data("user");
	var k = $(this) .parent();
	$.ajax({
		  //$(this).data.set.user should get element
           type: 'POST',
           url: 'JsonFriendPage.php',   // here your php file to do something with postdata
           data:
		   {
			   Friend: t,
			   Action: "Accepted"
		   },// here you set the data to send to php file
           success: function (data) {
                alert("You and " + data + " are now friends!");
				k.remove();
              }
            });

});
$('#Reject').click (function ()
{
	var t = $(this) .data("user");
	var k = $(this) .parent();
	$.ajax({
		  //$(this).data.set.user should get element
           type: 'POST',
           url: 'JsonFriendPage.php',   // here your php file to do something with postdata
           data:
		   {
			   Friend: t,
			   Action: "Rejected"
		   },// here you set the data to send to php file
           success: function (data) {
                alert("You rejected " + data + "'s friend request.");
				  k.remove();
              }
            });

});
});
</script>
<?php
include 'Pdo.php';
session_start();
//Showing friend requests
if (isset($_SESSION ['userName'])){
$sql = 'SELECT * FROM friend_requests WHERE Username2 = :currentUser';
$stmt = $pdo->prepare ($sql);
$stmt->bindparam (':currentUser', $Username2);
$Username2 = $_SESSION['userName'];
$stmt->execute ();
while ($row2 = $stmt->fetch()) {
	?> <div> <?php
	echo ($row2['Username1']." has sent a friend request.");
	?> 
	<button type="button" id = "Accept" data-user = "<?php echo($row2['Username1'])?>">Accept</button>
	<button type="button" id = "Reject" data-user = "<?php echo ($row2['Username1'])?>">Reject</button>
	</div>
	<?php
}
//Showing all movies
$sql = 'SELECT Movie_ID, Movie_Name FROM movies ORDER BY Date_Added DESC LIMIT 10';
$stmt = $pdo->prepare ($sql);
$stmt->execute ();
$Counter = 0;
?>
 <div> 
<?php
while ($row = $stmt->fetch()){
$Id = $row['Movie_ID'];
$Name = $row['Movie_Name'];
if($Counter == 5) {
	?>
	</div> <div>
	<?php
	$Counter = 0;
}
echo '<a href = "http://localhost/MovieSite/Movie_Page.php?id='.$Id.'">'.$Name.'  ' .'</a>';
$Counter = $Counter + 1;
?>
<img src="files/<?php //echo($Id); ?>.jpg" alt="">
<?php
}
	?>
	</div>
<a href="http://localhost/MovieSite/Logout.php">Logout</a>
<?php
if ($_SESSION ['admin']){
	?>
	<a href="http://localhost/MovieSite/Admin_Page.php">Admin_Page</a>
<?php
}
//Displays comments from friends.
$sql = 'SELECT * FROM comments,friends,movies 
WHERE friends.Username1 = :User 
AND comments.Username = friends.Username2 AND 
comments.Movie_ID = movies.Movie_ID 
ORDER BY comments.Date_Added DESC LIMIT 10';
$stmt3 = $pdo->prepare ($sql);
$stmt3-> bindParam (':User', $_SESSION['userName']);
$stmt3->execute ();
?> 
<h2>Friends Comments</h2>
<div id = "Friends_Comments">
<br> <br>
<?php
while ($row4 = $stmt3->fetch()) {
	echo($row4['Username']. ' '); 
	echo($row4['Movie_Name']); ?>
	<br>
	<?php
	echo($row4['Comment']); ?>
	<br> 
	<?php
}
?>
</div>
<?php
}
//Printing out the movie name and poster
else{
$sql = 'SELECT Movie_ID, Movie_Name FROM movies ORDER BY Year DESC LIMIT 10';
$stmt = $pdo->prepare ($sql);
$stmt->execute ();

while ($row = $stmt->fetch()){
$Id = $row['Movie_ID'];
$Name = $row['Movie_Name'];

echo '<p><a href = "http://localhost/MovieSite/Movie_Page.php?id='.$Id.'">'.$Name.'</a></p>';
?>
<img src="files/<?php //echo($Id); ?>.jpg" alt="">
<?php

}
	?>
<a href="http://localhost/MovieSite/Registration.php">Register</a>
<a href="http://localhost/MovieSite/Login.php">Login</a>
<?php
}
?>

<body>
<html>