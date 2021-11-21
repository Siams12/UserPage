<?php
include 'Pdo.php';
Session_start();
 if (isset($_POST)) {
	 if ($_POST['Action'] == "Accepted") {
	 $sql = 'INSERT INTO friends (Username1, Username2) 
	 VALUES (:Sender, :Session_User)';
	 $stmt = $pdo->prepare ($sql);
	 $stmt-> bindParam (':Sender', $Sender);
	 $stmt-> bindParam (':Session_User', $Session);
     $Session = $_SESSION['userName'];
	 $Sender = $_POST['Friend'];
     $stmt->execute ();
	 
	 $sql = 'INSERT INTO friends (Username1, Username2) 
	 VALUES (:Session_User, :Sender)';
	 $stmt = $pdo->prepare ($sql);
	 $stmt-> bindParam (':Sender', $Sender);
	 $stmt-> bindParam (':Session_User', $Session);
     $Session = $_SESSION['userName'];
	 $Sender = $_POST['Friend'];
     $stmt->execute ();
	 
	 $sql = 'DELETE FROM friend_requests WHERE Username1 = :Sender AND Username2 = :Rejecter';
	 $stmt2 = $pdo->prepare ($sql);
	 $stmt2->bindparam (':Rejecter', $Rejected);
	 $stmt2->bindparam (':Sender', $Sender);
	 $Sender = $_POST['Friend'];
	 $Rejected = $_SESSION['userName'];
	 $stmt2->execute();
	 echo($_POST['Friend']); 
	 }
	 if ($_POST['Action'] == "Rejected") {
	 $sql = 'DELETE FROM friend_requests WHERE Username1 = :Sender AND Username2 = :Rejecter';
	 $stmt = $pdo->prepare ($sql);
	 $stmt->bindparam (':Rejecter', $Rejected);
	 $stmt->bindparam (':Sender', $Sender);
	 $Sender = $_POST['Friend'];
	 $Rejected = $_SESSION['userName'];
	 $stmt->execute();
	 echo($_POST['Friend']);


 }
 }

?>