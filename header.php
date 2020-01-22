<!DOCTYPE html>
<html lang="en">
<head>
	<script src='/agungelektrindo/universal/jquery/jquery-3.3.0.min.js'></script>
	<link rel='stylesheet' href='/agungelektrindo/universal/bootstrap/4.1.3/css/bootstrap.min.css'>
	<script src='/agungelektrindo/universal/bootstrap/4.1.3/js/bootstrap.min.js'></script>
	<link rel='stylesheet' href='/agungelektrindo/universal/fontawesome/css/font-awesome.min.css'>
	<link rel='stylesheet' href='/agungelektrindo/universal/bootstrap/3.3.7/css/bootstrap.min.css'>
	<script src='/agungelektrindo/universal/jquery/jquery-ui.js'></script>
	<link rel='stylesheet' href='/agungelektrindo/universal/jquery/jquery-ui.css'>
	<script src='/agungelektrindo/universal/numeral/numeral.js'></script>
	<script src='/agungelektrindo/universal/jquery/jquery.inputmask.bundle.js'></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<link rel="stylesheet" href='/agungelektrindo/css/style.css'>
</head>
<style>
	.option_a{
		text-decoration:none;
		color:#333;
		font-size:1.2em;
		width:100%;
	}
	
	.option_a:hover{
		text-decoration:none!important;
	}
</style>
<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/codes/connect.php');
	session_start();
	$sql_user 			= "SELECT isactive,name,role,hpp FROM users WHERE id = '" . $_SESSION['user_id'] . "'";
	$result_user 		= $conn->query($sql_user);
	$row_user 			= $result_user->fetch_assoc();
	$name 				= $row_user['name'];
	$role 				= $row_user['role'];
	$hpp 				= $row_user['hpp'];
	$isactive 			= $row_user['isactive'];
	if (empty($_SESSION['user_id']) && $isactive != 1) {
?>
	<script>
		window.location.href='/agungelektrindo/codes/logout.php';
	</script>
<?php
	}
?>
<body>
<div class='loading_wrapper_initial'>
	<div class='loading_wrapper'>
		<h2 style='font-size:8em'><i class='fa fa-circle-o-notch fa-spin'></i></h2>
	</div>
</div>
<script>
	$( window ).on( "load", function() {
		// $('.main').hide();
		$('.loading_wrapper_initial').show;
	});
	
	$(document).ready(function(){
		$('.loading_wrapper_initial').fadeOut(300);
		$('.main').fadeIn(400);
	});
</script>
<div class='top_navigation_bar'>
	<div class='col-lg-4 col-md-5 col-sm-6 col-xs-8'>
		<a href='/agungelektrindo/dashboard/user_dashboard' style='text-decoration:none;display:inline-block;color:white'>
			<h2 style='font-family:bebasneue'>AgungElektrindo</h2>
		</a>
	</div>
	<div class='col-lg-2 col-md-4 col-sm-3 col-xs-4 col-lg-offset-6 col-md-offset-3 col-sm-offset-3 col-xs-offset-0' style='float:right'>
		<button type='button' id='profile_top_nav_button'><h3 style='font-family:Bebasneue'><?= $name ?></h3></button>
	</div>
</div>
<div class='profile_option_wrapper'>
<?php	if($role	== 'superadmin'){ ?>
	<a href='/dutasaptaenergi' class='option_a'><p style='font-family:museo'>Duta Sapta</p></a>
<?php } ?>
	<a href='/agungelektrindo/codes/logout' class='option_a'><p style='font-family:museo'>Logout</p></a>
</div>
<script>
	$('#profile_top_nav_button').click(function(){
		$('.profile_option_wrapper').toggle(300);
	});
</script>