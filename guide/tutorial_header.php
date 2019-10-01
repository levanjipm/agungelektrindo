<head>
<title>Tutorial</title>
<script src='../universal/jquery/jquery-3.3.0.min.js'></script>
<link rel="stylesheet" href="../universal/bootstrap/4.1.3/css/bootstrap.min.css">
<script src="../universal/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../universal/fontawesome/css/font-awesome.min.css">
<link rel="stylesheet" href="../universal/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="tutorial.css">
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<?php
	include('../codes/connect.php');
	session_start();
	$sql_user 		= "SELECT role,username,name,mail FROM users WHERE id = '" . $_SESSION['user_id'] . "'";
	$result_user 	= $conn->query($sql_user);
	$row_user 		= $result_user->fetch_assoc();
	$name 			= $row_user['name'];
?>
<div class='top_navigation_bar'>
	<div class='col-lg-4 col-md-5 col-sm-6 col-xs-8'>
		<a href='../human_resource/user_dashboard' style='text-decoration:none;display:inline-block'>
			<img src='../universal/images/agungelektrindo_header.png' style='height:50px;'>
		</a>
	</div>
	<div class='col-lg-2 col-md-4 col-sm-4 col-xs-4 col-lg-offset-6 col-md-offset-3 col-sm-offset-1 col-xs-offset-0' style='text-align:right'>
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
	<a href='tutorial' style='color:#1ac6ff;text-decoration:none'>
		<i class="fa fa-eercast" aria-hidden="true"></i>
		Tutorial
	</a>
</div>