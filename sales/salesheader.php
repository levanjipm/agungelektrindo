<!DOCTYPE html>
<html lang="en">
<head>
<title>
Sales Department
</title>
<script src='../universal/jquery/jquery-3.3.0.min.js'></script>
<link rel="stylesheet" href="../universal/bootstrap/4.1.3/css/bootstrap.min.css">
<script src="../universal/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../universal/fontawesome/css/font-awesome.min.css">
<link rel="stylesheet" href="../universal/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<link rel="stylesheet" href="salesstyle.css">
<?php
	include("../codes/connect.php");
	session_start();
	$sql_user = "SELECT name,role FROM users WHERE id = '" . $_SESSION['user_id'] . "'";
	$result_user = $conn->query($sql_user);
	while($row_user = $result_user->fetch_assoc()){
		$name = $row_user['name'];
		$role = $row_user['role'];
	}
	if ( isset( $_SESSION['user_id'] ) && $role = 'superadmin' || $role = 'sales_admin' ) {
?>
</head>
<body>
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
		<i class="fa fa-id-badge" aria-hidden="true"></i>
		Quotations
	</button>
	<div class="dropdown-container">
		<a href="createquotation_dashboard.php">
			<p>Create a quotation</p>
		</a>
		<a href="editquotation_dashboard.php">
			<p>Print or edit a quotation</p>
		</a>
	</div>
	<button class="btn btn-badge dropdown-btn" style='color:white'>
		<i class="fa fa-users" aria-hidden="true"></i>
		Customers
	</button>
	<div class="dropdown-container">
		<a href="addcustomer_dashboard.php">
			<p>Add Customer</p>
		</a>
		<a href="editcustomer_dashboard.php">
			<p>Edit Customer</p>
		</a>
	</div>
	<button class="btn btn-badge dropdown-btn" style='color:white'>
		<i class="fa fa-file-text" aria-hidden="true"></i>
		Sales Order
	</button>
	<div class="dropdown-container">
		<a href="createsalesorder_dashboard.php">
			<p>Create sales order</p>
		</a>
		<a href="editsalesorder_dashboard.php">
			<p>Edit sales order</p>
		</a>
	</div>
	<button class="btn btn-badge dropdown-btn" style='color:white'>
		<i class="fa fa-truck" aria-hidden="true"></i>
		Delivery address
	</button>
	<div class="dropdown-container">
		<a href="adddeliveryaddress_sales_dashboard.php">
			<p>Add delivery address</p>
		</a>
		<a href="editdeliveryaddress_sales_dashboard.php" disabled>
			<p>Edit/delete delivery address</p>
		</a>
	</div>
	<a href="check_stock.php">
		<button type='button' class='btn btn-badge'>
			<i class="fa fa-archive" aria-hidden="true"></i>
			Check Stock
		</button>
	</a>
	<button class="btn btn-badge dropdown-btn" style='color:white'>
		<i class="fa fa-undo" aria-hidden="true"></i>
		Return
	</button>
	<div class="dropdown-container">
		<a href="return_dashboard.php">
			<button type='button' class='btn btn-badge'>
				Create return
			</button>
		</a>
<?php
	if($role == 'superadmin'){
?>	
		<a href="confirm_return_dashboard.php">
			<button type='button' class='btn btn-badge'>
				Confirm return
			</button>
		</a>
<?php
	}
?>
	</div>
	<button class="btn btn-badge dropdown-btn" style='color:white'>
		<i class="fa fa-building" aria-hidden="true"></i>
		Project
	</button>
	<div class="dropdown-container">
		<a href="add_project_dashboard.php">
			<button type='button' class='btn btn-badge'>
				Add project
			</button>
		</a>
		<a href="view_project_dashboard.php">
			<button type='button' class='btn btn-badge'>
				View project
			</button>
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
	<a href='sales.php' style='color:#1ac6ff;text-decoration:none'>
		<i class="fa fa-eercast" aria-hidden="true"></i>Sales Department
	</a>
</div>
<?php
	} else {
		header('location:../landing_page.php');
	}
?>
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