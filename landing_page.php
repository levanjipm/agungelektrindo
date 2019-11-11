<!DOCTYPE html>
<head>
	<title>Login Page</title>
	<link rel="stylesheet" href="universal/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="universal/Jquery/jquery-3.3.0.min.js"></script>
	<script src="universal/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="universal/bootstrap/3.3.7/css/bootstrap.min.css"> 
</head>
<?php
session_start();
session_destroy();
?>
<style>
	@font-face {
	  font-family: Bebasneue;
	  src: url(Universal/Font/Bebasneue/BebasNeue.woff);
	}
	
	body{
		background-color:#2B3940;
	}
	
	.form-control{
		border-radius:0;
	}
	
	.button_default_light{
		outline:none;
		padding:5px 20px;
		background-color:#008080;
		border:none;
		color:white;
	}
	
	.login_box{
		position:fixed;
		top:20%;
		height:60%;
		min-height:200px;
		color:#333;
		background-color:#fff;
		box-shadow:3px 3px 3px 3px #333;
	}
	
	.form_label{
		position:fixed;
		top:15%;
		background-color:white;
		border:none;
		padding-left:10px;
		padding-right:10px;
	}
</style>
<body>
<div class="row" style='display:none' id='login_wrapper_box'>
	<div class='col-md-6 col-sm-10 col-xs-12  col-md-offset-3 col-sm-offset-1 col-xs-offset-0 login_box'>
		<form style="padding:20px" method="POST" action="login" style='z-index:40!important'>
			<h2 style='font-family:bebasneue'>Member Login</h2>
			<label>Username</label>
			<input type="text" placeholder="Username" class="form-control" id="username" name="username">
			<label>Password</label>
			<input type="password" id='pass' name="pass" class="form-control" placeholder="Password">
			<br>
			<button class="button_default_light" id='3' type='submit'>Log in</button>
		</form>
		
	</div>
</div>
</body>
<script>
	$(document).ready(function(){
		$('#login_wrapper_box').fadeIn(300);
	});
</script>