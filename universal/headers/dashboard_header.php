<?php
	include('header.php');
	ini_set('date.timezone', 'Asia/Jakarta');
	
	$sql_user 		= "SELECT * FROM users WHERE id = '" . $_SESSION['user_id'] . "'";
	$result_user 	= $conn->query($sql_user);
	$row_user 		= $result_user->fetch_assoc();
	$user_id 		= $row_user['id'];
	$username 		= $row_user['username'];
	$name 			= $row_user['name'];
	$role 			= $row_user['role'];
	$email 			= $row_user['mail'];
	$nik 			= $row_user['NIK'];
	$username		= $row_user['username'];
	$address		= $row_user['address'];
	$city			= $row_user['city'];
	
	$privilege 		= $row_user['privilege'];
	$profile_pic	= $_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/human_resource/' . $row_user['image_url'];
	
	if($profile_pic == ''){
		$profile_pic = $_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/human_resource/images/users/users.png';
	}
	if(empty($_SESSION['user_id'])){ header('location:/agungelektrindo/codes/logout'); }
?>
	<script>
		$(document).ready(function(){
			setTimeout(function(){
				$('.main').fadeIn(500);
			},500);
		});
	</script>
<head>
	<link rel='stylesheet' href='/agungelektrindo/dashboard/style.css'>
	<title>User dashboard</title>
</head>