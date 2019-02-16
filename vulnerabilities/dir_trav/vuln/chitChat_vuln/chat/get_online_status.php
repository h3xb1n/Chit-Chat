<?php
	session_start(); 
	$id = $_SESSION['user_id'];
	$conn = new mysqli("127.0.0.1", "chatapp", "chatapp", "chatapp"); 
	$query = "select user_id, status from online_users 
			 where user_id in (select friend_id from friend_list
			where user_id = '$id' union select user_id from friend_list where friend_id = '$id') and status = 'Y'";
	$res = $conn->query($query); 
	while($row = $res->fetch_assoc()) { 
		echo $row['user_id'].",";
	}
	
?>
