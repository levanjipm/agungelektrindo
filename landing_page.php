<!DOCTYPE html>
<head>
<title>Welcome Page</title>
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
		min-height:400px;
		color:white;
		background-color:#3f545f;
		box-shadow:3px 3px 3px 3px #171e21;
	}
	
	.login_attribute{
		position:absolute;
		right:0;
		bottom:0;
		height:100%;
		width:50%;
		background-color:#4a626e;
		z-index:-10;
	}
</style>
<body style='background-color:#2B3940'>
<div class="row">
	<div class='col-md-6 col-sm-10 col-xs-12  col-md-offset-3 col-sm-offset-1 col-xs-offset-0 login_box'>
		<div class='login_attribute'></div>
		<form style="padding:20px" id="myForm" method="POST" action="login.php" style='z-index:40!important'>
			<h2>Member Login</h2>
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