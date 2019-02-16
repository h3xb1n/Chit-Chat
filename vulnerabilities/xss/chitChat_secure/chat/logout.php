<?php
	session_start(); 
	$conn = new mysqli("127.0.0.1", "chatapp", "chatapp", "chatapp");
        if($conn->connect_error) { 
        	die("Database Connection failed: ".$conn->connect_error);               
	}
	$userid = $_SESSION['user_id'];
        $conn->query("delete from online_users where user_id = '$userid' limit 1");
	session_destroy(); 
        echo "<script>window.location='./../';</script>";
?>
