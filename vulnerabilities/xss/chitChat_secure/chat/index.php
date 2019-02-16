<?php
	session_start(); 
	if(empty($_SESSION['user_id']))
		header("Location: ./../"); 
?>
<html>
<head>
	<title>chitChat: Chat App</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link rel="stylesheet" href="./bootstrap.min.css">
		<link rel="stylesheet" href="./bubble.css">
		<script src="./jquery.min.js"></script>
		<script src="./bootstrap.min.js"></script>
	<style>
		.view-body { 
			height: 60%; 
		}
		img { 
			width: 20px; 
			margin-right: 5px; 
		}
		.tab-pane { 
			height: 60%; 
			overflow-y: scroll; 
			width: 100%; 
		}
		.look { 
			width: 100%; 
			overflow: overlay; 
		}
		
	</style>
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
      <li><a href="./logout.php"><?php echo $_SESSION['username'];?> (logout)</a></li>
      </li>
    </ul>
  </div>
</nav>

<div class="container">
	<div class="modal-body row">
		<div class="col-md-4">
	 	 <div class="panel panel-default">
		  <div class="panel-heading">Friends</div>

  		 <ul class="list-group">
		 </ul>
		</div>
				
		</div>
		<div class="col-md-6">
			<div class="panel panel-default">
  			<div class="panel-heading">Messages</div>
			  <div class="panel-body tab-pane view-body">
  			</div>
			<div class="input-group">
 			 <textarea class="form-control" placeholder="Type your message here"></textarea>
			  <span class="input-group-addon">
				<button class="btn btn-default send" type="button">Send!</button>
			</span>
			</div>

		</div>
	</div>
</div>
	<script>
		$.ajax({url: "get_friend_list.php", success: function(result) { 
			$(".list-group").append(result); 
		}}); 
		var get_online_status = function(){$.ajax({url: "get_online_status.php", success: function(result) { 
			$('img').remove();
			var online = result.split(",");
			for(var i=0; i<online.length-1; i++) { 
		//		console.log(online[i]); 
				$('[id=' + online[i] + ']').prepend("<img src='online.png'>");
			}
			
			 }})}; 
		get_online_status();
		setInterval(get_online_status, 5000); 
		
		var get_messages_loop = function() { 

			var friend_id = $('.active')[0].id;

			try { 
				var last_msg_time = $('input[type=hidden]')[$('input[type=hidden]').length-1].value;
			} catch (err){
				last_msg_time = "0"; 
			}
			last_msg_time = last_msg_time.replace(":", "");
			last_msg_time = last_msg_time.replace(":", "");
			last_msg_time = last_msg_time.replace(" ", "");
			last_msg_time = last_msg_time.replace("-", "");
			last_msg_time = last_msg_time.replace("-", "");

			$.ajax({url: "get_messages_loop.php?friend_id="+friend_id+"&time="+last_msg_time, success: function(result){
				//console.log(this.url); 
			//	console.log(result); 
				res = result.slice(1, -3) + "]" ;
			//	console.log(res);
				obj = JSON.parse(res); 
			//	friend_id = (this.url).substr((this.url).lastIndexOf('=')+1);
				for(var i=0; i<obj.length; i++){
					$('.view-body').append("<div class='look'><div class='bubble me'>" + obj[i].msg.replace(/</g, "&lt").replace(/>/g, "&gt")+"</div><input type='hidden' name='timestamp' value='" + obj[i].timestamp + "'</div>");
			}
			
			}});
		};
		$(document).on('click', '.users', function(){
			$('.view-body').html(); 
			
			$('.active').removeClass('active'); 
			$(this).addClass('active'); 
			var friend_id = this.id;
			$.ajax({url: "get_messages.php?friend_id="+this.id, success: function(result) { 
				$('.view-body').html('');
			//	console.log(result);
				res = result.slice(1, -3) + "]" ;
				obj = JSON.parse(res); 
				friend_id = (this.url).substr((this.url).lastIndexOf('=')+1);
				for(var i=0; i<obj.length; i++){
					if(obj[i].from != friend_id) { 
						$('.view-body').append("<div class='look'><div class='bubble you'>" + obj[i].msg.replace(/</g, "&lt").replace(/>/g, "&gt")+"</div></div>");
					} else { 
						$('.view-body').append("<div class='look'><div class='bubble me'>" + obj[i].msg.replace(/</g, "&lt").replace(/>/g, "&gt")+"</div><input type='hidden' name='timestamp' value='" + obj[i].timestamp + "'</div>");
					}
				}
			}});
			setInterval(get_messages_loop, 3000);
		});
	
		$(document).on('click', '.send', function(){
			text = $('textarea').val();
			text1 = text.replace(/</g, "&lt").replace(/>/g, "&gt");
			if(text !== "") { 
			$('textarea').val(''); 
			friend_id = $('.active')[0].id;

			$('.view-body').append("<div class='look'><div class='bubble you'>" +text1+"</div></div>");

			$.ajax({url: "insert_message.php?friend_id=" + friend_id+"&text="+text, success: function(result) { 
				//console.log(result); 
			}});
			}
		});
		
		
		
		
	</script>
</body>
</html>
