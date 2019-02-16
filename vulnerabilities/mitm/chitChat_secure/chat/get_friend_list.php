<?php
	session_start(); 
	$id = $_SESSION['user_id'];
	$conn = new mysqli("127.0.0.1", "chatapp", "chatapp", "chatapp"); 
//	$query = "select user_id, username, firstname, lastname from users 
//			 where user_id in (select friend_id from friend_list
//			where user_id = '$id')";
	$query = "select user_id, username, firstname, lastname from users 
			 where user_id in (select friend_id from friend_list
			where user_id = '$id' union select user_id from friend_list where friend_id = '$id')";
	$res = $conn->query($query); 
	while($row = $res->fetch_assoc()) { 
		echo "<li class='list-group-item'><button class='btn btn-default users' type='button' id='$row[user_id]'>$row[firstname] $row[lastname] ($row[username])</button></li>";
	}
	
?>
