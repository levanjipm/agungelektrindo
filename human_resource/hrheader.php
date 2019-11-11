<!DOCTYPE html>
<html lang="en">
<head>
	<title>Human Resource Department</title>
	<script src='../universal/jquery/jquery-3.3.0.min.js'></script>
	<link rel="stylesheet" href="../universal/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="../universal/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../universal/fontawesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="../universal/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="hrstyle.css">
</head>
<?php
	include("../codes/connect.php");
	session_start();
	if($_SESSION['user_id'] === NULL){
		header('location:../landing_page.php');
	}
	$sql_user = "SELECT name, role FROM users WHERE id = " . $_SESSION['user_id'];
	$result_user = $conn->query($sql_user);
	$row_user = $result_user->fetch_assoc();
	$role = $row_user['role'];
	$name = $row_user['name'];
	
	if(mysqli_num_rows($result_user) == 0){
		header('location:../landing_page.php');
	}
	$sql_otorisasi = "SELECT * FROM authorization WHERE user_id = '" . $_SESSION['user_id'] . "' AND department_id = '5'";
	$result_otorisasi = $conn->query($sql_otorisasi);
	if(!$result_otorisasi){
		header('location:user_dashboard.php');
	}
?>
<body>
<div class='top_navigation_bar'>
	<div class='col-lg-4 col-md-5 col-sm-6 col-xs-8'>
		<a href='../human_resource/user_dashboard' style='text-decoration:none'>
			<img src='../universal/images/agungelektrindo_header.png' style='height:50px;'>
		</a>
	</div>
	<div class='col-lg-2 col-md-3 col-sm-4 col-xs-4 col-lg-offset-6 col-md-offset-4 col-sm-offset-2 col-xs-offset-0' style='text-align:right'>
		<h3 style='font-family:Bebasneue'><?= $name ?> 
			<span style='display:inline-block'>
				<a href='../codes/logout' style='padding-left:10px;text-decoration:none;color:white;' title='log out'>
					 <i class="fa fa-sign-out" aria-hidden="true"></i>
				</a>
			</span>
		</h3>
	</div>
</div>
<div class="sidenav">		
	<button type='button' class='btn-badge' style='text-align:right' id='hide_side_button'>
		<i class="fa fa-chevron-left" aria-hidden="true"></i><i class="fa fa-chevron-left" aria-hidden="true"></i>
	</button>
	<button class="btn-badge dropdown-btn" style='color:white'>
		<i class="fa fa-users" aria-hidden="true"></i>
		Manage users
	</button>
	<div class="dropdown-container">
		<a href="add_user">
			<p>Add a user</p>
		</a>
		<a href='set_inactive_dashboard'>
			<p>Set inactive</p>
		</a>
	</div>
	<a href="create_salary_slip_dashboard">
		<button class='btn-badge' style='color:white;pointer:cursor'>
			Salary slip
		</button>
	</a>
	<a href="absentee_edit_dashboard">
		<button class='btn-badge' style='color:white;pointer:cursor'>
			Absentee List
		</button>
	</a>
	<hr>
	<a href='human_resource' style='color:#1ac6ff;text-decoration:none'>
		<i class="fa fa-eercast" aria-hidden="true"></i>Human Resource Department
	</a>
</div>
<script>
	$('.dropdown-btn').click(function(){
		if($(this).next().is(':visible')){
			$(this).css('color','white');
		} else {
			$(this).css('color','#00ccff');
		}
		$(this).next().toggle(350);
	});
</script>