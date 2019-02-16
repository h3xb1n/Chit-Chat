<?php
	session_start(); 
?>
<html>
<head>
	<title>chitChat: Chat App</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link rel="stylesheet" href="./bootstrap.min.css">
		<script src="./jquery.min.js"></script>
		<script src="./bootstrap.min.js"></script>
</head>
<nav class="navbar navbar-inverse" role="navigation">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="#">chitChat</a>
  </div>

  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav navbar-right">
      <li><a href="./index.php">Login</a></li>
      </li>
    </ul>
  </div>
</nav>

<div class="container">
	<div class="row">
        <div class="span12">
<?php
		if($_SERVER['REQUEST_METHOD'] == "POST") { 
			if(!empty($_POST['username']) && !empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['password']) && !empty($_POST['confirm_password'])) { 
				$username = $_POST['username']; 
				$firstname = $_POST['firstname']; 
				$lastname = $_POST['lastname']; 
				$password = $_POST['password'];
				$confirm_password = $_POST['confirm_password'];
				if($password != $confirm_password) { 
?>

	<div class="alert alert-warning alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Error!</strong> Password Mismatch.
<?
					die(""); 
				}

				$conn = new mysqli("127.0.0.1", "chatapp", "chatapp", "chatapp");
				if($conn->connect_error) { 
					die("Database Connection failed: ".$conn->connect_error);		}
				$query 	= "INSERT INTO users (username, firstname, lastname, password) values ( '$username', '$firstname', '$lastname', md5('$password'))";
				
				$res = $conn->query($query); 
				if($res) { 
		?>
	<div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Done!</strong> Register Successfully, Please login.
					
<?php
				}	

		}
			else { 
?>
	<div class="alert alert-warning alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Error!</strong> Please enter valid information.
<?php
			}
	}
?>
		
</div>
        </div>
	</div>
</div>
</body>
</html>

