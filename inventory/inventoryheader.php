<head>
<title>Inventory Department</title>
<script src='../universal/jquery/jquery-3.3.0.min.js'></script>
<link rel="stylesheet" href="../universal/bootstrap/4.1.3/css/bootstrap.min.css">
<script src="../universal/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="inventorystyle.css">
<?php
	include("../codes/connect.php");
	session_start();
	if($_SESSION['user_id'] === NULL){
		header('location:../landing_page.php');
	}
	$sql_user = "SELECT name,role FROM users WHERE id = " . $_SESSION['user_id'];
	$result_user = $conn->query($sql_user);
	while($row_user = $result_user->fetch_assoc()){
		$role = $row_user['role'];
		$user_name = $row_user['name'];
	};
	if(mysqli_num_rows($result_user) == 0){
		header('location:../landing_page.php');
	}
	$sql_otorisasi = "SELECT * FROM otorisasi WHERE user_id = '" . $_SESSION['user_id'] . "' AND department_id = '3'";
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
		Delivery Order
	</button>
	<div class="dropdown-container">
		<a href="do_choose.php">Create a DO<span class="badge"></a>
		<br>
		<a href="edit_delivery_order_dashboard.php">Edit a DO</a>
		<br>
		<a href="confirm_do_dashboard.php">Confirm DO</a>
		<br>
		<a href='view_do_archive.php'>
			Archives
		</a>
	</div>
	<button type='button' class='btn btn-badge dropdown-btn' style='color:white'>
		<i class="fa fa-file-o" aria-hidden="true"></i>
		Goods Receipt
	</button>
	<div class="dropdown-container">
		<a href="goodreceipt_dashboard.php">
			<p>Create good receipt</p>
		</a>
<?php
	$sql_badge_2 = "SELECT COUNT(*) AS jumlah FROM code_goodreceipt WHERE isconfirm = '0'";
	$result_badge_2 = $conn->query($sql_badge_2);
	$row_badge_2 = $result_badge_2->fetch_assoc();
	$badge_2 = $row_badge_2['jumlah'];
?>
		<a href="goodreceipt_confirm_dashboard.php">
			Confirm GR<span class="badge"><?= $badge_2 ?></span>
		</a>
		<br>
		<a href='view_gr_archive.php'>
			Archives
		</a>
	</div>
<?php
	if($role == 'superadmin'){
?>
	<a href="add_event_dashboard.php">
		<button type='button' class='btn btn-badge dropdown-btn' style='color:white'>
			<i class="fa fa-calendar" aria-hidden="true"></i>
			Add an event
		</button>	
	</a>
<?php
	}
?>
	<a href="check_stock.php">
		<button type='button' class='btn btn-badge dropdown-btn' style='color:white'>
			<i class="fa fa-archive" aria-hidden="true"></i>
			Check stock
		</button>
	</a>
	<button type='button' class='btn btn-badge dropdown-btn' style='color:white'>
		<i class="fa fa-archive" aria-hidden="true"></i>
		Project
	</button>
	<div class="dropdown-container">
		<a href="project_do_dashboard.php">
			<button type='button' class='btn btn-badge' style='color:white'>
				Create DO
			</button>
		</a>
		<a href="confirm_do_dashboard_project.php">
			<button type='button' class='btn btn-badge' style='color:white'>
				Confirm DO
			</button>
		</a>
		<a href="set_project_done.php">
			<button type='button' class='btn btn-badge' style='color:white'>
				Set done
			</button>
		</a>
	</div>
	<a href="sample_dashboard.php">
		<button type='button' class='btn btn-badge dropdown-btn' style='color:white'>
			<i class="fa fa-flask" aria-hidden="true"></i>
			Samples
		</button>
	</a>
	<button type='button' class='btn btn-badge dropdown-btn' style='color:white'>
		<i class="fa fa-undo" aria-hidden="true"></i>
		Return
	</button>
	<div class="dropdown-container">
		<a href="sales_return_dashboard.php">
			<p>Sales return</p>
		</a>
		<a href="purchasing_return_dashboard.php">
			<p>Purchasing return</p>
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
	<a href='inventory.php' style='color:#1ac6ff;text-decoration:none'>
		<i class="fa fa-eercast" aria-hidden="true"></i>Inventory Department
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
	// header('location:../landing_page.php');
};
?>
