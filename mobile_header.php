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
	.button_outline_dark{
		color:white;
		background-color:transparent;
		border:2px solid white;
		font-size:4em;
		width:100%;
		padding:10px;
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
		window.location.href='/agungelektrindo/codes/logout';
	</script>
<?php
	}
?>
<body style='background-color:#2B3940;width:100%;'>
<div class='loading_wrapper_initial'>
	<div class='loading_wrapper'>
		<h2 style='font-size:8em'><i class='fa fa-circle-o-notch fa-spin'></i></h2>
	</div>
</div>
<script>
	$( window ).on( "load", function() {
		$('.loading_wrapper_initial').show;
	});
	
	$(document).ready(function(){
		$('.loading_wrapper_initial').fadeOut(450);
		$('.main').fadeIn(450);
	});
</script>