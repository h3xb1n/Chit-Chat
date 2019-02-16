<?php
	session_start(); 
	$userid = $_SESSION['user_id']; 
	$friend_id = $_GET['friend_id'];
	$timestamp = $_GET['time'];

	$conn = new mysqli("127.0.0.1", "chatapp", "chatapp", "chatapp");
	if($conn->connect_error) { 

		die("Database Connection failed: ".$conn->connect_error);		}

	$query = "SELECT * FROM chat where msg_from ='".$friend_id."' and msg_to='".$userid."' and time > '" . $timestamp . "'";
	$res = $conn->query($query);
	echo "'[";
	while($row = $res->fetch_assoc()){ 
		@	$msg->from = $row['msg_from']; 
			$msg->to = $row['msg_to'];
			$msg->msg = $row['msg'];
			$msg->timestamp = $row['time'];
			echo json_encode($msg).","; 
	}
	echo "]'";
?>
