<!DOCTYPE html>
<head>
	<title>Login Page</title>
	<link rel="stylesheet" href="universal/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="universal/jquery/jquery-3.3.0.min.js"></script>
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
	  src: url(universal/Font/BebasNeue.woff);
	}
	
	body{
		background-color:#2B3940;
		color:white;
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
<div class="row" style='display:none;margin:0' id='login_wrapper_box'>
	<div class='col-lg-6 col-md-10 col-sm-10 col-xs-12 col-lg-offset-3 col-md-offset-1 col-sm-offset-1 col-xs-offset-0'>
		<form style="padding:20px" method="POST" action="login" style='z-index:40!important'>
			<h2 style='font-family:bebasneue'>Member Login</h2>
			<label>Username</label>
			<input type="text" placeholder="Username" class="form-control" id="username" name="username">
			
			<br>
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