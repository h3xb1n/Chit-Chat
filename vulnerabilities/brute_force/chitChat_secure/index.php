<?php
	session_start(); 
	$conn = new mysqli("127.0.0.1", "chatapp", "chatapp", "chatapp");
	if($conn->connect_error) { 
		die("Database Connection failed: ".$conn->connect_error);		}
	$ip_addr = $_SERVER['SERVER_ADDR'];
	$query = "SELECT * FROM block_ip WHERE ip_addr = '$ip_addr'";
	$res = $conn->query($query);
	if($res->num_rows>0){
		$row = $res->fetch_assoc();
		$count = $row['attempts'];
		if ($count >= 5) { 
			header("HTTP/1.1 403 Unauthorized");
			exit;
		}
	}
	if(isset($_SESSION['username'])) { 
		header("Location: ./chat/"); 
	}
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
      <li><a href="#">Login</a></li>
      </li>
    </ul>
  </div>
</nav>

<div class="container">
	<div class="row">
        <div class="span12">
    		<div class="" id="loginModal">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3>Have an Account?</h3>
              </div>
              <div class="modal-body">
                <div class="well">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#login" data-toggle="tab">Login</a></li>
                    <li><a href="#create" data-toggle="tab">Create Account</a></li>
                  </ul>
                  <div id="myTabContent" class="tab-content">
                    <div class="tab-pane active in" id="login">
                      <form class="form-horizontal" method="POST">
                        <fieldset>
                          <div id="legend">
                            <legend class="">Login</legend>
                          </div>    
                          <div class="control-group">
                            <!-- Username -->
                            <label class="control-label"  for="username">Username</label>
                            <div class="controls">
                              <input type="text" id="username" name="username" placeholder="" class="input-xlarge">
                            </div>
                          </div>
     
                          <div class="control-group">
                            <!-- Password-->
                            <label class="control-label" for="password">Password</label>
                            <div class="controls">
                              <input type="password" id="password" name="password" placeholder="" class="input-xlarge">
                            </div>
                          </div>
     
     
                          <div class="control-group">
                            <!-- Button -->
                            <div class="controls">
                              <button class="btn btn-success">Login</button>
                            </div>
                          </div>
                        </fieldset>
                      </form>                
                    </div>
                    <div class="tab-pane fade" id="create">
                      <form method="post" action="register.php" id="tab">
                        <fieldset>
                          <div id="legend">
                            <legend class="">Register</legend>
                          </div>    
                          <div class="control-group">
                            <label class="control-label"  for="username">Username</label>
                            <div class="controls">
                              <input type="text" id="username" name="username" placeholder="" class="input-xlarge">
                            </div>
                          </div>

                          <div class="control-group">
                            <label class="control-label"  for="First Name">First Name</label>
                            <div class="controls">
                              <input type="text" id="firstname" name="firstname" placeholder="" class="input-xlarge">
                            </div>
                          </div>
                          <div class="control-group">
                            <label class="control-label"  for="Last Name">Last Name</label>
                            <div class="controls">
                              <input type="text" id="lastname" name="lastname" placeholder="" class="input-xlarge">
                            </div>
                          </div>
     
                          <div class="control-group">
                            <label class="control-label" for="password">Password</label>
                            <div class="controls">
                              <input type="password" id="password" name="password" placeholder="" class="input-xlarge">
                            </div>
                          </div>

                          <div class="control-group">
                            <label class="control-label" for="confirm_password">Confirm Password</label>
                            <div class="controls">
                              <input type="password" id="confirm_password" name="confirm_password" placeholder="" class="input-xlarge">
                            </div>
                          </div>
     
                        </fieldset>
                        <div>
                          <button class="btn btn-primary">Create Account</button>
                        </div>
                      </form>
                    </div>
                </div>
              </div>
            </div>
<?php

	if($_SERVER['REQUEST_METHOD'] == 'POST') { 
		if(isset($_POST['username']) && isset($_POST['password'])) { 
		$user = $_POST['username']; 
		$pass = $_POST['password'];
		$conn = new mysqli("127.0.0.1", "chatapp", "chatapp", "chatapp");
		if($conn->connect_error) { 
			die("Database Connection failed: ".$conn->connect_error);		}
		$query = "SELECT * FROM users WHERE username='".$user."' and password=md5('".$pass."')";
		$res = $conn->query($query);
		if($res->num_rows>0) { 
			$row = $res->fetch_assoc();
			$userid = $row['user_id'];
			$username = $row['username']; 
			$_SESSION['user_id'] = $userid;  
			$_SESSION['username'] = $username;

			$conn->query("delete from online_users where user_id = '$userid'");
			$conn->query("insert into online_users values ('$userid', 'Y')");
			echo "<script>window.location='./chat/';</script>";
		}
		else { 
			$ip_addr = $_SERVER['SERVER_ADDR'];
			$query = "SELECT * FROM block_ip WHERE ip_addr = '$ip_addr'";
			$res = $conn->query($query);
			if($res->num_rows>0){
				$row = $res->fetch_assoc();
				$count = $row['attempts'];
				if ($count < 6) { 
					$count++;
					$conn->query("UPDATE block_ip SET attempts='$count' where ip_addr = '$ip_addr'");
				} //else { 
//add_something_here

				//}
			} else { 
				$query = "INSERT INTO block_ip values ( '$ip_addr', 1 )";
				$conn->query($query);
			}
?>
	<div class="alert alert-warning alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Error!</strong> Invalid Credentials. Please enter valid username and password.
<?php		}
	}}
?>
		
</div>
        </div>
	</div>
</div>
</body>
</html>

