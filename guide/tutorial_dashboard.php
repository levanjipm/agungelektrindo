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
	$sql_user = "SELECT id,role,username,name,mail FROM users WHERE id = '" . $_SESSION['user_id'] . "'";
	$result_user = $conn->query($sql_user);
	while($row_user = $result_user->fetch_assoc()){
		$user_id = $row_user['id'];
		$name = $row_user['name'];
	};
?>
	<div class="sidenav">
		<div class='row'>
			<div class='col-sm-12 col-md-6'>
				<img src='../human_resource/images/users/users.png' style='width:100%; border-radius:50%'>
			</div>
			<div class='col-sm-12 col-md-6' style='color:white'>
				<strong>Welcome</strong>
				<p><?= $name ?></p>
			</div>
		</div>				
		<hr>
		<style>
			.btn-badge{
				background-color:transparent;
				color:white;
				width:100%;
				text-align:left;
			}
			.dropdown-container {
				display: none;
				background-color: #262626;
				padding-left: 8px;
				line-height:2.5;
			}
		</style>
		<button type='button' class='btn btn-badge dropdown-btn' style='color:white'>
		<a href='../human_resource/user_dashboard.php' style='color:white;text-decoration:none'>
			<i class="fa fa-home" aria-hidden="true"></i>
			Back to home
		</a>
		</button>
		<a href='../codes/logout.php'>
			<button type='button' class='btn btn-badge' style='color:white'>
			<i class="fa fa-sign-out" aria-hidden="true"></i>
			Log Out
			</button>
		</a>
		<hr>
		<a href='tutorial_dashboard.php' style='color:#1ac6ff;text-decoration:none'>
			<i class="fa fa-eercast" aria-hidden="true"></i>
			Tutorial
		</a>
	</div>
	<div class='main'>
		<div class='row' style='padding-top:30px'>
			<div class='col-sm-8 col-sm-offset-2'>
				<div class='container box_notif'>
					<div class='row' style='padding:0px'>
						<div class='col-sm-4' style='padding:0px'>
							<img src='images/sales.png' style='width:100%'>
						</div>
						<div class='col-sm-8'>
							<h2>Sales Department</h2>
							<p>Learn how to operate the sales department program</p>
							<a href='tutorial_dashboard_department.php?d=sales' style='text-decoration:none;color:black'>
								<button type='button' class='btn btn-division'>Click here</button>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class='row' style='padding-top:30px'>
			<div class='col-sm-8 col-sm-offset-2'>
				<div class='container box_notif'>
					<div class='row' style='padding:0px'>
						<div class='col-sm-4' style='padding:0px'>
							<img src='images/purchasing.png' style='width:100%'>
						</div>
						<div class='col-sm-8'>
							<h2>Purchasing Department</h2>
							<p>Learn how to operate the purhchasing department program</p>
							<button type='button' class='btn btn-division'>Click here</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<style>
		.btn-division{
			border:2px solid #ac3939;
			background-color:transparent;
		}
	</style>
					