<!DOCTYPE html>
<html lang="en">
<head>
	<script src='universal/jquery/jquery-3.3.0.min.js'></script>
	<link rel='stylesheet' href='universal/bootstrap/4.1.3/css/bootstrap.min.css'>
	<script src='universal/bootstrap/4.1.3/js/bootstrap.min.js'></script>
	<link rel='stylesheet' href='universal/fontawesome/css/font-awesome.min.css'>
	<link rel='stylesheet' href='universal/bootstrap/3.3.7/css/bootstrap.min.css'>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<link rel="stylesheet" href='css/style.css'>
<?php
	include('codes/connect.php');
	session_start();
	$sql_user 			= "SELECT isactive,name,role,hpp FROM users WHERE id = '" . $_SESSION['user_id'] . "'";
	$result_user 		= $conn->query($sql_user);
	$row_user 			= $result_user->fetch_assoc();
	$name 				= $row_user['name'];
	$role 				= $row_user['role'];
	$hpp 				= $row_user['hpp'];
	$isactive 			= $row_user['isactive'];
	
	$sql_otorisasi 		= "SELECT COUNT(*) AS jumlah_otorisasi FROM authorization WHERE department_id = '1' AND user_id = '" . $_SESSION['user_id'] . "'";
	$result_otorisasi 	= $conn->query($sql_otorisasi);
	$otorisasi 			= $result_otorisasi->fetch_assoc();
	if ($otorisasi['jumlah_otorisasi'] != 1 && $isactive != 1) {
?>
	<script>
		window.location.href='codes/logout.php';
	</script>
<?php
	}
?>
</head>
<body>
<div class='top_navigation_bar'>
	<div class='col-lg-4 col-md-5 col-sm-6 col-xs-8'>
		<a href='dashboard/user_dashboard' style='text-decoration:none;display:inline-block;color:white'>
			<h2 style='font-family:bebasneue'>AgungElektrindo</h2>
		</a>
	</div>
	<div class='col-lg-2 col-md-4 col-sm-4 col-xs-4 col-lg-offset-6 col-md-offset-3 col-sm-offset-2 col-xs-offset-0' style='text-align:right'>
		<h3 style='font-family:Bebasneue'><?= $name ?> 
			<span style='display:inline-block'>
				<a href='../codes/logout' style='padding-left:10px;text-decoration:none;color:white;' title='log out'>
					 <i class="fa fa-sign-out" aria-hidden="true"></i>
				</a>
			</span>
		</h3>
	</div>
</div>	