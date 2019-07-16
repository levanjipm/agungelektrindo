<head>
<title>Financial Department</title>
<script src='../universal/jquery/jquery-3.3.0.min.js'></script>
<link rel="stylesheet" href="../universal/bootstrap/4.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="../universal/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="../universal/bootstrap/3.3.7/js/bootstrap.min.js">
<script src="../universal/bootstrap/4.1.3/js/bootstrap.bundle.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="financialstyle.css">
<?php
	include("../codes/connect.php");
	session_start();
	if($_SESSION['user_id'] === NULL){
		header('location:../landing_page.php');
	}
	$sql_user = "SELECT name,role FROM users WHERE id = " . $_SESSION['user_id'];
	$result_user = $conn->query($sql_user);
	$row_user = $result_user->fetch_assoc();
	$role = $row_user['role'];
	$user_name = $row_user['name'];
	if(mysqli_num_rows($result_user) == 0){
		header('location:../landing_page.php');
	}
	$sql_otorisasi = "SELECT * FROM authorization WHERE user_id = '" . $_SESSION['user_id'] . "' AND department_id = '3'";
	$otorisasi = $conn->query($sql_otorisasi);
	if (isset( $_SESSION['user_id'] ) && mysqli_num_rows($otorisasi) != 0) {
?>
</head>
<style>
#user_button{
	background-color:transparent;
	border:none;
	color:white;
}
.dropdown {
  float: left;
  overflow: hidden;
}
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}
.dropdown-content a {
  float: none;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}
.dropdown-content a:hover {
  background-color: #ddd;
}
.dropdown:hover .dropdown-content {
  display: block;
}
</style>
<div class="sidenav">
	<div class='row'>
		<div class='col-md-6'>
			<img src='../human_resource/images/users/users.png' style='width:100%; border-radius:50%'>
		</div>
		<div class='col-md-6' style='color:white'>
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
			line-height:2.5;
		}
	</style>
	<button type='button' class='btn btn-badge dropdown-btn' style='color:white'>
		<i class="fa fa-file-o" aria-hidden="true"></i>
		Bank Account
	</button>
	<div class="dropdown-container">
		<a href='view_mutation_dashboard.php'>View mutation</a><br>
		<a href="add_transaction_dashboard.php">Add a transaction</a><br>
		<a href='reset_transaction_dashboard.php'>Reset transaction</a><br>
		<a href='#'>Assign transaction</a>
		<br>
	</div>
	<button type='button' class='btn btn-badge dropdown-btn' style='color:white'>
		<i class="fa fa-undo" aria-hidden="true"></i>
		Petty Cash
	</button>
	<div class="dropdown-container">
		<a href="petty_dashboard.php">
			<p>Add a transaction</p>
		</a>
		<a href="petty_view.php">
			<p>View table</p>
		</a>
		<a href="petty_chart.php">
			<p>View chart</p>
		</a>
	</div>
	<hr>
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
	<a href='financial.php' style='color:#1ac6ff;text-decoration:none'>
		<i class="fa fa-eercast" aria-hidden="true"></i>Financial Department
	</a>
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
</div>
<?php
} else{
	header('location:../landing_page.php');
};
?>
