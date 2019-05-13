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
body{
	font-family:'Fantasy'
}
.inputs{
	border:none;
	border-bottom:2px solid #eee;
	border-radius:3px;
	width:100%;
}
.inputs:focus{
	-webkit-box-shadow:none;
}
#tempatform{
	border:1px solid #ddd;
	box-shadow:10px 10px 10px grey;
}
.daniel{
	width: 100px;
	padding:10px 20px;
	background-color:transparent;
	border:2px solid #ddd;
	-webkit-transition: width 1s;
	transition: width 1s;
}
.daniel:hover{
	width:100%;
}
</style>
<?php
session_start();
session_destroy();
?>
<body style="overflow-x:hidden">
<div class="row" style='margin-top:20px;padding:40px'>
	<div class='col-md-8 col-md-offset-2' id='tempatform'>
		<div class='col-md-8' style='padding:0px'>
			<img src='universal/images/ae.png' style='width:100%'>
		</div>
		<div class="col-md-4">
			<div class='row'>
				<div class='col-md-6 col-md-offset-3' style='display:none' id='1'>
					<img src='universal/images/aecap.png' style='width:100%'>
				</div>
				<div class='col-md-3'>
				</div>
				<form style="padding:20px;width:500px" id="myForm" method="POST" action="login.php">
					<div id='2' style='display:none'>
						<label for="username" >Insert Username here:</label>
						<input type="text" placeholder="Insert your username" class="inputs" id="username" name="username">
						<br>
						<label for="password">Insert Password here:</label>
						<input type="password" id='pass' name="pass" class="inputs" placeholder="input your password">
						<br>
						<br>
						<br>
					</div>
					<button class="btn daniel" id='3' style='display:none' type='submit'>Log in</button>
				</form>
			</div>
		</div>
	</div>
</div>
<script>	
	$(document).ready(function(){
		$('#1').fadeIn(500);
		$("#2").delay(500).fadeIn(500);
		$("#3").delay(1000).fadeIn(500);
	});
</script>