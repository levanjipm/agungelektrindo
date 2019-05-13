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
	while($row_user = $result_user->fetch_assoc()){
		$role = $row_user['role'];
		$user_name = $row_user['name'];
	};
	if(mysqli_num_rows($result_user) == 0){
		header('location:../landing_page.php');
	}
	$sql_otorisasi = "SELECT * FROM otorisasi WHERE user_id = '" . $_SESSION['user_id'] . "' AND department_id = '5'";
	$result_otorisasi = $conn->query($sql_otorisasi);
	if(!$result_otorisasi){
		header('location:user_dashboard.php');
	}
?>
<body>
<div class="sidenav">
		<div class='row'>
			<div class='col-sm-12 col-md-6'>
				<img src='images/users/users.png' style='width:100%; border-radius:50%'>
			</div>
			<div class='col-sm-12 col-md-6' style='color:white'>
				<strong>Welcome</strong>
				<p><?= $user_name ?></p>
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
			}
		</style>
	<script>
		function show_menu_user(){
			$('.dropdown-content').show();
		}
		function close_menu_user(){
			$('.dropdown-content').hide();
		}
	</script>
	<button class="btn btn-badge dropdown-btn" style='color:white'>
		<i class="fa fa-users" aria-hidden="true"></i>
		Manage users
	</button>
	<div class="dropdown-content">
		<a href="add_user.php">
			<p>Add a user</p>
		</a>
		<a href="edit_user_all_dashboard.php">
			<p>Edit a user</p>
		</a>
		<a href="edit_user_dashboard.php">
			<p>Set inactive</p>
		</a>
	</div>
	<a href="create_salary_slip_dashboard.php">
		<button class='btn btn-badge' style='color:white;pointer:cursor'>
			Create salary slip
		</button>
	</a><hr>
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
	<a href='human_resource.php' style='color:#1ac6ff;text-decoration:none'>
		<i class="fa fa-eercast" aria-hidden="true"></i>Human Resource Department
	</a>
</div>
<script>
var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var dropdownContent = this.nextElementSibling;
    if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
    } else {
      dropdownContent.style.display = "block";
    }
  });
}
</script>