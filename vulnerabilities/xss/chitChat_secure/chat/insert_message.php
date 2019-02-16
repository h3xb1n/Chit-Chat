<?php
	session_start(); 
	$userid = $_SESSION['user_id']; 
	$friend_id = $_GET['friend_id'];
	$datetime = date("Y-m-d H:i:s");

	$conn = new mysqli("127.0.0.1", "chatapp", "chatapp", "chatapp");
	if($conn->connect_error) { 
		die("Database Connection failed: ".$conn->connect_error);		
	}
	$text = htmlentities($_GET['text'], ENT_NOQUOTES);
	$text = mysqli_real_escape_string($conn, $text); 

	$query = "INSERT INTO chat values ('$userid','$friend_id', '$text', '$datetime')";

	$res = $conn->query($query);
	if($res)
		echo "success";
?>
