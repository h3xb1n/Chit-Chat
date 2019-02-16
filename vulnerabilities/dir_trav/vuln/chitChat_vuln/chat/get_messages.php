<?php
	session_start(); 
	$userid = $_SESSION['user_id']; 
	$friend_id = $_GET['friend_id'];

	$conn = new mysqli("127.0.0.1", "chatapp", "chatapp", "chatapp");
	if($conn->connect_error) { 

		die("Database Connection failed: ".$conn->connect_error);		}

	$query = "SELECT * FROM chat where msg_from ='".$userid."' and msg_to='".$friend_id."' or msg_from = '".$friend_id."' and msg_to='".$userid."'";
	$res = $conn->query($query);
	$arr = array();
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
