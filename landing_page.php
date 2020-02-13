<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/head.php');
	session_start();
	session_destroy();
?>
<head>
	<title>Login page</title>
</head>
<style>
	body{
		background: url(/agungelektrindo/universal/images/background.jpg);
		background-repeat: repeat;
		background-size: cover;
	}
	
	#login_wrapper{
		position:fixed;
		top:10%;
		height:80%;
		width:100%;
		opacity:0;
	}
	
	#login_box{
		background-color:#326d96;
		z-index:40;
		padding:20px;
		color:white;
	}
	
	#image_box{
		background-color:white;
	}
	
	#image_box img{
		width:100%;
		position:absolute;
		margin:auto;
		top:0%;
		bottom:0%;
		left:0;
	}
	
	#login_form{
		position: relative;
		top: 50%;
		transform: translateY(-50%);
		width:80%;
	}
	
	@media only screen and (max-width: 576px){
		#image_box{
			display:none;
		}
		
		#login_box{
			margin-left:8.333333%;
		}
	}
	
	@media only screen and (min-width: 576px){
		#image_box{
			display:block;
		}
		
		#login_box{
			margin-left:0;
	}
</style>
<body>
	<div class='row' id='login_wrapper'>
		<div class='col-md-2 col-sm-2 col-md-offset-2 col-sm-offset-2 col-xs-offset-1' id='image_box'>
			<img src='/agungelektrindo/universal/images/logo.jpg'></img>
		</div>
		<div class='col-md-6 col-sm-6 col-xs-10 col-md-offset-0 col-sm-offset-0' id='login_box'>
			<form method='POST' action='login' id='login_form'>
				<h2 style='font-family:bebasneue'>Login to your account</h2>
				<input type='text' class='form-control' name='username' placeholder='Username'>
				<br>
				<input type='password' name='pass' class='form-control' placeholder='Password'>
				<br>
				<button class='button_default_dark' type='submit'>Log in</button>
			</form>
		</div>
	</div>
</body>
<script>
	$(document).ready(function(){
		$('#login_wrapper').fadeTo(2000, 1);
	});
</script>