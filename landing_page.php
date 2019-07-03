<DOCTYPE html>
<head>
<head>
<title>Welcome Page</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> 
</head>
<style>
@font-face {
  font-family: Bebasneue;
  src: url(Universal/Font/Bebasneue/BebasNeue.woff);
}
body{
	background-color:#222;
	color:white;
}
.inputs{
	border:none;
	border-bottom:2px solid #eee;
	border-radius:3px;
	width:100%;
	background-color:transparent;
	padding:5px;
}
.inputs:focus{
	outline:none;
}
.btn-daniel{
	padding:10px 20px;
	background-color:transparent;
	border:2px solid #ddd;
}
</style>
<?php
session_start();
session_destroy();
?>
<body style="overflow-x:hidden">
<div class="row" style='margin-top:20px;padding:40px'>
	<div class='col-md-6 col-md-offset-3' style='text-align:center'>
		<h2 style='font-family:bebasneue'>Welcome to Agung Elektrindo</h2>
		<form style="padding:20px" id="myForm" method="POST" action="login.php">
			<input type="text" placeholder="Username" class="inputs" id="username" name="username">
			<br><br>
			<input type="password" id='pass' name="pass" class="inputs" placeholder="Password">
			<br><br><br>
			<button class="btn btn-daniel" id='3' type='submit'>Log in</button>
		</form>
	</div>
</div>